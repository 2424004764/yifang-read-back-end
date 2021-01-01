<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/12/30 0030
 * Time: 12:59
 */

namespace app\common\services;


use app\common\entity\BookScheduleEntity;
use app\common\repository\BookScheduleRepository;
use app\common\utTrait\QueryParams;

class BookScheduleService extends BaseService
{

    private BookScheduleRepository $_bookScheduleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_bookScheduleRepository = new BookScheduleRepository;
        $this->Entity = new BookScheduleEntity;
    }

    /**
     * 保存|更新 阅读进度
     * @param $params array
     * @return bool
     */
    public function addSchedule($params)
    {
        try{
            // 无则加 有则该
            $query = new QueryParams();
            $query->where([
                'user_id'   =>  $params['user_id'],
                'book_id'   =>  $params['book_id'],
            ]);

            if($bookScheduleItem = $this->getItem($query, true)){
                $this->Entity = $bookScheduleItem;
                // 已存在进度 需要更改
                $this->Entity->chapter_id = $params['chapter_id'];
                // 不是首次保存 才需要修改进度
                empty($params['is_first']) && $this->Entity->schedule = $params['schedule'];
            }else{
//            需要新增进度
                $this->Entity->setAttributes($params);
            }

            return $this->save();
        }catch (\Exception $exception){
            return self::setAndReturn($exception->getCode(), $exception->getMessage());
        }

    }

}