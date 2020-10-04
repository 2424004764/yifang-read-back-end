<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_bookmark".
 *
 * @property int $book_bookmark_id 书签id主键
 * @property int $book_id 书籍id
 * @property int $chapter_id 章节id
 * @property string $read_schedule 阅读进度  这里还没想好  先varchar 10
 * @property string $create_on 添加时间
 */
class BookBookmarkEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_bookmark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'chapter_id'], 'integer'],
            [['create_on'], 'safe'],
            [['read_schedule'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_bookmark_id' => '书签id主键',
            'book_id' => '书籍id',
            'chapter_id' => '章节id',
            'read_schedule' => '阅读进度  这里还没想好  先varchar 10',
            'create_on' => '添加时间',
        ];
    }
}
