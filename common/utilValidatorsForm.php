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

use app\common\entity\BookBookshelfEntity;
use app\common\entity\BookUserEntity;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorInfo;
use app\common\utTrait\error\ErrorTrain;
use yii\base\DynamicModel;
use yii\validators\EmailValidator;

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
                ['integer', 'message'  =>  '参数非整型~'],
                // intval 会将null、‘’转换为0
                ['filter', 'filter' => 'intval', 'message'  =>  '格式错误~']
            ],
            'bookId'   =>  [ // 整数型都可以用这个效验规则
                ['required'], ['integer',  'message'  =>  '格式错误~'],
                ['filter', 'filter' => function($attribute){
                    $attribute = trim($attribute);
                    $attribute = intval($attribute);
                    return $attribute;
                },]
            ],
            'STRING'    =>  [ // 字符串
                ['default', 'value' => '0'],
                ['filter', 'filter' => function($attribute){
                    $attribute = trim($attribute);
                    $attribute = (string)$attribute;
                    return $attribute;
                },]
            ],
            // 往后统一使用大写的形式
            'NICKNAME'  =>  [ // 昵称
                ['string', 'length' => [1, 20], 'tooLong' => '昵称长度最大为20个字符~'],
                // 定义为匿名函数的行内验证器 $attribute 就是控制器传入的字段名 如这里就是user_nickname
                // $this->$attribute 就是当前属性的值
                // 只要不$this->addError 则表示成功
                [function($attribute, $params){
                    // 验证姓名有效性
                    if(!UtilValidate::checkNameAllowSpace($this->$attribute)){
                        $this->addError($attribute, ErrorInfo::getECAEMBEC(ErrorCode::USER_NICKNAME_FORMAT_ERROR));
                    }
                }],
                // 昵称唯一 不为空时才效验
                ['unique', 'targetAttribute' => 'user_nickname',
                    'targetClass' => BookUserEntity::class,
                    'message'   =>  '昵称已被注册~']
            ],
            'EMAIL' =>  [ // 邮箱
                ['required'],
                ['email', 'message'   =>  '邮箱地址无效~']
            ],
            'ONLY_EMAIL' =>  [ // 在用户表唯一邮箱
                ['required', 'message' => '邮箱不能为空！'],
                ['email', 'message'   =>  '邮箱地址无效~'],
                // targetClass 用户表entity targetAttribute 在用户表中的字段
                ['unique', 'targetAttribute' => 'bind_email',
                    'targetClass' => BookUserEntity::class,
                    'message' => '邮箱已被注册~']
            ],
            'PASSWORD'  =>  [ // 密码
                ['required', 'message' => '密码怎么能是空的~'],
                ['string', 'length' => [6, 50], 'tooShort' => '密码位数最少6位~',
                    'tooLong' => '密码位数最多50位~'],
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
                        $this->addError($attribute,
                            ErrorInfo::getECAEMBEC(ErrorCode::USER_PASSWORD_DIFF_FAIL));
                    }
                }]
            ],
            'DATE'  =>  [ // 日期
                ['date', 'format'=>'yyyy-MM-dd']
            ],
            'SEX'   =>  [ // 性别
                ['in', 'range' => [0, 1, 2]]
            ],
            'ID_OR_EMAIL'   =>  [ // 一方书号或者邮箱
                ['required', 'message' => '你输入空账号干嘛~'],
                // 输入的账号要么是uid  要么是邮箱，否则不通过验证
                [function($attribute, $params){
                    if(!is_numeric($this->$attribute)){
                        // 如果又不是邮箱  则提示账号密码错误
                        if(!(new EmailValidator())->validate($this->$attribute)){
                            $this->addError($attribute, '你输入的账号和密码肯定有问题~');
                        }else{
                            // 是邮箱
                            AdditionalCacheData::$ID_OR_EMAIL = 2;
                        }
                    }else{
                        // 是uid
                        AdditionalCacheData::$ID_OR_EMAIL = 1;
                    }
                }],
            ],
            'BOOK_ID_IS_EXIST'  =>  [ // 书籍id是否在数据库存在
                ['required'],
                // 判断用户的book_id 在书架是否存在
                ['exist',
                    'targetClass' => BookBookshelfEntity::class,
                    'targetAttribute' => 'book_id'
                ]
            ],
            'BOOL'  =>  [ // 1 or 0
                ['default', 'value' => '0'],
                ['boolean']
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

        /**
         * @var  $field
         * @var ParamValidateType[] $rules
         */
        foreach ($fields as $field => $rules){
            /** @var ParamValidateType $value */
            foreach ($rules as &$value){
                // 如果使用 ParamValidateType 指定了共用的效验字段
                if($value instanceof ParamValidateType){
                    $rule = self::getRulesName()[$value->rule];
                    // 如果规则不存在  则不效验
                    if(empty($rule))continue;
                    $value = $value->value;
                    // 有公用效验字段的规则需要不同的效验方法
                    // $validateType 如 int、bookId、ONLY_EMAIL等
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
                        // 结果过滤 因为 'filter' 需要覆盖原数据
                        $fields = array_merge($fields, $result);
                    }
                }
            }
        }

        return $fields;
    }


}