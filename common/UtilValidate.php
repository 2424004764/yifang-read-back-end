<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/24 0024
 * Time: 22:36
 */

namespace app\common;


class UtilValidate
{
    /**
     * 姓名不允许提交特殊字符，仅允许提交：汉字、数字、英文字母（大小写均支持）、空格、部分标点符号（- _  .  ·）
     * @param $name
     * @return bool
     */
    public static function checkNameAllowSpace($name)
    {
        if (empty($name)) {
            return false;
        }
        return (bool)preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z0-9-_.·\s]+$/u", $name);
    }
}