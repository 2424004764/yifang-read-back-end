<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/12/17 0017
 * Time: 20:51
 */

namespace app\common\services;


use app\common\entity\BookBookshelfEntity;
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
        }catch (\Exception $exception){
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
            if($this->isExistBookshelf($queryParams)){ // 已加入书架  则取消加入

                return $this->del($queryParams);
            }
            // 开始加入书架
            $this->Entity->setAttributes($queryParams->where);

            return $this->save();
        }catch (\Exception $exception){
            return self::setAndReturn(ErrorCode::BOOKSHELF_SAVE_FAIL);
        }
    }

    /**
     * @param QueryParams $queryParams
     * @return BookBookshelfEntity[]
     */
    public function getBookshelfList(QueryParams $queryParams)
    {
        /** @var BookBookshelfEntity[] $raw_data */
        $queryParams->select = 'book_id';
        $raw_data = $this->getItem($queryParams);

        /** @var BookBookService $bookService */
        $bookService = \Yii::createObject(BookBookService::class);
        foreach ($raw_data as &$book){
            $queryParams->select = 'book_name, book_cover_imgs';
            $queryParams->where = [
                'book_id'   =>  $book->book_id
            ];
            $book = $book->toArray();
            $book['detail'] = $bookService->getItem($queryParams);
        }

        return $raw_data;
    }
}