<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_class".
 *
 * @property int $book_class_id 书籍分类id
 * @property int $parent_id 父级分类id  做多级分类 0为一级分类
 * @property string $class_id_name 分类名
 * @property string $class_cover_img 分类封面图片
 * @property int $order 排序  可拖动，当托动到另一个分类的前面时，设置当前排序的值为拖动到的分类的值加一即可 不可手动设置
 * @property int $status 状态 0正常 1禁用
 * @property string $create_on 添加时间
 */
class BookClassEntity extends \app\common\BaseAR
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'order', 'status'], 'integer'],
            [['create_on'], 'safe'],
            [['class_id_name'], 'string', 'max' => 50],
            [['class_cover_img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_class_id' => '书籍分类id',
            'parent_id' => '父级分类id  做多级分类 0为一级分类',
            'class_id_name' => '分类名',
            'class_cover_img' => '分类封面图片',
            'order' => '排序  可拖动，当托动到另一个分类的前面时，设置当前排序的值为拖动到的分类的值加一即可 不可手动设置',
            'status' => '状态 0正常 1禁用',
            'create_on' => '添加时间',
        ];
    }

    /**
     * 获取所有分类
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAll()
    {
        return self::find()->all();
    }
}
