<?php
/**
 * 用来传递查询的结构化参数
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/3 0003
 * Time: 10:34
 */

namespace app\common\utTrait;


use yii\db\QueryTrait;

class QueryParams
{
    /** @var QueryTrait 查询用的trait 用来传递结构化参数 简单实用可参考\app\controllers\BookClassController::actionGetClass */
    use QueryTrait;

    /**
     * @var string 要查询的字段
     * 默认查询所有字段
     */
    public string $select = '';
}