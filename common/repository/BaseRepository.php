<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 21:38
 */

namespace app\common\repository;
use app\common\BaseAR;
use app\common\train\error\ErrorTrain;

class BaseRepository
{
    use ErrorTrain;

    private $_baseEntity = null; // 所有 entity 的爸爸

    public function __construct()
    {
        $this->_baseEntity = new BaseAR();
    }


    /**
     * repository 统一的向entity中添加的方法
     * @param BaseAR $entity
     * @return BaseAR
     * @throws \Exception
     */
    public function add(BaseAR $entity)
    {
        try {
            return BaseAR::add($entity);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $entity
     * @param $where
     * @param $field
     * @param $order
     * @param $size
     * @param $offset
     * @return array|\yii\db\ActiveRecord[]
     * @throws \Exception
     */
    public function getItem($entity, $where = [], $field = null,
        $order = [], $size = null, $offset = null)
    {
        try {
            return $this->_baseEntity->getItem($entity, $where, $field, $order, $size, $offset);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
}