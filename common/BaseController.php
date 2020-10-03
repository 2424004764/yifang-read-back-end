<?php

namespace app\common;

use yii\web\Controller;


class BaseController extends Controller
{
    public function jsonSuccess($data = [], $code = 200)
    {
        echo json_encode(array(
            'code'  =>  $code,
            'data'  =>  $data
        ));
    }
}