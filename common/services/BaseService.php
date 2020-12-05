<?php
namespace app\common\services;

use app\common\BaseAR;
use app\common\entity\BookBookEntity;
use app\common\entity\BookClassEntity;
use app\common\repository\BaseRepository;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorTrain;

class BaseService
{
    use ErrorTrain;

    private BaseRepository $_baseRepository;

    protected BaseAR $Entity; // 由子类定义该操作哪个Entity

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
            return $this->_baseRepository->getItem($queryParams, $this->Entity);
        } catch (\Exception $e) {
            return self::setAndReturn(ErrorCode::SYSTEM_ERROR, $e->getMessage());
        }
    }

    /**
     * 统一的添加方法
     * @param BaseAR $entity 填充好数据的entity
     * @return BaseAR|bool
     */
    public function insert(BaseAR $entity)
    {
        try {
            return $this->_baseRepository->add($entity);
        } catch (\Exception $e) {
            return self::setAndReturn(ErrorCode::SYSTEM_ERROR, $e->getMessage());
        }
    }

    /**
     * entity 修改 在相应的service中修改entity即可
     * @return bool
     */
    public function save()
    {
        try {
            return $this->_baseRepository->save($this->Entity);
        } catch (\Exception $e) {
            return self::setAndReturn(ErrorCode::SYSTEM_ERROR, $e->getMessage());
        }
    }

}