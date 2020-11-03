<?php

namespace app\controllers;

use app\common\utTrait\QueryParams;
use app\common\services\BookClassService;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorInfo;
use app\common\utTrait\error\ErrorMsg;
use Yii;
use app\common\entity\BookClassEntity;
use app\common\searchs\BookClassSearch;
use app\common\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookClassController implements the CRUD actions for BookClassEntity model.
 * book-class
 */
class BookClassController extends BaseController
{

    private BookClassService $_bookClassService; // 控制器对应的服务类
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookClassService = new BookClassService;
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
     * Lists all BookClassEntity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookClassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookClassEntity model.
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
     * Creates a new BookClassEntity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookClassEntity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->book_class_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookClassEntity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->book_class_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookClassEntity model.
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
     * Finds the BookClassEntity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookClassEntity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookClassEntity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 获取分类
     * @return array
     */
    public function actionGetClass()
    {
        list($page, $size) = $this->uniGetPaging();
        $queryParams = new QueryParams();
        $queryParams->limit($size);
        $queryParams->offset($page);
        $data = $this->_bookClassService->getItem($queryParams);
        if(false == $data){
            return $this->outPutJson([], ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
        }
        return $this->outPutJson($data, ErrorCode::SUCCESS, ErrorMsg::$SUCCESS);
    }
}
