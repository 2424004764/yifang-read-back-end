<?php

namespace app\common\entity;

use Yii;

/**
 *
 * @property int $collection_id
 * @property int $en_id
 * @property int $user_id
 * @property string $created_on
 */
class EnCollectionEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'en_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collection_id', 'en_id', 'user_id'], 'integer'],
            [['created_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'collection_id' => '书籍表id 作为主键',
            'en_id' => '每日美句id',
            'user_id' => '用户id',
            'created_on' => '创建时间',
        ];
    }
}
