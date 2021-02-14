<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/2/14 0014
 * Time: 14:42
 */

namespace app\common\services;


use app\common\entity\BookHistoryEntity;
use app\common\repository\BookHistoryRepository;

class BookHistoryService extends BaseService
{
    private BookHistoryRepository $_BookHistoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_BookHistoryRepository = new BookHistoryRepository();
        $this->Entity = new BookHistoryEntity;
    }
}