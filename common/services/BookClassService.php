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
use app\common\train\error\ErrorCode;

class BookClassService extends BaseService
{
    private $_bookClassRepository = null; // 服务对应的操作数据库的类

    public function __construct()
    {
        $this->_bookClassRepository = new BookClassRepository;
    }

    public function getItem($entity)
    {
        try {
            // 发起查询前  效验参数

            return $this->_bookClassRepository->getItem($entity);
        } catch (\Exception $e) {
            return self::setAndReturn(ErrorCode::FAILURE, $e->getMessage());
        }
    }
}