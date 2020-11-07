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

    // 指定了参数效验名
    // 使用 ParamValidateType 类传递参数
    // 键名统一使用驼峰形式命名
    public static array $RULES_NAME = [
        'int'   =>  [
            ['integer'],
            ['filter', 'filter' => 'intval']
        ],
        'bookId'   =>  [
            ['integer'],
            ['filter', 'filter' => 'intval']
        ]
    ];


    /**
     * 关于父类 rules效验规则说明：
     * @see \yii\base\Model::rules
     * @param array $fields 需要效验的字段
     * @return int|array
     * @throws \yii\base\InvalidConfigException
     */
    public static function validateParams($fields = [])
    {

        $validateResult = function (&$data, $rules){
            $model = DynamicModel::validateData($data, $rules);
            if($model->hasErrors()){
                $error =  join(", ", array_values($model->getFirstErrors()));

                return self::setAndReturn(ErrorCode::PARAM_VALIDATE_FAIL,
                    $error);
            }
            return $model->toArray();
        };

        foreach ($fields as $field => &$value){
            // 如果使用 ParamValidateType 指定了共用的效验字段
            if($value instanceof ParamValidateType){
                $rule = self::$RULES_NAME[$value->type];
                // 如果规则不存在  则不效验
                if(empty($rule))continue;
                $value = $value->value;
                // 有公用效验字段的规则需要不同的效验方法
                // $validateType 如 int、bookId
                foreach ($rule as $validateType){
                    $getRule = function () use ($validateType) {
                        // 单独进行效验
                        $tem_rules = [];
                        // $index 并不是索引
                        foreach ($validateType as $index => $option){
                            if(is_numeric($index)){
                                $tem_rules[] = $option;
                            }else{
                                $tem_rules[$index] = $option;
                            }
                        }
                        return $tem_rules;
                    };
                    $rules = [
                        [[$field], ]
                    ];
                    $rules[0] = array_merge($rules[0], $getRule());
                    $data = [$field => $value];
                    $result = $validateResult($data, $rules);
                    if(!$result){
                        return  false;
                    }
                    // 因为 'filter' => 'intval' 的需要覆盖原数据
                    $fields = array_merge($fields, $result);
                }
            }
        }

        return $fields;
    }


}