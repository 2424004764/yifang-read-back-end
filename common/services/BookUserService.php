<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/25 0025
 * Time: 20:51
 */

namespace app\common\services;

use app\common\entity\BookUserEntity;
use app\common\repository\BookUserRepository;
use app\common\UtilFunction;
use Hautelook\Phpass\PasswordHash; // 使用 https://packagist.org/packages/hautelook/phpass

class BookUserService extends BaseService
{
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

        $this->Entity->user_nikename = $params['nikenamne'];
        !empty($params['sex']) && $this->Entity->sex = $params['sex'];
        !empty($params['birthday']) && $this->Entity->birthday = $params['birthday'];
        $this->Entity->password = $password;
        $this->Entity->bind_email = $params['email'];

        return parent::insert($this->Entity);
    }

}