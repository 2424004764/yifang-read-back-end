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
     * 根据书籍id获取书籍详情
     * @param $id
     * @return array|bool|\yii\db\ActiveRecord|null
     */
    public function getItemDetail($id)
    {
        try {
            $where = [
                'book_id'       =>  $id
            ];
            return $this->_bookBookRepository->getItemDetail($where, $this->Entity);
        } catch (\Exception $e) {
            return self::setAndReturn(ErrorCode::FAILURE, $e->getMessage());
        }
    }
}