<?php
/**
 * for 效验参数
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/5 0005
 * Time: 17:40
 */

namespace app\common;

use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorTrain;
use yii\base\DynamicModel;

class utilValidatorsForm
{

    use ErrorTrain;

    /**
     * 指定验证规则
     * 参考使用 https://www.yiichina.com/doc/guide/2.0/input-validation
     * 参考可用的验证器用法和属性 https://www.yiichina.com/doc/guide/2.0/input-validation
     * 进行类型验证、以及使用php自带|自定义的方法进行过滤 使用过滤器 https://www.yiichina.com/doc/guide/2.0/tutorial-core-validators#filter
     * 还可以为每条规则设置命名 如：https://www.yiichina.com/doc/guide/2.0/tutorial-core-validators#filter
     * 可以使用on 指定字段在哪个场景效验
     * @return array|array[]
     */
//    public function _rules()
//    {
//        return [
//            [['page', 'size'], 'integer', 'min'=>1],
//            [['book_id'], 'required', 'string']
//        ];
//    }

    /**
     * 可以公用一套效验规则的机制
     * 可以在控制器中就指定类型  如果不指定类型  则还是按给定的参数名效验
     * @var array|\string[][] 字段效验规则
     */
    public static array $RULES = [
        // 未指定参数效验名
        'page'  =>  ['integer']
    ];

    // 指定了参数效验名
    // 使用 ParamValidateType 类传递参数
    // 键名统一使用驼峰形式命名
    public static array $RULES_NAME = [
        'int'   =>  ['integer'],
        'bookId'   =>  ['string', 'required']
    ];


    /**
     * @param array $fields 需要效验的字段
     * @return int|array
     * @throws \yii\base\InvalidConfigException
     */
    public static function validateParams($fields = [])
    {
        foreach ($fields as $field => &$value){
            // 如果使用 ParamValidateType 指定了共用的效验字段
            if($value instanceof ParamValidateType){
                $rule = self::$RULES_NAME[$value->type];
                // 如果规则不存在  则不效验
                if(empty($rule))continue;
                $value = $value->value;
            }else{
                /**
                 * 未指定共用效验属性
                 * 如果参数的效验规则未设置 则不效验 只是根据字段进行效验 且
                 * 字段必需在 下面数组 中定义
                 * @see \app\common\utilValidatorsForm::$RULES
                 */
                if(!isset(self::$RULES[$field]))continue;
                $rule = self::$RULES[$field];
            }

            $data = [$field => $value];
            $rules = [
                [[$field], ...$rule]
            ];
            $model = DynamicModel::validateData($data, $rules);
            if($model->hasErrors()){
                $error =  join(", ", array_values($model->getFirstErrors()));

                return self::setAndReturn(ErrorCode::PARAM_VALIDATE_FAIL,
                    $error);
            }
        }

        return $fields;
    }


}