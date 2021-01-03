<?php

namespace app\common\entity;

use Yii;

/**
 * This is the model class for table "book_user_setting".
 *
 * @property int $setting_id 设置主键id
 * @property int $user_id 用户id
 * @property string $name 配置名
 * @property string $value 配置值
 * @property string $create_on 配置添加的时间
 */
class BookUserSettingEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_user_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['create_on'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => 'Setting ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'value' => 'Value',
            'create_on' => 'Create On',
        ];
    }
}
