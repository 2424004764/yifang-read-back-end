<?php

/**
 * 预留的基础服务
 */

namespace app\common;

use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * 直接输出json格式字符串
     * @param array $data
     * @param int $code
     */
    public function jsonSuccess($data = [], $code = 200)
    {
        echo json_encode(array(
            'code'  =>  $code,
            'data'  =>  $data
        ));
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