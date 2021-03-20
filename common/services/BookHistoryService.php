<?php
/**
 * 用户阅读的书籍历史 以及阅读进度 总的进度（按章节数算，如果100个章节，阅读到第二章，那么进度就是2%）
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/2/14 0014
 * Time: 14:42
 */

namespace app\common\services;


use app\common\entity\BookBookEntity;
use app\common\entity\BookHistoryEntity;
use app\common\repository\BookHistoryRepository;
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\QueryParams;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class BookHistoryService extends BaseService
{
    private BookHistoryRepository $_BookHistoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_BookHistoryRepository = new BookHistoryRepository();
        $this->Entity = new BookHistoryEntity;
    }

    /**
     * 记录书籍阅读进度 如 60
     * @param $book_id string 书籍id
     * @param $chapter_id string 章节id
     * @return float|int|string
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function calcReadSchedule($book_id, $chapter_id)
    {
        // 根据已阅读到的章节 再获取全部章节 再计算已阅读章节在全部章节中的位置得到阅读的百分比
        /** @var BookChapterService $chapterService */
        $chapterService = \Yii::createObject(BookChapterService::class);
        $percentage = $chapterService->getPercentageByChapter($book_id, $chapter_id);
        if (isset($percentage['chapter_count']) && isset($percentage['chapter_current'])) {
            return round($percentage['chapter_current'] / $percentage['chapter_count'], 2) * 100;
        } else {
            return '0';
        }
    }

    /**
     * 添加阅读记录
     * @param $params
     * @return bool
     */
    public function addHistory($params)
    {
        $query = new QueryParams();
        $query->where([
            'user_id' => $params['user_id'],
            'book_id' => $params['book_id']
        ]);

        if ($item = $this->getItem($query, true)) {
            $this->Entity = $item;
            // 有阅读记录 计算书籍的阅读进度
            $this->Entity->schedule = $params['schedule'] . '%';
        } else {
            $this->Entity->user_id = $params['user_id'];
            $this->Entity->book_id = $params['book_id'];
            $this->Entity->schedule = '0%';
        }
        $this->Entity->update_on = date("Y-m-d H:i:s", time());

        return $this->save();
    }

    /**
     * 获取阅读历史  分页
     * @param $ps array 分页参数
     * @param $params array 查询参数
     * @return array
     * @throws InvalidConfigException
     */
    public function getHistoryList($ps, $params)
    {
        $query = new QueryParams();
        $query->where([
            'user_id' => $params['user_id']
        ]);
        $query->select = 'history_id, book_id, schedule, create_on';
        $query->loadPageSize($ps)
            ->orderBy('update_on desc, history_id desc');

        $count = $this->count($query);
        /** @var BookHistoryEntity[]|null $data */
        $data = $this->getItem($query);
        if (!empty($data)) {
            $book_ids = $this->getBookIdByEntitys($data); // 需要查询的book_id集合
            // 批量获取书籍详情
            /** @var BookBookService $bookService */
            $bookService = \Yii::createObject(BookBookService::class);
            /** @var BookBookEntity[]|null $book_items */
            $book_items = ArrayHelper::index($bookService->getBookListByBookIds($book_ids), 'book_id');
            foreach ($data as &$history){
                $history = $history->toArray();
                $history['book_name'] = $book_items[$history['book_id']]['book_name'];
                $history['book_cover_imgs'] = $book_items[$history['book_id']]['book_cover_imgs'];
            }
        }

        return [
            'count' => $count,
            'list' => $data
        ];
    }

    /**
     * 根据查询出来的entity 获取这里面所有的book_id集合
     * @param $Entitys BookHistoryEntity[]
     * @return array
     */
    public function getBookIdByEntitys($Entitys){
        $book_ids = [];
        foreach ($Entitys as $history) {
            $book_ids[] = $history->book_id;
        }

        return $book_ids;
    }

    /**
     * 删除一条阅读记录
     * @param $params
     * @return array|bool
     */
    public function delHistory($params)
    {
        $query = new QueryParams();
        $query->where([
            'history_id'    =>  $params
        ]);

        $item = $this->getItem($query);
        if(empty($item)){
            return self::setAndReturn(ErrorCode::SYSTEM_ERROR);
        }

        return $this->del($query);
    }

    /**
     * 获取一条书籍阅读进度
     * @param $user_id
     * @param $book_id
     * @return \app\common\BaseAR|\app\common\BaseAR[]|array|bool|\yii\db\ActiveRecord[]
     */
    public function getReadHistory($user_id, $book_id)
    {
        $query = new QueryParams();
        $query->where([
            'user_id'   =>  $user_id,
            'book_id'   =>  $book_id,
        ]);

        return $this->getItem($query, true);
    }
}