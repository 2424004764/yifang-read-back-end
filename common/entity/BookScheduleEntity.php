<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_schedule".
 *
 * @property int $schedule_id 书籍章节进度表id主键
 * @property int $book_id 书籍id
 * @property int $chapter_id 书籍的章节id
 * @property string $schedule 进度 某一个章节的进度百分比 还是 某个章节读到多少字了
 * @property string $create_on 进度添加时间
 */
class BookScheduleEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'chapter_id'], 'integer'],
            [['create_on'], 'safe'],
            [['schedule'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => '书籍章节进度表id主键',
            'book_id' => '书籍id',
            'chapter_id' => '书籍的章节id',
            'schedule' => '进度 某一个章节的进度百分比 还是 某个章节读到多少字了',
            'create_on' => '进度添加时间',
        ];
    }
}
