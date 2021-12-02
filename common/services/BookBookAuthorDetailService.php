<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/3 0003
 * Time: 11:38
 */

namespace app\common\services;


use app\common\entity\BookAuthorDetailEntity;
use app\common\repository\BookBookAuthDetailRepository;

class BookBookAuthorDetailService extends BaseService
{
    private BookBookAuthDetailRepository $_bookBookAuthDetailRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookBookAuthDetailRepository = new BookBookAuthDetailRepository;
        $this->Entity = new BookAuthorDetailEntity;
    }

}