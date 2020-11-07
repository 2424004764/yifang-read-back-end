<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 22:50
 */

namespace app\common\utTrait\error;


class ErrorInfo
{
    private static int $errCode;
    private static ?string $errMsg;
    private static ?string $logMsg;

    /**
     * 获取设置的错误码
     * @return int
     */
    public static function getErrCode()
    {
        return self::$errCode;
    }

    /**
     * 获取错误消息
     * @return string
     */
    public static function getErrMsg()
    {
        return self::$errMsg;
    }

    /**
     * TODO 看需不需要记录出错的日志
     * 错误日志内容
     * @return string
     */
    public static function getLogMsg()
    {
        return self::$logMsg;
    }

    /**
     * 设置返回内容
     * @param int $errCode 错误码
     * @param string $logMsg 日志信息内容
     * @param string $msg  自定义错误信息
     * @return boolean
     */
    public static function setAndReturn($errCode,  $msg = NULL, $logMsg = NULL)
    {
        self::$errCode = $errCode;
        self::$logMsg = 'errorCode:'.$errCode.','.$logMsg;
        if (isset(ErrorMsg::$errMsg[$errCode])) {
            if (empty($msg)) {
                self::$errMsg = ErrorMsg::$errMsg[$errCode];
            }else{
                self::$errMsg = $msg;
            }

        } else {
            if(empty($logMsg) && empty($msg)){
                self::$errMsg = ErrorMsg::getDefaultMsg();
            }else{
                self::$errMsg = empty($msg) ? $logMsg : $msg;
            }
        }
        return false;
    }

    public static function cleanErrorInfo(){
        self::$errCode = "";
        self::$errMsg = "";
        self::$logMsg = "";
    }
}