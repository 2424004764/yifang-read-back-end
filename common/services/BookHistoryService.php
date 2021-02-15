<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/2/14 0014
 * Time: 14:42
 */

namespace app\common\services;


use app\common\entity\BookHistoryEntity;
use app\common\repository\BookHistoryRepository;
use app\common\utTrait\QueryParams;
use yii\base\InvalidConfigException;
use yii\db\Exception;

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

        return $this->save();
    }

    /**
     * 获取阅读历史  分页
     * @param $ps array 分页参数
     * @param $params array 查询参数
     */
    public function getHistoryList($ps, $params)
    {
        $query = new QueryParams();
        $query->where([
            'user_id'   =>  $params['user_id']
        ]);
        $query->loadPageSize($ps)
            ->orderBy([
                'history_id'    =>  SORT_DESC
            ]);

        $count = $this->count($query);
        $data = $this->getItem($query);

        return [
            'count' =>  $count,
            'list'  =>  $data
        ];
    }
}