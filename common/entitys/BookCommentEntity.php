<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_comment".
 *
 * @property int $comment_id 评论id
 * @property int $book_id 书籍id
 * @property int $user_id 用户id
 * @property string $comment_content 评论内容
 * @property int $parent_comment_id 父级评论id  做多级评论  顶级评论为0
 * @property int $comment_like_total 评论点赞数
 * @property int $status 状态 0正常 1禁用
 * @property string $create_on 创建时间
 */
class BookCommentEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'user_id', 'parent_comment_id', 'comment_like_total', 'status'], 'integer'],
            [['comment_content'], 'required'],
            [['comment_content'], 'string'],
            [['create_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => '评论id',
            'book_id' => '书籍id',
            'user_id' => '用户id',
            'comment_content' => '评论内容',
            'parent_comment_id' => '父级评论id  做多级评论  顶级评论为0',
            'comment_like_total' => '评论点赞数',
            'status' => '状态 0正常 1禁用',
            'create_on' => '创建时间',
        ];
    }
}
