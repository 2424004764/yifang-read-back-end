<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/3 0003
 * Time: 11:38
 */

namespace app\common\services;


use app\common\entity\BookBookEntity;
use app\common\repository\BookBookRepository;
use app\common\utTrait\error\ErrorCode;

class BookBookService extends BaseService
{
    private BookBookRepository $_bookBookRepository; // 服务对应的操作数据库的类

    public function __construct()
    {
        parent::__construct();
        $this->_bookBookRepository = new BookBookRepository;
        $this->Entity = new BookBookEntity;
    }

    /**
     * 根据书籍id获取书籍详情  可再次获取关联数据  只需要再对应的Entity中定义关联关系即可
     * @param $id
     * @return array|bool|BookBookEntity|null
     */
    public function getItemDetail($id)
    {
        try {
            $where = [
                'book_id'       =>  $id
            ];
            $book =  $this->_bookBookRepository->getItemDetail($where, $this->Entity);

            $with_data = [
                'book_detail'       =>  $book->detail, // 关联书籍详情
                'author_detail'     =>  $book->authorDetail, // 关联作者i详情
                'class_detail'      =>  $book->classDetail, // 关联分类
            ];

            return array_merge($book->toArray(), $with_data);
        } catch (\Exception $e) {
            return self::setAndReturn(ErrorCode::SYSTEM_ERROR, $e->getMessage());
        }
    }
}