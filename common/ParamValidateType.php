<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/7 0007
 * Time: 9:05
 */

namespace app\common;

/**
 * 使用参考方法：
 * @see \app\common\BaseController::uniGetPaging
 * @see \app\common\BaseController::getRequestParams
 * Class ParamValidateType
 * @package app\common
 */
class ParamValidateType
{
    public $value; // 参数值
    public string $rule; // 效验规则名
    public string $name; // 参数名称

    public function __construct($value, $rule, $name)
    {
        $this->value = $value;
        $this->rule = $rule;
        $this->name = $name;
    }
}