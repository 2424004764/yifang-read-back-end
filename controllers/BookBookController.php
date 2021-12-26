<?php

namespace app\controllers;

use app\common\entity\BookAuthorDetailEntity;
use app\common\entity\BookClassEntity;
use app\common\services\BookBookAuthorDetailService;
use app\common\services\BookBookService;
use app\common\utTrait\error\ErrorCode;
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
    private BookBookAuthorDetailService $_bookBookAuthorService; // 控制器对应的服务类

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookBookService = new BookBookService;
        $this->_bookBookAuthorService = new BookBookAuthorDetailService;
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
     * 更新api接口
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionUpdateApi()
    {
        $params = $this->getRequestParams([
            'book_id' => "bookId",
            'is_hot' => "SEX",
            'book_status' => "SEX"
        ], 'post');

        return $this->uniReturnJson($this->_bookBookService->update($params));
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
     * todo 自己写的querywhere 还是不行，得用yii自带的查询 在做书籍姓名搜索、-
     * @return array
     */
    public function actionGetBookList()
    {
        $ps = $this->uniGetPaging(1, 50);
        $params = $this->getRequestParams([
            'is_hot' => ['int'],
            'book_status' => 'ARRAY',
            'book_name' => 'STRING'
        ]);
        $params['is_hot'] = $params['is_hot'] == 2 ? $params['is_hot'] = 0 : $params['is_hot'];

        list($count, $list) = $this->_bookBookService->getBookList($params, $ps);

        $data = [
            'list' => $list,
            'page' => $ps['page'],
            'size' => $ps['size'],
            'count' => (int)$count,
        ];

        return $this->uniReturnJson($data);
    }

    /**
     * 根据书籍id获取书籍详情 含其他信息，如：书籍详情
     * @return array
     */
    public function actionGetBookDetailById()
    {
        $params = $this->getRequestParams(['book_id' => "bookId"]);
        return $this->uniReturnJson($this->_bookBookService->getItemDetail($params['book_id']));
    }

    public function actionCreateApi()
    {
        $params = $this->getRequestParams([
            'book_name' => "STRING",
            'book_author' => "STRING",
            'class_id' => ["INT", 'STRING'],
            'cover_img_url' => 'STRING',
            'book_desc' => 'STRING',
        ], 'post');

        $bookEntity = new BookBookEntity;
        $bookEntity->book_name = $params['book_name'];
        $bookEntity->book_cover_imgs = json_encode([$params['cover_img_url']]);
        $bookEntity->book_desc = $params['book_desc'];
        $bookEntity->book_class_id = $params['class_id'];
        /** @var BookBookEntity $book */
        $book = $this->_bookBookService->insert($bookEntity);

        $authorEntity = new BookAuthorDetailEntity;
        $authorEntity->book_id = $book->book_id;
        $authorEntity->book_author = $params['book_author'];
        $authorEntity->book_author_desc = '';
        $this->_bookBookAuthorService->insert($authorEntity);

        return $this->uniReturnJson([
            'book_id' => $book->book_id
        ]);
    }

}
