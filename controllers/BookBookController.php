<?php

namespace app\controllers;

use app\common\services\BookBookService;
use app\common\utTrait\QueryParams;
use Yii;
use app\common\entity\BookBookEntity;
use app\common\searchs\BookBookSearch;
use app\common\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookBookController implements the CRUD actions for BookBookEntity model.
 * book-book
 */
class BookBookController extends BaseController
{

    private BookBookService $_bookBookService; // 控制器对应的服务类

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookBookService = new BookBookService;
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
     * Lists all BookBookEntity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookBookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookBookEntity model.
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
     * Creates a new BookBookEntity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookBookEntity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->book_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookBookEntity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->book_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookBookEntity model.
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
     * Finds the BookBookEntity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookBookEntity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookBookEntity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 获取书籍列表
     * @return array
     */
    public function actionGetBookList()
    {
        list($page, $size) = $this->uniGetPaging();
        $queryParams = new QueryParams();
        $queryParams->limit($size);
        $queryParams->offset($page);
        return $this->uniReturnJson($this->_bookBookService->getItem($queryParams));
    }

    /**
     * 根据书籍id获取书籍详情 含其他信息，如：书籍详情
     * @return array
     */
    public function actionGetBookDetailById()
    {
        $book_id = (int)\Yii::$app->request->get('book_id', 0);
        return $this->uniReturnJson($this->_bookBookService->getItemDetail($book_id));
    }

}
