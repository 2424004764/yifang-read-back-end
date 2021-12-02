<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_author_detail".
 *
 * @property int $book_id 书籍表id 作为主键
 * @property string $book_author 书籍作者
 * @property string $book_author_desc 书籍作者简介
 * @property string $create_on 添加时间
 */
class BookAuthorDetailEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_author_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id'], 'required'],
            [['book_id'], 'integer'],
            [['book_author_desc'], 'string'],
            [['create_on'], 'safe'],
            [['book_author'], 'string', 'max' => 50],
            [['book_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_id' => '书籍表id 作为主键',
            'book_author' => '书籍作者',
            'book_author_desc' => '书籍作者简介',
            'create_on' => '添加时间',
        ];
    }
}
