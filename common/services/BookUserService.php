<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/25 0025
 * Time: 20:51
 */

namespace app\common\services;

use app\common\AdditionalCacheData;
use app\common\entity\BookUserEntity;
use app\common\repository\BookUserRepository;
use app\common\UtilFunction;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorInfo;
use app\common\utTrait\QueryParams;
use Hautelook\Phpass\PasswordHash;

// 使用 https://packagist.org/packages/hautelook/phpass

class BookUserService extends BaseService
{

    public string $name_prefix = "一方书友"; // 昵称为空时填充的昵称前缀
    // 默认头像 不直接插入到数据库
    public string $default_head_img = 'http://cdn.fologde.com//yifangread/default_head_img.png';

    public static int $STATUS_ENABLE = 0; // 状态正常
    public static int $STATUS_DISABLE = 1; // 用户已禁用

    private BookUserRepository $_bookUserRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookUserRepository = new BookUserRepository;
        $this->Entity = new BookUserEntity; // 初始化查询的Entity
    }

    /**
     * 生成默认头像
     * @return string
     */
    public function generateDefaultAvatar()
    {
        // 根据域名拼接本地图片文件
//        return UtilFunction::getDomain().$this->default_head_img;

        return $this->default_head_img;
    }

    /**
     * 注册
     * @param array $params
     * @return \app\common\BaseAR|bool|void
     */
    public function register($params)
    {

        $passwordHasher = new PasswordHash(8, false);
        $password = $passwordHasher->HashPassword($params['password']); // 生成密码

        $this->Entity->user_nickname = $params['nickname'];
        !empty($params['sex']) && $this->Entity->sex = $params['sex'];
        !empty($params['birthday']) && $this->Entity->birthday = $params['birthday'];
        $this->Entity->password = $password;
        $this->Entity->bind_email = $params['email'];

        // 是否需要自动生成昵称
        /** @var BookUserEntity|null $user 创建之后的user entity */
        if (false !== ($user = parent::insert($this->Entity))) {
            // 如果昵称为空  则自动生成昵称
            if (empty($params['nickname'])) {
                $nickname = $this->name_prefix . $user->user_id;
                $this->Entity->user_nickname = $nickname;
                $user = false !== $this->save() ? $this->Entity : false;
            }
            // 注册默认是没有头像的  所以返回一张默认的头像
            $user->user_headimg = $this->generateDefaultAvatar();

            // 将密码删除后返回
            unset($user['password']);

            // 发送uid到用户邮箱
            $subject = \Yii::$app->params['appName'];
            $content = "<h1>你好，恭喜注册成功！</h1><p>你的一方阅读书号为：{$user->user_id}</p>
                <p>注册时间：{$user->create_on}</p>";
            UtilFunction::toEmailSend($user->bind_email, $subject, $content);
        }

        return $user;
    }

    /**
     * 登录
     * @param array $params
     * @return array|bool|BookUserEntity
     * @throws \Exception
     */
    public function login(array $params)
    {
        $user = null;
        $passwordHasher = new PasswordHash(8, false);
        $queryParams = new QueryParams();
        $queryParams->select = 'user_id, user_nickname, user_headimg, sex, status, birthday, password, bind_email, create_on';
        switch (AdditionalCacheData::$ID_OR_EMAIL) {
            case 1:
                // uid 登录
                $queryParams->andWhere([
                    'user_id' => $params['idOrEmail']
                ]);
                break;
            case 2:
                // email 登录
                $queryParams->andWhere([
                    'bind_email' => $params['idOrEmail']
                ]);
                break;
            default:
                return self::setAndReturn(ErrorCode::SYSTEM_ERROR);
        }
        $user = $this->_bookUserRepository->getItem($queryParams, $this->Entity);
        /** @var BookUserEntity $user */
        $user = isset($user[0]) ? $user[0] : false;

        if ($user) {
            if ($user->status == self::$STATUS_DISABLE) {
                return self::setAndReturn(ErrorCode::USER_DISABLE);
            }
            if (!$passwordHasher->CheckPassword($params['password'], $user->password)) {
                return self::setAndReturn(ErrorCode::USER_ACCOUNT_NOT_EXIST);
            }
            // 如果用户头像为空  则返回一张默认头像图片地址
            empty($user->user_headimg) && $user->user_headimg = $this->generateDefaultAvatar();

            // 将密码删除后返回
            unset($user->password);
        }

        return $user;
    }

    /**
     * 用户能修改的字段
     */
    public function getCanUpdateFields()
    {
        $fields = $this->Entity->attributes();

        $not_update_fields = ['user_id', 'status', 'password_salt', 'password', 'create_on']; // 不能修改的字段

        foreach ($fields as $index => $field) {
            if (in_array($field, $not_update_fields)) {
                unset($fields[$index]);
            }
        }

        return array_values($fields);
    }

    /**
     * 修改用户信息
     * @param $params array
     * @return bool
     */
    public function updateUsrInfo($params)
    {
        $canUpdateFields = $this->getCanUpdateFields();

        $queryParams = new QueryParams();
        $queryParams->where([
            'user_id' => $params['user_id']
        ]);
        $this->Entity = $this->getItem($queryParams, true);

        if (empty($this->Entity)) {
            return self::setAndReturn(ErrorCode::USER_ACCOUNT_NOT_EXIST);
        }

        foreach ($canUpdateFields as $field) {
            $paramValue = (string)$params[$field];
            if ('' != $paramValue) {
                $this->Entity->$field = $paramValue;
            }
        }

        // 保存字段
        return $this->save();
    }

}