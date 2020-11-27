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
     * @var $temp_var array 用于存储一些不关联其他字段的效验属性
     * 如密码和再次确认密码的效验  在这里是无法效验的
     * 所以需要这个变量作为中间变量
     */
    public static array $temp_var = [];

    // 指定了参数效验名
    // 使用 ParamValidateType 类传递参数
    // 键名统一使用驼峰形式命名
    private static function getRulesName()
    {
        return [
            'int'   =>  [
                ['integer'],
                ['filter', 'filter' => 'intval']
            ],
            'bookId'   =>  [
                ['required'], ['integer'],
                ['filter', 'filter' => 'intval']
            ],
            // 往后统一使用大写的形式
            'NICKNAME'  =>  [ // 昵称
                ['string', 'length' => [1, 20]],
                // 定义为匿名函数的行内验证器 $attribute 就是控制器传入的字段名 如这里就是user_nickname
                // $this->$attribute 就是当前属性的值
                // 只要不$this->addError 则表示成功
                [function($attribute, $params){
                    // 验证姓名有效性
                    if(!UtilValidate::checkNameAllowSpace($this->$attribute)){
                        $this->addError($attribute, '昵称不符格式~');
                    }
                }]
            ],
            'EMAIL' =>  [ // 邮箱
                ['required'],
                ['email']
            ],
            'PASSWORD'  =>  [ // 密码
                ['required'],
                ['string', 'length' => [1, 30]],
                // 将密码保存起来 好二次验证密码  因为DynamicModel 是单次验证，所以和rules不一样
                // 因为只有验证password时才会验证
                [function($attribute, $params){
                    utilValidatorsForm::$temp_var['password'] = $this->$attribute;
                }]
            ],
            'CONFIRM_PASSWORD'  =>  [ // 二次确认密码
                ['required'],
                [function($attribute, $params){
                    if($this->$attribute != utilValidatorsForm::$temp_var['password']){
                        $this->addError($attribute, '两次密码对比不匹配~');
                    }
                }]
            ],
            'DATE'  =>  [ // 日期
                ['date', 'format'=>'yyyy-MM-dd']
            ],
            'SEX'   =>  [ // 性别
                ['in', 'range' => [0, 1, 2]]
            ],
        ];
    }

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
                $rule = self::getRulesName()[$value->type];
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