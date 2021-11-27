<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/12/17 0017
 * Time: 20:51
 */

namespace app\common\services;


use app\common\entity\BookBookEntity;
use app\common\entity\BookBookshelfEntity;
use app\common\entity\BookHistoryEntity;
use app\common\repository\BookBookshelfRepository;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\QueryParams;

class BookBookshelfService extends BaseService
{

    private BookBookshelfRepository $_bookBookshelfRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookBookshelfRepository = new BookBookshelfRepository;
        $this->Entity = new BookBookshelfEntity;
    }

    /**
     * 是否已加入书架
     * @param QueryParams $queryParams
     * @return bool
     * @throws \Exception
     */
    public function isExistBookshelf($queryParams)
    {
        try {
            return (int)$this->_bookBookshelfRepository->isExist($queryParams, $this->Entity);
        } catch (\Exception $exception) {
            return self::setAndReturn(ErrorCode::SYSTEM_ERROR,
                $exception->getMessage());
        }
    }

    /**
     * 加入|移除书架
     * @param QueryParams $queryParams
     * @return bool
     * @throws \Exception
     */
    public function joinBookShelf($queryParams)
    {
        try {
            if ($this->isExistBookshelf($queryParams)) { // 已加入书架  则取消加入

                return $this->del($queryParams);
            }
            // 开始加入书架
            $this->Entity->setAttributes($queryParams->where);

            return $this->save();
        } catch (\Exception $exception) {
            return self::setAndReturn(ErrorCode::BOOKSHELF_SAVE_FAIL);
        }
    }

    /**
     * 获取书架列表
     * @param $params array 前端传递的参数
     * @param $ps array 分页参数
     * @return BookBookshelfEntity[]
     * @throws \yii\base\InvalidConfigException
     */
    public function getBookshelfList($params, $ps)
    {
        $queryParams = new QueryParams();
        $queryParams->loadPageSize($ps);
        $queryParams->where([
            'user_id' => $params['user_id']
        ]);

        /** @var BookBookshelfEntity[] $raw_data */
        $queryParams->select = 'book_id';
        $queryParams->orderBy = 'bookshelf_id desc';
        $raw_data = $this->getItem($queryParams);
        $count = $this->count($queryParams);

        /** @var BookBookService $bookService */
        $bookService = \Yii::createObject(BookBookService::class);
        foreach ($raw_data as &$book) {
            // 去掉加入书架时间
            $queryParams = new QueryParams();
            $queryParams->select = 'book_name, book_cover_imgs';
            $queryParams->where = [
                'book_id' => $book->book_id
            ];
            $book = $book->toArray();
            $book['detail'] = $bookService->getItem($queryParams, true);

            // 获取书籍阅读进度
            /** @var BookHistoryService $historyService */
            $historyService = \Yii::createObject(BookHistoryService::class);
            /** @var BookHistoryEntity $schedule */
            $schedule = $historyService->getReadHistory($params['user_id'], $book['book_id']);
            if (!empty($schedule)) {
                $book['read_schedule'] = $schedule->schedule;
            } else {
                $book['read_schedule'] = '未阅读';
            }
        }

        return [
            'pageSize' => $ps['size'],
            'pageIndex' => $ps['page'],
            'list' => $raw_data,
            'total' => $count,
        ];
    }

    /**
     * 获取书架列表
     * 直接一条通过SQL获取按阅读时间倒序的书籍列表
     * todo 以前没发现的问题：可能我只是加入书架，但是没有阅读，所以就下面方法就取不到已加入书架的书籍
     * 所以得新增一个版本来处理这种情况
     * @param $params array 前端传递的参数
     * @param $ps array 分页参数
     * @return BookBookshelfEntity[]
     * @throws \yii\base\InvalidConfigException
     */
    public function getBookshelfListV2($params, $ps)
    {
        $query = $this->Entity::find()
            ->from($this->Entity::tableName() . ' bs') // 为当前表加别名
            ->select('bs.book_id,bk.book_name,bk.book_cover_imgs,bh.`schedule`')
            ->where(['bs.user_id' => $params['user_id'], 'bh.user_id' => $params['user_id']])
            ->innerJoin(BookBookEntity::tableName() . ' bk', 'bs.book_id = bk.book_id')
            ->leftJoin(BookHistoryEntity::tableName() . ' bh', 'bk.book_id = bh.book_id')
            ->orderBy('bh.update_on DESC,bs.bookshelf_id');
        $sql = $query->createCommand()->getRawSql(); // 生成SQL语句
        $count = $query->count();
        $raw_data = $query->limit($ps['size'])
            ->offset(($ps['page'] - 1) * $ps['size'])
            ->asArray()
            ->all();

        foreach ($raw_data as &$item) {
            if (empty($item['schedule'])) {
                $item['read_schedule'] = '未阅读';
            } else {
                $item['read_schedule'] = $item['schedule'];
            }
            unset($item['schedule']);
        }

        return [
            'pageSize' => $ps['size'],
            'pageIndex' => $ps['page'],
            'list' => $raw_data,
            'total' => $count,
        ];
    }

    /**
     * 获取加入书架的书籍
     * 点击书架中的数据同时  需要更新该书籍的加入书架时间  也就是book_bookshelf表的update_on字段
     * @param $params
     * @param $ps
     */
    public function getBookshelfListV3($params, $ps)
    {
        $data = [];
        // 先分页获取书架的书籍 再获取书籍进度和书籍信息
        $bookShelf_query = BookBookshelfEntity::find()->select('bookshelf_id, book_id')
            ->where([
                'user_id' => $params['user_id']
            ]);
        $bookShelf_list = $bookShelf_query->limit($ps['size'])
            ->offset(($ps['page'] - 1) * $ps['size'])->orderBy('update_on desc')->asArray()->all();
        $count = $bookShelf_query->count();

        if (empty($bookShelf_list)) {
            return $data;
        }
        $book_id = [];
        foreach ($bookShelf_list as $shelf) {
            $book_id[] = $shelf['book_id'];
        }

        // 批量获取书籍进度
        $book_history = BookHistoryEntity::find()->select('book_id, schedule')
            ->where([
                'user_id' => $params['user_id'],
                'book_id' => $book_id
            ])->all();
        // 处理隐射关系
        $book_history_map = [];
        foreach ($book_history as $history) {
            $book_history_map[$history['book_id']] = $history['schedule'];
        }

        // 批量获取书籍信息
        $book_info = BookBookEntity::find()->select('book_id, book_name, book_cover_imgs')
            ->where([
                'book_id' => $book_id
            ])
            ->all();
        // 处理隐射关系
        $book_map = [];
        foreach ($book_info as $book) {
            $book_map[$book['book_id']] = [
                'book_name' => $book['book_name'],
                'book_cover_imgs' => $book['book_cover_imgs'],
            ];
        }

        // 组装数据
        foreach ($bookShelf_list as $shelf) {
            $data[] = [
                'bookshelf_id' => $shelf['bookshelf_id'],
                'book_id' => $shelf['book_id'],
                'book_name' => $book_map[$shelf['book_id']]['book_name'],
                'book_cover_imgs' => $book_map[$shelf['book_id']]['book_cover_imgs'],
                'read_schedule' => isset($book_history_map[$shelf['book_id']]) ? $book_history_map[$shelf['book_id']] : '未阅读',
            ];
        }

        return [
            'pageSize' => $ps['size'],
            'pageIndex' => $ps['page'],
            'list' => $data,
            'total' => $count,
        ];
    }

    public function updateJoinDate($params)
    {
        $queryParams = new QueryParams();
        $queryParams->where(['bookshelf_id' => $params['bookshelf_id']]);
        $entity = $this->getItem($queryParams, true);
        if (empty($entity)) {
            return self::setAndReturn(ErrorCode::BOOKSHELF_RECORD_NOT_FOUND);
        }
        $this->Entity = $entity;

        $this->Entity->setAttributes(['update_on' => date("Y-m-d H:i:s")]);
        return $this->save();
    }
}