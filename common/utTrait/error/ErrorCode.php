<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 22:49
 */

namespace app\common\utTrait\error;

class ErrorCode
{
    public static int $ERROR_CODE; // 外部设置的错误码

    const SUCCESS = 0;    // 0表示成功
    const FAILURE = -1;   // 表示失败

    /**
     * 请求|参数相关范围为 100 ~ 1100
     */
    const PARAM_EMPTY = 100; // 参数错误
    const PARAM_VALIDATE_FAIL = 101; // 参数效验失败
    const REQUEST_METHOD_FAIL = 103; // 请求方式错误

    /**
     * 系统范围的错误 1101 ~ 1201
     */
    const SYSTEM_ERROR = 1101; // 系统错误

    /**
     * 设置全局的状态码
     * @param $code int 需要设置的全局状态码
     * @return int 返回设置的状态码
     */
    public static function setCode($code){
        self::$ERROR_CODE = $code;

        return self::$ERROR_CODE;
    }

    /**
     * 获取错误消息
     * @param null|int $code 需要获取的错误消息错误码  如果为空则获取全局设置的错误消息码
     * @return string
     */
    public static function getMsg($code = null){
        if(empty($code)){
            $code = self::$ERROR_CODE;
        }

        return ErrorMsg::getErrMsg($code);
    }
}