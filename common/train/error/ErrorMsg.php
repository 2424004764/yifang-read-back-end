<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 22:50
 */

namespace app\common\train\error;


class ErrorMsg
{

    public static $SUCCESS = 'success';

    /**
     * 定义错误描述信息
     * @var array
     */
    public static $errMsg = [
        ErrorCode::PARAM_EMPTY => '参数错误',
        ErrorCode::PARAM_VALIDATE_FAIL => '参数效验失败',
    ];

    /**
     * 获取错误描述信息
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