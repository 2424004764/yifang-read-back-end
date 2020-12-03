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
use app\common\utTrait\QueryParams;
use Hautelook\Phpass\PasswordHash; // 使用 https://packagist.org/packages/hautelook/phpass

class BookUserService extends BaseService
{

    public string $name_prefix = "一方书友"; // 昵称为空时填充的昵称前缀
    // 默认头像 不直接插入到数据库，会占用数据库存储空间  会保证根目录在web下
    public string $default_head_img = '/img/default_head_img.png';

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
     * 插入一条数据  组装好填充数据的entity
     * @param array $params
     * @return \app\common\BaseAR|bool|void
     */
    public function register($params)
    {

        $passwordHasher = new PasswordHash(8,false);
        $password = $passwordHasher->HashPassword($params['password']); // 生成密码

        $this->Entity->user_nickname = $params['nickname'];
        $this->Entity->user_headimg = UtilFunction::getDomain().$this->default_head_img;
        !empty($params['sex']) && $this->Entity->sex = $params['sex'];
        !empty($params['birthday']) && $this->Entity->birthday = $params['birthday'];
        $this->Entity->password = $password;
        $this->Entity->bind_email = $params['email'];

        return parent::insert($this->Entity);
    }

    /**
     * 登录
     * @param array $params
     * @return array|bool
     * @throws \Exception
     */
    public function login(array $params)
    {
        $user = null;
        $passwordHasher = new PasswordHash(8,false);
        $queryParams = new QueryParams();
        $queryParams->select = 'user_id, user_nickname, user_headimg, sex, status, birthday, password, bind_email, create_on';
        switch (AdditionalCacheData::$ID_OR_EMAIL){
            case 1:
                // uid 登录
                $queryParams->andWhere([
                    'user_id'   =>  $params['idOrEmail']
                ]);
                break;
            case 2:
                // email 登录
                $queryParams->andWhere([
                    'bind_email'   =>  $params['idOrEmail']
                ]);
            break;
            default:
                return self::setAndReturn(ErrorCode::SYSTEM_ERROR);
        }
        $user = $this->_bookUserRepository->getItem($queryParams, $this->Entity);
        $user = isset($user[0]) ? $user[0] : [];

        if($user){
            if($user->status == self::$STATUS_DISABLE){
                return self::setAndReturn(ErrorCode::USER_DISABLE);
            }
            if(!$passwordHasher->CheckPassword($params['password'], $user->password)){
                return self::setAndReturn(ErrorCode::USER_ACCOUNT_NOT_EXIST);
            }
        }
        unset($user->password);
        return $user;
    }

}