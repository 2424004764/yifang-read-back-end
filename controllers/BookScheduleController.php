<?php

namespace app\controllers;

use app\common\services\BookScheduleService;
use app\common\utTrait\QueryParams;
use Yii;
use app\common\entity\BookScheduleEntity;
use app\common\searchs\BookScheduleSearch;
use app\common\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookScheduleController implements the CRUD actions for BookScheduleEntity model.
 * book-schedule
 */
class BookScheduleController extends BaseController
{

    private BookScheduleService $_bookScheduleService;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookScheduleService = new BookScheduleService;
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
     * Lists all BookScheduleEntity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookScheduleEntity model.
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
     * Creates a new BookScheduleEntity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookScheduleEntity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->schedule_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookScheduleEntity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->schedule_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookScheduleEntity model.
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
     * Finds the BookScheduleEntity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookScheduleEntity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookScheduleEntity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 保存|更新 阅读进度
     */
    public function actionAddSchedule()
    {
        $params = $this->getRequestParams([
            'user_id' => ['bookId'],
            'book_id' => ['bookId'],
            'chapter_id' => ['bookId'],
            'schedule' => ['STRING'],
            'is_first' => ['BOOL'],
        ], 'post');

        return $this->uniReturnJson($this->_bookScheduleService
            ->addSchedule($params));
    }

    /**
     * 获取某本书保存的章节信息
     */
    public function actionGetSchedule()
    {
        $params = $this->getRequestParams([
            'user_id' => ['bookId'],
            'book_id' => ['bookId'],
        ]);

        $query = new QueryParams();
        $query->select = 'user_id, book_id, chapter_id, schedule';
        $query->where($params);

        return $this->uniReturnJson($this->_bookScheduleService
            ->getItem($query, true));
    }
}
