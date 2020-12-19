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
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\QueryParams;
use app\common\utTrait\error\ErrorTrain;

class BaseRepository
{
    use ErrorTrain;

    private BaseAR $_baseEntity; // 所有 entity 的爸爸 由service定义

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
     * @param $QueryParams QueryParams 查询条件
     * @param $queryEntity BaseAR 要查询的Entity
     * @return array|\yii\db\ActiveRecord[]
     * @throws \Exception
     */
    public function getItem($QueryParams, $queryEntity)
    {
        try {
            return $this->_baseEntity->getItem($QueryParams, $queryEntity);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * 根据条件查询一条记录
     * @param $where array 条件
     * @param $queryEntity
     * @return array|\yii\db\ActiveRecord|null
     * @throws \Exception
     */
    public function getItemDetail($where, $queryEntity)
    {
        try {
            // 组装查询条件
            return $this->_baseEntity->getItemDetail($where, $queryEntity);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * 修改
     * @param BaseAR $entity
     * @return bool|string
     * @throws \Exception
     */
    public function save(BaseAR $entity)
    {
        try {
            if(!$entity->save()){
                // 保存失败
                return self::setAndReturn(ErrorCode::SYSTEM_ERROR,
                    current($entity->getFirstErrors()));
            }
            return true;
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * 是否存在数据
     * @param QueryParams $queryParams
     * @param BaseAR $entity
     * @return bool
     */
    public function isExist($queryParams, $entity)
    {
        return $entity::find()->where($queryParams->where)->exists();
    }
}