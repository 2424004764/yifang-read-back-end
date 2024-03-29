<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 22:50
 */

namespace app\common\utTrait\error;

/**
 * 单纯用来放错误码对应的错误消息
 * Class ErrorMsg
 * @package app\common\utTrait\error
 */
class ErrorMsg
{

    public static string $SUCCESS = 'success'; // 定义请求成功的返回消息

    /**
     * 定义错误描述信息
     * @var array
     */
    public static array $errMsg = [
        ErrorCode::PARAM_EMPTY => '参数错误',
        ErrorCode::PARAM_VALIDATE_FAIL => '参数效验失败',
        ErrorCode::REQUEST_METHOD_FAIL => '请求方式错误',
        ErrorCode::SYSTEM_ERROR => '系统错误',
        ErrorCode::USER_DISABLE => '用户已被禁用',
        ErrorCode::USER_ACCOUNT_NOT_EXIST => '用户不存在',
        ErrorCode::BOOKSHELF_IS_EXIST => '已加入书架',
        ErrorCode::USER_PASSWORD_DIFF_FAIL => '两次密码比对错误',
        ErrorCode::USER_NICKNAME_FORMAT_ERROR => '昵称不符格式~ 可能是包含特殊字符~',
        ErrorCode::USER_ACCOUNT_NO_BOOK_ID_NO_EMAIL => '你的账号或密码错误~',
        ErrorCode::SETTING_NAME_NO_EXIST => '配置名不存在',
        ErrorCode::USER_FIELD_NOT_EDIT => '字段不可修改',
        ErrorCode::BOOKSHELF_RECORD_NOT_FOUND => '书架记录不存在',
        ErrorCode::BOOK_NOT_EXIST => '书籍不存在',
        ErrorCode::DATA_FORMAT_ERROR => '数据格式错误',
        ErrorCode::UPLOAD_FILE_ERROR => '上传的文件错误',
        ErrorCode::UPLOAD_FILE_EMPTY => '上传的文件为空',
    ];

    /**
     * 只能根据错误码获取错误描述信息
     * @param $errCode
     * @return string
     */
    public static function getErrMsg($errCode)
    {
        return isset(self::$errMsg[$errCode]) ? self::$errMsg[$errCode] : self::getDefaultMsg();
    }

    /**
     * 获取默认的错误描述信息
     * @return string
     */
    public static function getDefaultMsg()
    {
        return '服务器错误 500';
    }
}