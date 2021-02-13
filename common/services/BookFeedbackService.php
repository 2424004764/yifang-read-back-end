<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/2/13 0013
 * Time: 11:11
 */

namespace app\common\services;


use app\common\entity\BookFeedbackEntity;
use app\common\repository\BookFeedbackRepository;
use app\common\utTrait\error\ErrorCode;

class BookFeedbackService extends BaseService
{
    private BookFeedbackRepository $_bookFeedbackRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_bookFeedbackRepository = new BookFeedbackRepository;
        $this->Entity = new BookFeedbackEntity; // 初始化查询的Entity
    }

    /**
     * 添加反馈
     * @param $params
     * @return bool
     */
    public function addFeedback($params)
    {
        $this->Entity->user_id = $params['user_id'];
        $this->Entity->feedback_content = $params['feedback_content'];

        return $this->save();
    }
}