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
     * 获取收藏的书籍列表
     * @return array
     */
    public function actionGetList()
    {
        $ps = $this->uniGetPaging(1, 20);
        $queryParams = new QueryParams();
        $queryParams->limit($ps['size']);
        $queryParams->offset($ps['page']);

        $params = $this->getRequestParams(['user_id' => "bookId"]);
        $queryParams->where([
            'user_id' => $params['user_id']
        ]);

        return $this->uniReturnJson($this->_bookBookShelfService->getBookshelfList($queryParams));
    }

}