<?php

/**
 *  ActiveRecord 基类，对 ActiveRecord 的扩展
 */

namespace app\common;
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
     * @param BaseAR $entity 需要查询的entity
     * @param $where array 查询条件
     * @param $field string 需要返回的字段 不穿 返回全部字段
     * @param $order array 排序方式
     * @return array|ActiveRecord[]
     */
    public function getItem(self $entity, $where, $field,
        $order)
    {
        $query = $entity::find();
        if($where)$query->with($where);
        if($field)$query->select($field);
        if($order)$query->orderBy($order);
        if($entity->page)$query->offset(($entity->page - 1) * $entity->size);
        if($entity->size)$query->limit($entity->size);
        return $query->all();
    }

}