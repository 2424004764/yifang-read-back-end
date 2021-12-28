<?php

namespace app\controllers;

use app\common\services\EnCollectionService;
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
 */
class EnCollectionController extends BaseController
{

    public function actionCollection()
    {
        $params = $this->getRequestParams([
            'en_id' => "int",
            'user_id' => "int",
        ], 'post');

        if (empty($params['en_id']) || empty($params['user_id'])) {
            return $this->uniReturnJson([], ErrorInfo::getECAEMBEC(ErrorCode::PARAM_EMPTY, false));
        }

        $result = (new EnCollectionService())->collection($params);
        return $this->uniReturnJson($result);
    }

    public function actionIsCollection()
    {
        $params = $this->getRequestParams([
            'en_id' => "int",
            'user_id' => "int",
        ], 'get');
        if (empty($params['en_id']) || empty($params['user_id'])) {
            return $this->uniReturnJson([], ErrorInfo::getECAEMBEC(ErrorCode::PARAM_EMPTY, false));
        }
        $result = (new EnCollectionService())->isCollection($params);

        return $this->uniReturnJson($result ? 1 : 0);
    }

}
