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
        return $this->_bookBookshelfRepository->isExist($queryParams, $this->Entity);
    }

    /**
     * 加入书架
     * @param QueryParams $queryParams
     * @return bool
     * @throws \Exception
     */
    public function joinBookShelf($queryParams)
    {
        if($this->isExistBookshelf($queryParams)){
            return self::setAndReturn(ErrorCode::BOOKSHELF_IS_EXIST);
        }
        // 开始加入书架
        $bookShelfEntity = new BookBookshelfEntity();
        $bookShelfEntity->setAttributes($queryParams->where);

        try {
            return $this->_bookBookshelfRepository->save($bookShelfEntity);
        }catch (\Exception $exception){
            return self::setAndReturn(ErrorCode::BOOKSHELF_SAVE_FAIL);
        }
    }
}