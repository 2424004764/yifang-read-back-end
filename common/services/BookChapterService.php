<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/5 0005
 * Time: 16:23
 */

namespace app\common\services;


use app\common\entity\BookChapterEntity;
use app\common\repository\BookChapterRepository;

class BookChapterService extends BaseService
{

    private BookChapterRepository $_bookChapterRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookChapterRepository = new BookChapterRepository;
        $this->Entity = new BookChapterEntity;
    }

}