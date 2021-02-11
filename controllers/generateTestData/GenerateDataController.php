<?php

namespace app\controllers\generateTestData;

use app\common\BaseController;
use app\common\services\GenerateTestData\GenerateDataService;
use app\common\train\error\ErrorInfo;

class GenerateDataController extends BaseController
{

    private $generateTestDataService = null;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        /** @var GenerateDataService $generateTestDataService */
        $this->generateTestDataService = \Yii::createObject(GenerateDataService::class);
    }

    /**
     * 测试方法
     * @return array
     */
    public function actionTest()
    {
        return $this->outPutJson();
    }

    /**
     * 批量生成book相关测试数据
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGenerateBook()
    {
        $generate_count = (int)\Yii::$app->request->get('generate_count', 1);
        $data = $this->generateTestDataService->dealGenerateTestData($generate_count);
        if (false == $data) {
            return $this->outPutJson([], ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
        }
        return $this->outPutJson($data, 200, '成功');
    }


    /**
     * 生成测试用户
     * @return array
     */
    public function actionGenerateTestUser()
    {
        $generate_count = (int)\Yii::$app->request->get('generate_count', 1);
        $data = $this->generateTestDataService->GenerateTestUser($generate_count);
        if (false == $data) {
            return $this->outPutJson([], ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
        }
        return $this->outPutJson($data, 200, '成功');
    }

    /**
     * 生成测试章节内容   这里因为我在本地电脑开发  会有不知原因的失败
     * 如果失败 请看$this->generateTestDataService->GenerateTestChapter($generate_count);的备注
     * @return array
     */
    public function actionGenerateTestChapter()
    {
        $generate_count = (int)\Yii::$app->request->get('generate_count', 1);
        $data = $this->generateTestDataService->GenerateTestChapter($generate_count);
        if (false == $data) {
            return $this->outPutJson([], ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
        }
        return $this->outPutJson($data, 200, '成功');
    }

    public function actionGenerateTestChapterContent()
    {
        $generate_count = (int)\Yii::$app->request->get('generate_count', 1);
        $data = $this->generateTestDataService->GenerateTestChapterContent($generate_count);
        if (false == $data) {
            return $this->outPutJson([], ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
        }
        return $this->outPutJson($data, 200, '成功');
    }

}