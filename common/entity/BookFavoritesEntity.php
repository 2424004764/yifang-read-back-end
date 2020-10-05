<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_favorites".
 *
 * @property int $favorites_id 书籍收藏表 主键
 * @property int $book_id 书籍表id
 * @property int $user_id 用户id
 * @property string $create_on 收藏时间
 */
class BookFavoritesEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_favorites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'user_id'], 'integer'],
            [['create_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'favorites_id' => '书籍收藏表 主键',
            'book_id' => '书籍表id',
            'user_id' => '用户id',
            'create_on' => '收藏时间',
        ];
    }
}
