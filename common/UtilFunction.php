<?php
/**
 * 公共方法
 * 全方法静态提供
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/26 0026
 * Time: 21:50
 */

namespace app\common;


class UtilFunction
{

    /**
     * 获取随机字符串
     * @param int $length 随机字符串长度
     * @return string
     */
    public static function getRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}