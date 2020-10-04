<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_history".
 *
 * @property int $history_id 书籍查阅历史表主键
 * @property int $user_id 用户id
 * @property int $book_id 书籍id
 * @property int $status 状态 0正常 1删除
 * @property string $create_on 添加时间
 */
class BookHistoryEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'book_id', 'status'], 'integer'],
            [['create_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'history_id' => '书籍查阅历史表主键',
            'user_id' => '用户id',
            'book_id' => '书籍id',
            'status' => '状态 0正常 1删除',
            'create_on' => '添加时间',
        ];
    }
}
