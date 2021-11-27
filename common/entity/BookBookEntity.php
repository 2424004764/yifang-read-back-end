<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_book".
 *
 * @property int $book_id 书籍主键
 * @property string $book_name 书籍名字
 * @property string $book_cover_imgs 封面图 最多5张，每张图片地址字符串长度最大为300
 * @property string $book_desc 书籍描述
 * @property int $book_word_count 书籍的总字数 包含书籍简介
 * @property int $book_favorites_count 书籍收藏人数 加队列处理
 * @property int $book_click_count 书籍点击数 可以重复  加队列处理
 * @property int $book_watch_count 书籍观看数 可以重复 加队列处理
 * @property int $book_class_id 书籍分类id  为0则没有分类
 * @property int $book_current_read_count 当前正在阅读的人数
 * @property int $book_unit_count 书籍共多少章节
 * @property int $book_status 状态 0未上架 1已上架 2已禁用（无法操作上下架）
 * @property string $create_on 发布时间
 * @property string $update_on 更新时间
 */
class BookBookEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_word_count', 'book_favorites_count', 'book_click_count', 'book_watch_count', 'book_class_id', 'book_current_read_count', 'book_unit_count', 'book_status'], 'integer'],
            [['create_on', 'update_on'], 'safe'],
            [['book_name'], 'string', 'max' => 100],
            [['book_cover_imgs'], 'string', 'max' => 1500],
            [['book_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_id' => '书籍主键',
            'book_name' => '书籍名字',
            'book_cover_imgs' => '封面图 最多5张，每张图片地址字符串长度最大为300',
            'book_desc' => '书籍描述',
            'book_word_count' => '书籍的总字数 包含书籍简介',
            'book_favorites_count' => '书籍收藏人数 加队列处理',
            'book_click_count' => '书籍点击数 可以重复  加队列处理',
            'book_watch_count' => '书籍观看数 可以重复 加队列处理',
            'book_class_id' => '书籍分类id  为0则没有分类',
            'book_current_read_count' => '当前正在阅读的人数',
            'book_unit_count' => '书籍共多少章节',
            'book_status' => '状态 0未上架 1已上架 2已禁用（无法操作上下架）',
            'create_on' => '发布时间',
            'update_on' => '更新时间',
        ];
    }

    /**
     * 关联书籍详情 一对一
     * @return \yii\db\ActiveQuery
     */
    public function getDetail()
    {
        return $this->hasOne(BookDetailEntity::class, ['book_id' => 'book_id']);
    }

    /**
     * 关联作者详情
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorDetail()
    {
        return $this->hasOne(BookAuthorDetailEntity::class, ['book_id' => 'book_id']);
    }

    /**
     * 关联分类
     * @return \yii\db\ActiveQuery
     */
    public function getClassDetail()
    {
        return $this->hasOne(BookClassEntity::class, ['book_class_id' => 'book_class_id']);
    }
}
