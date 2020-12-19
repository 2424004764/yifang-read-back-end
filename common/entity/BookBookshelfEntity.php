<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_bookshelf".
 *
 * @property int $bookshelf_id 书架id
 * @property int $user_id 用户id
 * @property int $book_id 书籍id
 * @property string $create_on 加入时间
 */
class BookBookshelfEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_bookshelf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bookshelf_id', 'user_id', 'book_id'], 'integer'],
            [['create_on'], 'safe'],
            [['bookshelf_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bookshelf_id' => 'Bookshelf ID',
            'user_id' => 'User ID',
            'book_id' => 'Book ID',
            'create_on' => 'Create On',
        ];
    }
}
