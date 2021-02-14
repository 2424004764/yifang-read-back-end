<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/5 0005
 * Time: 16:23
 */

namespace app\common\services;


use app\common\entity\BookChapterEntity;
use app\common\repository\BookChapterRepository;
use Yii;

class BookChapterService extends BaseService
{

    private BookChapterRepository $_bookChapterRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookChapterRepository = new BookChapterRepository;
        $this->Entity = new BookChapterEntity;
    }

    /**
     * 根据章节id获取章节id在书籍所属的章节列表中的索引位置
     * @param int $book_id
     * @param int $chapter_id
     * @return array|\yii\db\ActiveRecord|null
     * @throws \yii\db\Exception
     */
    public function getPercentageByChapter($book_id, $chapter_id)
    {
        $callSql = "call calcBookReadSchedule(:book_id, :chapter_id, @outChapterCount, @outChapterCurrent);";
        Yii::$app->db->createCommand($callSql, [
            ':book_id'      =>  $book_id,
            ':chapter_id'   =>  $chapter_id,
        ])->execute();

        $runSql = "select @outChapterCount chapter_count, @outChapterCurrent chapter_current;";
        return Yii::$app->db->createCommand($runSql)->queryOne();
    }
}