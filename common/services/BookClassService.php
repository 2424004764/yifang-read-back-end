<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/26 0026
 * Time: 14:47
 */

namespace app\common\services;


use app\common\entity\BookClassEntity;
use app\common\repository\BookClassRepository;

class BookClassService extends BaseService
{
    private BookClassRepository $_bookClassRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookClassRepository = new BookClassRepository;
        $this->Entity = new BookClassEntity; // 初始化查询的Entity
    }

}