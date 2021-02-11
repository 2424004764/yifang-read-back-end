<?php

namespace app\common\entity;

/**
 * This is the model class for table "book_user".
 *
 * @property int $user_id 用户表ID主键  保留1-100000  正常注册的id从100001开始  作为登陆账号
 * @property string $user_nickname 用户昵称
 * @property string $user_headimg 用户头像
 * @property int $sex 性别 0 未知 1男 2女
 * @property int $status 状态 0正常 1禁用
 * @property string $birthday 用户生日  只填年月日 要区分阳历或阴历
 * @property int $birthday_type 日期类型 1阳历 2阴历
 * @property string $password_salt 密码加盐
 * @property string $password 密码 使用phpass加密
 * @property string $bind_email 用以重置密码
 * @property string $create_on 注册时间
 */
class BookUserEntity extends \app\common\BaseAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'birthday_type'], 'integer'],
            [['birthday', 'create_on'], 'safe'],
            [['user_nickname'], 'string', 'max' => 50],
            [['user_headimg', 'password_salt', 'password', 'bind_email'], 'string', 'max' => 255],
            [['sex'], 'integer', 'min' => 0, 'max' => 2]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户表ID主键  保留1-100000  正常注册的id从100001开始  作为登陆账号',
            'user_nickname' => '用户昵称',
            'user_headimg' => '用户头像',
            'sex' => '性别 0 未知 1男 2女',
            'status' => '状态 0正常 1禁用',
            'birthday' => '用户生日  只填年月日 要区分阳历或阴历',
            'birthday_type' => '日期类型 1阳历 2阴历',
            'password_salt' => '密码加盐',
            'password' => '密码 使用phpass加密',
            'bind_email' => '用以重置密码',
            'create_on' => '注册时间',
        ];
    }
}
