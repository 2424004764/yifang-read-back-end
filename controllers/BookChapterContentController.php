<?php

namespace app\controllers;

use app\common\services\BookChapterContentService;
use app\common\utTrait\QueryParams;
use Yii;
use app\common\entity\BookChapterContentEntity;
use app\common\searchs\BookChapterContentSearch;
use app\common\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookChapterContentController implements the CRUD actions for BookChapterContentEntity model.
 * book-chapter-content
 */
class BookChapterContentController extends BaseController
{
    /**
     * @var mixed
     */
    private BookChapterContentService $_bookChapterContentService;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookChapterContentService = new BookChapterContentService;
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
     * Lists all BookChapterContentEntity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookChapterContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookChapterContentEntity model.
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
     * Creates a new BookChapterContentEntity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookChapterContentEntity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->chapter_content_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookChapterContentEntity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->chapter_content_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookChapterContentEntity model.
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
     * Finds the BookChapterContentEntity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookChapterContentEntity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookChapterContentEntity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * 获取章节内容详情
     * @return array
     */
    public function actionGetChapterContent()
    {
        $params = $this->getRequestParams(['chapter_id'=>"bookId"]);
        $queryParams = new QueryParams();
        $queryParams->where([
            'chapter_id'   =>  $params['chapter_id']
        ]);

        return $this->uniReturnJson($this->_bookChapterContentService->getItem($queryParams));
    }
}
