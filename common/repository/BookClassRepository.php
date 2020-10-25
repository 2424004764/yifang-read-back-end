<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 21:36
 */

namespace app\common\repository;


use app\common\entity\BookClassEntity;

class BookClassRepository extends BaseRepository
{

    /**
     * 获取所有分类数据
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllClass()
    {
        return BookClassEntity::getAll();
    }

}