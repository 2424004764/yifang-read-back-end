<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_chapter_content".
 *
 * @property int $chapter_content_id 书籍内容表id主键
 * @property int $chapter_id 书籍章节id
 * @property int $book_id 书籍id
 * @property string $chapter_content 章节内容 最多 65535 个字符
 * @property string $create_on 添加时间
 */
class BookChapterContentEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_chapter_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chapter_id', 'book_id'], 'integer'],
            [['chapter_content'], 'required'],
            [['chapter_content'], 'string'],
            [['create_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chapter_content_id' => '书籍内容表id主键',
            'chapter_id' => '书籍章节id',
            'book_id' => '书籍id',
            'chapter_content' => '章节内容 最多 65535 个字符',
            'create_on' => '添加时间',
        ];
    }
}
