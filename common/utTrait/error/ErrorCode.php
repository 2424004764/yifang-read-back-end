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
    const SUCCESS = 0;    // 0表示成功
    const FAILURE = -1;   // 表示失败

    /**
     * 参数相关范围为 100 ~ 10000
     */
    const PARAM_EMPTY = 100; // 参数错误
    const PARAM_VALIDATE_FAIL = 101; // 参数效验失败
}