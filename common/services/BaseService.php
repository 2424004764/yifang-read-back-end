<?php
namespace app\common\services;

use app\common\entity\BookClassEntity;
use app\common\repository\BaseRepository;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorTrain;

class BaseService
{
    use ErrorTrain;

    private BaseRepository $_baseRepository;

    public function __construct()
    {
        $this->_baseRepository = new BaseRepository;
    }

    /**
     * 获取分类 适合简单的查询
     * @param $queryParams
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public function getItem($queryParams)
    {
        try {
            $queryEntity = new BookClassEntity;
            return $this->_baseRepository->getItem($queryParams, $queryEntity);
        } catch (\Exception $e) {
            return self::setAndReturn(ErrorCode::FAILURE, $e->getMessage());
        }
    }
}