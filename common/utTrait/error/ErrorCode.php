<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 22:49
 */

namespace app\common\utTrait\error;

/**
 * 单纯用来放错误码的唯一作用
 * Class ErrorCode
 * @package app\common\utTrait\error
 */
class ErrorCode
{
    public static int $ERROR_CODE; // 外部设置的错误码

    const SUCCESS = 0;    // 0表示成功
    const FAILURE = -1;   // 表示失败

    /**
     * 请求|参数相关范围为 1 ~ 1999
     */
    const PARAM_EMPTY = 1; // 参数错误
    const PARAM_VALIDATE_FAIL = 2; // 参数效验失败
    const REQUEST_METHOD_FAIL = 3; // 请求方式错误

    /**
     * 系统范围的错误 2000 ~ 3999
     */
    const SYSTEM_ERROR = 1000; // 系统错误

    /**
     * 用户相关错误  4000 ~ 5999
     */
    const USER_DISABLE = 4000; // 用户已被禁用
    const USER_ACCOUNT_NOT_EXIST = 4001; // 用户不存在
}