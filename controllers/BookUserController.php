<?php

namespace app\controllers;

use app\common\services\BookUserService;
use Yii;
use app\common\entity\BookUserEntity;
use app\common\searchs\BookUserSearch;
use app\common\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookUserController implements the CRUD actions for BookUserEntity model.
 * book-user
 */
class BookUserController extends BaseController
{

    private BookUserService $_bookUserService; //服务对应的操作数据库的类

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookUserService = new BookUserService;
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
     * Lists all BookUserEntity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookUserEntity model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BookUserEntity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookUserEntity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookUserEntity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookUserEntity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BookUserEntity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookUserEntity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookUserEntity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 注册
     * @return array
     */
    public function actionRegister()
    {
        $params = $this->getRequestParams([
            "nickname" => "NICKNAME",
            'email' => 'ONLY_EMAIL',
            'password' => 'PASSWORD',
            'againPassword' => 'CONFIRM_PASSWORD',
            'birthday' => 'DATE',
            'sex' => 'SEX'
        ], 'post');
        // 数据验证后
        /** @var BookUserEntity $user */
        $user = $this->_bookUserService->register($params);
        if (false === $user) {
            return $this->uniReturnJson($user);
        }

        return $this->uniReturnJson($user);
    }

    /**
     * 登录
     * @return array
     * @throws \Exception
     */
    public function actionLogin()
    {
        $params = $this->getRequestParams([
            'idOrEmail' => 'ID_OR_EMAIL',
            'password' => 'PASSWORD'
        ], 'post');
        $result = $this->_bookUserService->login($params);

        return $this->uniReturnJson($result);
    }

    /**
     * 修改用户信息
     * 可以只传一个要改的字段 也可以传多个
     */
    public function actionUpdateUserInfo()
    {
        $params = $this->getRequestParams([
            'user_id' => 'bookId', // 必传
            'user_nickname' => 'NICKNAME',
            'user_headimg' => 'NET-FILE',
            'sex' => 'SEX',
            'birthday' => 'DATE',
            'birthday_type' => 'SEX',
            'bind_email' => 'EMAIL_SURE_EMPTY',
        ], 'post');

        return $this->uniReturnJson($this->_bookUserService->updateUsrInfo($params));
    }
}
