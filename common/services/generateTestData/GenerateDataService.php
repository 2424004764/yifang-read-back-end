<?php
/**
 * 用以处理生成测试数据的逻辑
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/10/24 0024
 * Time: 17:34
 */

namespace app\common\services\GenerateTestData;
use app\common\entity\BookAuthorDetailEntity;
use app\common\entity\BookChapterContentEntity;
use app\common\entity\BookChapterEntity;
use app\common\entity\BookDetailEntity;
use app\common\entity\BookScoreEntity;
use app\common\entity\BookUserEntity;
use app\common\repository\BaseRepository;
use app\common\repository\BookBookRepository;
use app\common\repository\BookClassRepository;
use app\common\services\BaseService;
use app\common\entity\BookBookEntity;
use app\common\test\generateTestData;
use app\common\train\error\ErrorInfo;
use yii\db\Exception;

class GenerateDataService extends BaseService
{

    /**
     * 外层控制器调用
     * 负责处理生成测试数据逻辑
     * 涉及到的表：book_book 书籍主表
    * book_author_detail 书籍作者
    * book_detail 书籍描述
    * book_score 书籍评分
     * @param int $generateNumber 需要生成到的次数
     */
    public function dealGenerateTestData($generateNumber = 1)
    {
        $error_count = 0;
        try {
            // 获取随机字符串
            $generateService = new generateTestData();
            $classRepository = new BookClassRepository();
            $baseRepository = new BaseRepository();

            // 获取所有分类
            $allClass = $classRepository->getAllClass();
            $classLength = count($allClass);
            for ($i = 0; $i < $generateNumber; $i++){
    //            $string = $generateService->getStrings();
    //            $l = strlen($string);
                //        1、首先构建书籍主表  这是一切的开始
                $bookBookEntry = new BookBookEntity();
                $bookBookEntry->book_name = $generateService->getStrings(5, 10);
                $bookBookEntry->book_cover_imgs = $generateService->getImages(3);
                $result = $baseRepository->add($bookBookEntry);
                if(!($result instanceof $bookBookEntry)){
                    throw new Exception(ErrorInfo::getErrMsg());
                }
                /** TODO 这个属性待定 **/
                $bookBookEntry->book_word_count = 1;
                $bookBookEntry->book_class_id = $allClass[mt_rand(0, ($classLength - 1))]->book_class_id;
                $bookBookEntry->book_unit_count = mt_rand(10, 100);
//                $id = $bookBookEntry->book_id;
                // 2、book_author_detail 书籍作者
                $BookAuthorDetailEntity = new BookAuthorDetailEntity();
                $BookAuthorDetailEntity->book_id = $bookBookEntry->book_id;
                $BookAuthorDetailEntity->book_author = $generateService->getStrings(2, 5);
                $BookAuthorDetailEntity->book_author_desc = $generateService->getStrings(20, 100);
                // 3、book_detail 书籍描述
                $BookDetailEntity = new BookDetailEntity();
                $BookDetailEntity->book_id = $bookBookEntry->book_id;
                $BookDetailEntity->book_desc = $generateService->getStrings(100, 500);
                // 4、book_score 书籍评分
                $BookScoreEntity = new BookScoreEntity();
                $BookScoreEntity->book_id = $bookBookEntry->book_id;
                $BookScoreEntity->user_id = mt_rand(100003, 101003);
                $BookScoreEntity->score = mt_rand(1, 10);
                $BookScoreEntity->comment = $generateService->getStrings(5, 100, true);
                $BookScoreEntity->up_count = mt_rand(0, 1000);
                // 使用事务
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $baseRepository
                        ->add($BookAuthorDetailEntity)
                        ->add($BookDetailEntity)
                        ->add($BookScoreEntity);
                    $transaction->commit();
                }catch (\Exception $exception){
                    $bookBookEntry->delete();
                    $transaction->rollBack();
                    return self::setAndReturn(ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
                }
            }
        }catch (\Exception $exception){
            ++$error_count;
            return self::setAndReturn(ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
        }
        return ['total' => $generateNumber, 'error_count'   =>  $error_count];
    }

    /**
     * 生成测试用户
     * @param int $generateNumber
     * @return bool|string[]
     */
    public function GenerateTestUser($generateNumber = 1)
    {
        $baseRepository = new BaseRepository();
        $generateService = new generateTestData();
        for ($i = 0; $i < $generateNumber; $i++){
            $BookUserEntity = new BookUserEntity();
            $BookUserEntity->user_nikename = $generateService->getStrings(3, 10);
            $BookUserEntity->user_headimg = json_decode($generateService->getImages(), true)[0];
            $BookUserEntity->status = mt_rand(0, 1);
            $BookUserEntity->birthday = $generateService->getRandomDate();
            $BookUserEntity->birthday_type = mt_rand(1, 2);
            $BookUserEntity->password_salt = $generateService->getRandomStrings();
            $BookUserEntity->password = md5('123456'.$BookUserEntity->password_salt);
            $BookUserEntity->bind_email = $generateService->getRandomEmail();
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $baseRepository->add($BookUserEntity);
                $transaction->commit();
            }catch (\Exception $exception){
                $transaction->rollBack();
                return self::setAndReturn(ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
            }
        }
        return ['msg'=>'success'];
    }


    /**
     * 生成章节基础信息
     * 会有失败的可能性
     * 如果失败 则将第一层for循环的$book_id 换为book_chapter表的最大book_id 再执行程序  如果再出错
     * 则执行相同步骤  直到book_id 处理完
     * @param int $generate_count 每本书有多少章节
     * @return bool|string[]
     */
    public function GenerateTestChapter($generate_count = 15)
    {
        $BookBookEntity = new BookBookEntity();
        $book_id_min = $BookBookEntity::find()->select('book_id')
            ->orderBy(['book_id' => SORT_ASC])
            ->limit(1)
            ->one()->book_id;
        $book_id_max = $BookBookEntity::find()->select('book_id')
            ->orderBy(['book_id' => SORT_DESC])
            ->limit(1)
            ->one()->book_id;
        $generateService = new generateTestData();
        $baseRepository = new BaseRepository();

        // 一本书籍有多个章节
        for ($book_id = $book_id_min; $book_id <= $book_id_max; $book_id++){
            for ($i = 0; $i < $generate_count; $i++){
                $BookChapterEntity = new BookChapterEntity();
                $BookChapterEntity->book_id = $book_id;
                $BookChapterEntity->chapter_name = $generateService->getStrings(3, 10);
                try {
                    $baseRepository->add($BookChapterEntity);
                } catch (\Exception $e) {
                    return self::setAndReturn(ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
                }
            }
        }

        return ['msg'=>'success'];
    }

    // 目前暂定一本书是固定15个章节左右  后续可以为特定的一本书添加章节
    // 一本书籍有多个章节 暂定为 0 ~ 205
    // 全量构建模式  参数无效
    public function GenerateTestChapterContent($generate_count = 1)
    {
        $generateService = new generateTestData();
        $baseRepository = new BaseRepository();
        // 每次从章节表中取出 100 条数据开始写入章节内容
        $each_total = 100;
        while ($chapterData = (new BookChapterEntity)::find()->select('chapter_id')
            ->limit(100)
            ->offset($each_total)
            ->where(['>', 'chapter_id', 6528])
            ->all()){
            $each_total += 100;
            foreach ($chapterData as $index => $chapterEntity){
                $BookChapterContentEntity = new BookChapterContentEntity();
                $BookChapterContentEntity->chapter_id = $chapterEntity->chapter_id;
                $BookChapterContentEntity->chapter_content = $generateService->getStrings(1000, 3000);
                try {
                    $baseRepository->add($BookChapterContentEntity);
                } catch (\Exception $e) {
                    return self::setAndReturn(ErrorInfo::getErrCode(), ErrorInfo::getErrMsg());
                }
            }
        }
    }
}