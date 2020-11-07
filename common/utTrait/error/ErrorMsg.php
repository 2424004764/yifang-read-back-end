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
    ];

    /**
     * 只能根据错误码获取错误描述信息
     * @param $errCode
     * @return string
     */
    public static function getErrMsg($errCode) {
        return isset(self::$errMsg[$errCode]) ? self::$errMsg[$errCode] : self::getDefaultMsg();
    }

    /**
     * 获取默认的错误描述信息
     * @return string
     */
    public static function getDefaultMsg() {
        return '服务器错误 500';
    }
}