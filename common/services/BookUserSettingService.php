<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/1/2 0002
 * Time: 20:11
 */

namespace app\common\services;


use app\common\entity\BookUserSettingEntity;
use app\common\repository\BookUserSettingRepository;
use app\common\utTrait\QueryParams;

class BookUserSettingService extends BaseService
{
    private BookUserSettingRepository $_bookUserSettingRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_bookUserSettingRepository = new BookUserSettingRepository;
        $this->Entity = new BookUserSettingEntity;
    }

    /**
     * 添加或修改设置
     * @param $params
     * @return bool
     */
    public function addSetting($params)
    {
        $query = new QueryParams();
        $query->where([
            'user_id'   =>  $params['user_id'],
            'name'      =>  $params['name'],
        ]);

        if($item = $this->getItem($query, true)){
            // 有记录 则更新
            $this->Entity = $item;
            $this->Entity->value = $params['value'];
        }else{
            $this->Entity->setAttributes($params);
        }

        return $this->save();
    }
}