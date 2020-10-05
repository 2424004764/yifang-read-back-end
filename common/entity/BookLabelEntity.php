<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_label".
 *
 * @property int $label_id 书籍标签表id主键
 * @property string $label_name 标签名
 * @property string $create_on 添加时间
 */
class BookLabelEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_label';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_on'], 'safe'],
            [['label_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'label_id' => '书籍标签表id主键',
            'label_name' => '标签名',
            'create_on' => '添加时间',
        ];
    }
}
