<?php

namespace app\controllers;

use app\common\BaseController;
use app\common\services\BookUserSettingService;
use yii\filters\VerbFilter;

/**
 * BookUserController implements the CRUD actions for BookUserEntity model.
 * book-user
 */
class BookUserSettingController extends BaseController
{

    private BookUserSettingService $_bookUserSettingService; //服务对应的操作数据库的类

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookUserSettingService = new BookUserSettingService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 添加或修改设置
     */
    public function actionAddSetting()
    {
        $params = $this->getRequestParams([
            'user_id'   =>  ['bookId'],
            'name'   =>  ['STRING'],
            'value'   =>  ['STRING'],
        ], 'post');

        return $this->uniReturnJson($this->_bookUserSettingService
        ->addSetting($params));
    }

}
