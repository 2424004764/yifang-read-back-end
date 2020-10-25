<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_chapter".
 *
 * @property int $chapter_id 书籍的章节基础信息id主键 不含内容，内容在另一张表
 * @property int $parent_chapter_id 有些章节有子章节，这是父级章节id。0为顶级父级id
 * @property int $book_id 书籍id
 * @property string $chapter_name 章节名称
 * @property string $create_on 添加时间
 */
class BookChapterEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_chapter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_chapter_id', 'book_id'], 'integer'],
            [['create_on'], 'safe'],
            [['chapter_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chapter_id' => '书籍的章节基础信息id主键 不含内容，内容在另一张表',
            'parent_chapter_id' => '有些章节有子章节，这是父级章节id。0为顶级父级id',
            'book_id' => '书籍id',
            'chapter_name' => '章节名称',
            'create_on' => '添加时间',
        ];
    }
}
