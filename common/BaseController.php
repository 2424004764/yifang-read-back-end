<?php

/**
 * 预留的基础服务
 */

namespace app\common;

use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorInfo;
use app\common\utTrait\error\ErrorMsg;
use app\common\utTrait\error\ErrorTrain;
use yii\base\InvalidConfigException;
use yii\web\Controller;

class BaseController extends Controller
{

    use ErrorTrain;

    public bool $isNowReturn = false; // 是否立即返回数据到浏览器 比如某些错误信息要直接返回
    public utilValidatorsForm $_utilValidators; // 效验器|验证器

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_utilValidators = new utilValidatorsForm;
    }

    /**
     * 对 $isNowReturn 进行设置
     * @param $isNowReturn
     */
    public function setIsNowReturn($isNowReturn)
    {
        $this->isNowReturn = $isNowReturn;
    }

    /**
     * 直接输出json格式字符串 到浏览器
     * @param array $data 返回的数据
     * @param int $code 返回的状态码
     * @param string $msg 返回的消息
     * @return array
     */
    public function outPutJson($data = [], $code = 200, $msg = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = array(
            'code'  =>  $code,
            'data'  =>  $data,
            'msg'   =>  $msg
        );
        if($this->isNowReturn){
            \Yii::$app->response->data = $result;
            \yii::$app->response->send();
            exit();
        }

        return $result;
    }

    /**
     * swoole 模式下输出数据到浏览器
     * @param array $data
     * @param int $code
     */
    public function soSuccess($data = [], $code = 200)
    {
        \feehi\swoole\Util::dump(json_encode([
            'code'  =>  $code,
            'data'  =>  $data
        ]));
    }

    /**
     * 统一获取分页参数
     * 效验后返回
     * @param int $defaultPage 默认页码
     * @param int $defaultSize 默认每页多少数据
     * @return int[]
     */
    public function uniGetPaging($defaultPage = 1, $defaultSize = 10)
    {
        list($page, $size) = $this->getRequestParams(['page', 'size']);
        empty($page) && ($page = $defaultPage);
        empty($size) && ($size = $defaultSize);

        return [$page, $size];
    }

    /**
     * 获取参数并验证
     * @param array $paramsField 值需要在
     * \app\common\utilValidatorsForm::$RULES_NAME中定义名字和效验规则
     * 格式：['page'=>'int']  效验page参数的格式为int，而int被定义为['integer']
     * 支持 ['book_id'=>"book_id", 'name'=>'', 'age'] 自动识别
     * @param string $method 请求方式
     * @return array
     */
    public function getRequestParams($paramsField = [], $method = 'get')
    {
//        效验请求方式  只支持get、post
        $method = strtolower($method);
        if(!in_array($method, ['get', 'post'])){
            $this->setIsNowReturn(true);
            return $this->outPutJson([], ErrorCode::REQUEST_METHOD_FAIL,
                ErrorMsg::getErrMsg(ErrorCode::REQUEST_METHOD_FAIL)." 仅支持get、post");
        }
        if(empty($paramsField)){
            return [];
        }

        $params = [];

        // 获取指定的参数
        foreach ($paramsField as $field => &$type){
            if(is_numeric($field)) {
                $field = $type;
                $type = null;
            }
            if('get' === $method){
                $value = \Yii::$app->request->get($field);
            }else{
                $value = \Yii::$app->request->post($field);
            }

            if(!empty($type)){
                // 类型不为空  说明需要使用共用效验字段
                $value = new ParamValidateType($value, $type);
                $field = $type;
            }
            $params[$field] = $value;
            unset($value);
        }
        try {
            // 开始效验
            $validateData = utilValidatorsForm::validateParams($params);
            if (!$validateData) {
                $this->setIsNowReturn(true);
                return $this->outPutJson([], ErrorInfo::getErrCode(),
                    ErrorInfo::getErrMsg());
            }
        } catch (InvalidConfigException $e) {
            $this->setIsNowReturn(true);
            return $this->outPutJson([], ErrorCode::SYSTEM_ERROR,
                $e->getMessage());
        }
        return $validateData;
    }

    /**
     * 统一返回方法
     * @param $data array|false 需要返回的数据
     * @return array 构建好的返回数据
     */
    public function uniReturnJson($data)
    {
        if(false === $data){
            // 说明有错误
            return $this->outPutJson([], self::getErrCode(), self::getErrMsg());
        }
        return $this->outPutJson($data, ErrorCode::SUCCESS, ErrorMsg::$SUCCESS);
    }
}