<?php

namespace app\controllers;

use app\common\BaseController;
use app\common\FileUpload;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorInfo;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        return 'error112221';
    }

    public function actionTestApi()
    {
        return ['code' => 200];
    }


    /**
     * 测试用上传示例
     *
     * @throws \Exception
     */
    public function actionUploadFile()
    {
        $file = UploadedFile::getInstanceByName('img');
        if (empty($file)) {
            return $this->uniReturnJson([], ErrorCode::UPLOAD_FILE_EMPTY, ErrorInfo::getECAEMBEC(ErrorCode::UPLOAD_FILE_EMPTY, false));
        }
        $prefix = substr(strrchr($file->name, '.'), 1);
        $uploadFileName = (new FileUpload())->uploadFile($file->tempName, $prefix);

        $data = [
            'src' => $uploadFileName
        ];
        return $this->uniReturnJson($data);
    }
}
