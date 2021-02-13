<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/2/13 0013
 * Time: 11:15
 */

namespace app\controllers;


use app\common\BaseController;
use app\common\services\BookFeedbackService;

class BookFeedbackController extends BaseController
{
    private BookFeedbackService $_bookFeedbackService;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookFeedbackService = new BookFeedbackService;
    }

    /**
     * 添加反馈
     */
    public function actionAddFeedback()
    {
        $params = $this->getRequestParams([
            'user_id' => ["bookId"],
            'feedback_content' => ["STRING"],
        ], 'post');

        return $this->uniReturnJson($this->_bookFeedbackService->addFeedback($params));
    }
}