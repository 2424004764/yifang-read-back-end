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
    const USER_PASSWORD_DIFF_FAIL = 4002; // 两次密码比对错误
    const USER_NICKNAME_FORMAT_ERROR = 4003; // 昵称不符格式~ 可能是包含特殊字符~
    const USER_ACCOUNT_NO_BOOK_ID_NO_EMAIL = 4004; // 你的账号或密码错误~
    const USER_FIELD_NOT_EDIT = 4005; // 字段不可修改

    /**
     * bookShelf 6000 ~ 6199
     */
    const BOOKSHELF_IS_EXIST = 6000; // 已加入书架
    const BOOKSHELF_SAVE_FAIL = 6001; // 保存书架失败

    /**
     * user-setting 6200 ~ 6399
     */
    const SETTING_NAME_NO_EXIST = 6200; // 配置名不存在
}