<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_related_label".
 *
 * @property int $related_label_id 书籍关联标签表id主键
 * @property int $book_id 书籍id
 * @property int $label_id 标签id
 * @property string $create_on 添加时间
 */
class BookRelatedLabelEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_related_label';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'label_id'], 'integer'],
            [['create_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'related_label_id' => '书籍关联标签表id主键',
            'book_id' => '书籍id',
            'label_id' => '标签id',
            'create_on' => '添加时间',
        ];
    }
}
