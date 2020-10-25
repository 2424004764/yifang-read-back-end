<?php

/**
 * 预留的基础服务
 */

namespace app\common;

use yii\helpers\Json;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * 直接输出json格式字符串
     * @param array $data 返回的数据
     * @param int $code 返回的状态码
     * @param string $msg 返回的消息
     * @return array
     */
    public function outPutJson($data = [], $code = 200, $msg = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return array(
            'code'  =>  $code,
            'data'  =>  $data,
            'msg'   =>  $msg
        );
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
}