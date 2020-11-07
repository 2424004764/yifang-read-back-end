<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/7 0007
 * Time: 18:55
 */

namespace app\common\services;


use app\common\entity\BookChapterContentEntity;
use app\common\repository\BookChapterContentRepository;

class BookChapterContentService extends BaseService
{

    private BookChapterContentRepository $_bookChapterContentRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookChapterContentRepository = new BookChapterContentRepository;
        $this->Entity = new BookChapterContentEntity;
    }

}