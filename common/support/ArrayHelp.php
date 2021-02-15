<?php
/**
 * 对操作数组的静态方法集合
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/2/15 0015
 * Time: 13:45
 */

class ArrayHelp
{
    /**
     * 将二维数组的某个键作为关联数组的key
     * @param string $key 关联数组的key name
     * @param $array
     */
    public static function fixArray($array, $key){
        $data = [];
        foreach ($array as $item){
            $data[$key] = $item;
        }

        return $data;
    }
}