<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "en_everyday_english".
 *
 * @property int $en_id
 * @property string $content 英语内容
 * @property string $cover_img 封面
 * @property string $translate 翻译
 * @property string $source 出自
 * @property string $is_release 是否发布
 * @property string $release_date 发布时间
 * @property string $created_on 创建时间
 */
class EnEverydayEnglishEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'en_everyday_english';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['en_id', 'is_release'], 'integer'],
            [['content', 'cover_img', 'translate', 'source', 'release_date'], 'string'],
            [['created_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'en_id' => '书籍表id 作为主键',
            'content' => '内容',
            'cover_img' => '封面图',
            'translate' => '翻译',
            'source' => '出自',
            'is_release' => '是否发布',
            'release_date' => '发布时间',
            'created_on' => '创建时间',
        ];
    }
}
