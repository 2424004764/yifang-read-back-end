<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/12/17 0017
 * Time: 20:50
 */

namespace app\controllers;


use app\common\BaseController;
use app\common\services\BookBookshelfService;
use app\common\utTrait\QueryParams;

class BookBookshelfController extends BaseController
{

    private BookBookshelfService $_bookBookShelfService; // 控制器对应的服务类

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_bookBookShelfService = new BookBookshelfService;
    }

    /**
     * 加入|移除书架
     * 需要判断是否已加入
     * @return array
     * @throws \Exception
     */
    public function actionJoinBookshelf()
    {
        // 只验证是否必填、整型、函数过滤
        $params = $this->getRequestParams([
            'book_id' => "bookId",
            'user_id' => 'bookId'
        ]);
        $queryParams = new QueryParams();
        $queryParams->where($params);

        $data = $this->_bookBookShelfService->joinBookShelf($queryParams);

        return $this->uniReturnJson($data);
    }

    /**
     * 是否已加入书架
     * @return array
     * @throws \Exception
     */
    public function actionIsJoinBookShelf()
    {
        // 只验证是否必填、整型、函数过滤
        $params = $this->getRequestParams([
            'book_id' => "bookId",
            'user_id' => 'bookId'
        ]);
        $queryParams = new QueryParams();
        $queryParams->where($params);

        $result = $this->_bookBookShelfService->isExistBookshelf($queryParams);

        $data = [];
        if (is_numeric($result)) {
            $data['is_join'] = $result;
        }

        return $this->uniReturnJson($data);
    }

    /**
     * 获取书架的书籍列表
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetList()
    {
        $ps = $this->uniGetPaging(1, 20);
        $params = $this->getRequestParams(['user_id' => "bookId"]);

        return $this->uniReturnJson($this->_bookBookShelfService->getBookshelfList($params, $ps));
    }

    /**
     * 获取书架的书籍列表
     * 直接一条通过SQL获取按阅读时间倒序的书籍列表
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetListV2()
    {
        $ps = $this->uniGetPaging(1, 20);
        $params = $this->getRequestParams(['user_id' => "bookId"]);

        return $this->uniReturnJson($this->_bookBookShelfService->getBookshelfListV2($params, $ps));
    }


    /**
     * 获取书架的书籍列表
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetListV3()
    {
        $ps = $this->uniGetPaging(1, 20);
        $params = $this->getRequestParams(['user_id' => "bookId"]);

        return $this->uniReturnJson($this->_bookBookShelfService->getBookshelfListV3($params, $ps));
    }

    /**
     * 更新加入书架的时间 update_on字段
     */
    public function actionUpdateJoinDate()
    {
        $params = $this->getRequestParams(['bookshelf_id' => "bookId"], 'post');

        return $this->uniReturnJson($this->_bookBookShelfService->updateJoinDate($params));
    }

}