<?php
/**
 * 额外的一些缓存数据
 * 用户一些临时用的场景
 * 参考: \app\common\utilValidatorsForm::getRulesName ID_OR_EMAIL 验证方法
 * 该处的使用理由是  需要记录值是整数还是邮箱，故此用这个方式存储临时变量
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/12/3 0003
 * Time: 21:19
 */

namespace app\common;


class AdditionalCacheData
{

    // 1 uid  2 email
    public static int $ID_OR_EMAIL;

}