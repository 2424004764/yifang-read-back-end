<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_feedback".
 *
 * @property int $feedback_id
 * @property int $user_id 用户id
 * @property int $feedback_content 反馈内容
 * @property int $status 状态 0待处理 1处理中 2已处理
 * @property string $reply_msg 管理员回复的内容
 * @property string $create_on 创建时间
 * @property string $reply_date 回复时间
 */
class BookFeedbackEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['feedback_content'], 'required'],
            [['create_on', 'reply_date'], 'safe'],
            [['feedback_content'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'feedback_id' => 'Feedback ID',
            'user_id' => 'User ID',
            'feedback_content' => '反馈内容',
            'status' => 'Status',
            'reply_msg' => 'Reply Msg',
            'create_on' => 'Create On',
            'reply_date' => 'Reply Date',
        ];
    }
}
