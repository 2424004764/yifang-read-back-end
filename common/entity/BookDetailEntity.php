<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_detail".
 *
 * @property int $book_id book_book表 主键id作为主键
 * @property string $book_desc 书籍详情
 * @property string $create_on 添加时间
 */
class BookDetailEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'book_desc'], 'required'],
            [['book_id'], 'integer'],
            [['book_desc'], 'string'],
            [['create_on'], 'safe'],
            [['book_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'book_book表 主键id作为主键',
            'book_desc' => '书籍详情',
            'create_on' => '添加时间',
        ];
    }
}
