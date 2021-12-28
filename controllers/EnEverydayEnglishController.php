<?php

namespace app\controllers;

use app\common\services\EnEverydayEnglishService;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\error\ErrorInfo;
use Yii;
use app\common\entity\BookBookmarkEntity;
use app\common\searchs\BookBookmarkSearch;
use app\common\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookBookmarkController implements the CRUD actions for BookBookmarkEntity model.
 * book-bookmark
 */
class EnEverydayEnglishController extends BaseController
{
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

    public function actionList()
    {
        $ps = $this->uniGetPaging(1, 10);
        $params = $this->getRequestParams([
            'content' => "STRING",
            'translate' => "STRING",
            'created_on' => "STRING",
            'is_release' => "STRING",
            'user_id'   => 'int'
        ], 'get');

        list($count, $list) = (new EnEverydayEnglishService())->list($ps, $params);
        $data = [
            'list' => $list,
            'page' => $ps['page'],
            'size' => $ps['size'],
            'count' => (int)$count,
        ];

        return $this->uniReturnJson($data);
    }


    public function actionDel()
    {
        $params = $this->getRequestParams([
            'en_id' => "STRING",
        ], 'post');

        $result = (new EnEverydayEnglishService())->del($params['en_id']);
        return $this->uniReturnJson();
    }

    public function actionEdit()
    {
        $params = $this->getRequestParams([
            'en_id' => "STRING",
            'content' => "STRING",
            'cover_img' => "STRING",
            'translate' => "STRING",
            'source' => "STRING",
            'release_date' => "STRING",
            'is_release' => 'STRING',
        ], 'post');
        if (empty($params['en_id'])) {
            return $this->uniReturnJson([], ErrorInfo::getECAEMBEC(ErrorCode::PARAM_EMPTY, false));
        }

        $result = (new EnEverydayEnglishService())->edit($params);
        return $this->uniReturnJson($result);
    }

    public function actionAdd()
    {
        $params = $this->getRequestParams([
            'content' => "STRING",
            'cover_img' => "STRING",
            'translate' => "STRING",
            'source' => "STRING",
            'release_date' => "STRING",
        ], 'post');

        $result = (new EnEverydayEnglishService())->add($params);
        return $this->uniReturnJson($result);
    }

    public function actionDetail()
    {
        $params = $this->getRequestParams([
            'en_id' => "STRING",
            'user_id' => "STRING",
        ], 'get');

        if (empty($params['en_id'])) {
            return $this->uniReturnJson([], ErrorInfo::getECAEMBEC(ErrorCode::PARAM_EMPTY, false));
        }

        $result = (new EnEverydayEnglishService())->detail($params);
        return $this->uniReturnJson($result);
    }

}
