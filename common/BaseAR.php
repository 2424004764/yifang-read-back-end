<?php

/**
 *  ActiveRecord 基类，对 ActiveRecord 的扩展
 */

namespace app\common;
use app\common\utTrait\QueryParams;
use yii\db\ActiveRecord;


class BaseAR extends ActiveRecord
{

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            // 自动生成时间
            $this->create_on = date("Y-m-d H:i:s", time());
        }
        return parent::beforeSave($insert);
    }

    /**
     * 统一的添加方法
     * @param $entity BaseAR
     * @return BaseAR
     * @throws \Exception
     */
    public static function add(BaseAR $entity)
    {
        if(!($entity instanceof BaseAR)){
            throw new \Exception("提交的Entity父类必须是BaseAR");
        }
        if(!$entity->validate(null, false)){
            $error = $entity->getFirstErrors();
            // 返回第一条字段效验失败到的提示
            throw new \Exception(array_values($error)[0]);
        }
        try {
            $entity->save();
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
        return $entity;
    }

    /**
     * 可复用的查找方法
     *  @param $queryParams QueryParams 查询条件
     * @param $queryEntity BaseAR 要查询的Entity
     * @return array|ActiveRecord[]
     */
    public function getItem($queryParams, $queryEntity)
    {
        $query = $queryEntity::find();
        if($queryParams->where)$query->with($queryParams->where);
        if($queryParams->field)$query->select($queryParams->field);
        if($queryParams->orderBy)$query->orderBy($queryParams->orderBy);
        if($queryParams->offset)$query->offset(($queryParams->offset - 1) * $queryParams->limit);
        if($queryParams->limit)$query->limit($queryParams->limit);
        return $query->all();
    }

}