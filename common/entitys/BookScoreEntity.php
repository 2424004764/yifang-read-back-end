<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_score".
 *
 * @property int $score_id 书籍评分表id主键
 * @property int $book_id 书籍id
 * @property int $user_id 用户id
 * @property int $score 评分分数 1-10
 * @property string $create_on 评分时间
 */
class BookScoreEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_score';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'user_id', 'score'], 'integer'],
            [['create_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'score_id' => '书籍评分表id主键',
            'book_id' => '书籍id',
            'user_id' => '用户id',
            'score' => '评分分数 1-10',
            'create_on' => '评分时间',
        ];
    }
}
