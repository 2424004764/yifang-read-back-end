<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_system_config".
 *
 * @property int $config_id 配置id
 * @property string $config_name 配置字段的键
 * @property string $config_value 配置字段的值
 * @property string $config_desc 配置字段的描述
 * @property string $create_on 配置创建时间
 * @property string $update_on 配置修改时间
 */
class BookSystemConfigEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_system_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['config_value'], 'required'],
            [['config_value'], 'string'],
            [['create_on', 'update_on'], 'safe'],
            [['config_name'], 'string', 'max' => 255],
            [['config_desc'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'config_id' => '配置id',
            'config_name' => '配置字段的键',
            'config_value' => '配置字段的值',
            'config_desc' => '配置字段的描述',
            'create_on' => '配置创建时间',
            'update_on' => '配置修改时间',
        ];
    }
}
