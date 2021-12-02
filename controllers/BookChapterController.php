<?php

namespace app\controllers;

use app\common\entity\BookChapterContentEntity;
use app\common\services\BookChapterContentService;
use app\common\services\BookChapterService;
use app\common\utTrait\QueryParams;
use Yii;
use app\common\entity\BookChapterEntity;
use app\common\searchs\BookChapterSearch;
use app\common\BaseController;
use yii\base\BaseObject;
use yii\helpers\StringHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookChapterController implements the CRUD actions for BookChapterEntity model.
 * book-chapter
 */
class BookChapterController extends BaseController
{

    private BookChapterService $_bookChapterService; //服务对应的操作数据库的类
    private BookChapterContentService $_bookChapterContentService; //服务对应的操作数据库的类

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookChapterService = new BookChapterService;
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
     * Lists all BookChapterEntity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookChapterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookChapterEntity model.
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
     * Creates a new BookChapterEntity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookChapterEntity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->chapter_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookChapterEntity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->chapter_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookChapterEntity model.
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
     * 删除 api
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteApi($id)
    {
        $this->findModel($id)->delete();

        return $this->uniReturnJson($data);
    }

    /**
     * Finds the BookChapterEntity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookChapterEntity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookChapterEntity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 根据书籍id获取该书籍的章节信息 每次100条
     * @return array
     */
    public function actionGetChapterList()
    {
        $ps = $this->uniGetPaging(1, 100);
        $params = $this->getRequestParams(['book_id' => "bookId"]);
        $queryParams = new QueryParams();
        $queryParams->loadPageSize($ps);
        $queryParams->where([
            'book_id' => $params['book_id']
        ]);
        $queryParams->orderBy('chapter_id asc');

        return $this->uniReturnJson($this->_bookChapterService->getItem($queryParams));
    }

    public function actionCreateApi()
    {
        $params = $this->getRequestParams([
            'book_id' => "bookId",
            'chapter_name' => "STRING",
            'chapter_content' => "STRING",
        ], 'post');

        $chapterEntity = new BookChapterEntity();
        $chapterEntity->book_id = $params['book_id']; // 不为空
        $chapterEntity->chapter_name = $params['chapter_name']; // 不为空
        $chapter = $this->_bookChapterService->insert($chapterEntity);

        $chapterContentEntity = new BookChapterContentEntity();
        $chapterContentEntity->chapter_id = $chapterEntity->chapter_id;
        $chapterContentEntity->chapter_content = $params['chapter_content'];
        $this->_bookChapterContentService->insert($chapterContentEntity);

        return $this->uniReturnJson([
            'chapter_id' => $chapterEntity->chapter_id
        ]);
    }

}
