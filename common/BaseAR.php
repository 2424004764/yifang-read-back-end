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
        if ($this->isNewRecord) {
            // 自动生成时间
            $this->create_on = date("Y-m-d H:i:s", time());
        } else {
            // 自动更改 时间字段
            if ($this->hasAttribute('update_on')) {
                $this->update_on = date("Y-m-d H:i:s", time());
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * 统一的添加方法
     * @param $entity BaseAR
     * @return BaseAR 新增成功后的entity实体
     * @throws \Exception
     */
    public static function add(BaseAR $entity)
    {
        if (!($entity instanceof BaseAR)) {
            throw new \Exception("提交的Entity父类必须是BaseAR");
        }
        if (!$entity->validate(null, false)) {
            $error = $entity->getFirstErrors();
            // 返回第一条字段效验失败到的提示
            throw new \Exception(array_values($error)[0]);
        }
        try {
            $entity->save();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
        return $entity;
    }

    /**
     * 可复用的查找方法
     * @param $queryParams QueryParams 查询条件
     * @param $queryEntity BaseAR 要查询的Entity
     * @param $isGetOne bool 是否只获取一条数据
     * @return array|ActiveRecord[]
     */
    public function getItem($queryParams, $queryEntity, $isGetOne)
    {
        $query = $queryEntity::find();
        if ($queryParams->where) $query->where($queryParams->where);
        if ($queryParams->select) {
            $field = $queryParams->select;
        } else {
            // 如果没有指定要返回的字段 则使用entity 的 attributeLabels
            // 避免select *
            $field = join(", ", array_keys($queryEntity->getAttributes()));
        }
        $query->select($field);
        if ($queryParams->orderBy) $query->orderBy($queryParams->orderBy);
        // page 、 size 计算 limit、offset
        if ($queryParams->size) {
            $query->limit($queryParams->size);

            if ($queryParams->page) {
                $query->offset(($queryParams->page - 1) * $queryParams->size);
            }
        }

        return $isGetOne ? $query->one() : $query->all();
    }


    /**
     * 根据条件查询一条记录
     * @param $where array 条件
     * @param BaseAR $queryEntity
     * @return array|ActiveRecord|null
     */
    public function getItemDetail($where, BaseAR $queryEntity)
    {
        return $queryEntity::find()->where($where)->one();
    }


}