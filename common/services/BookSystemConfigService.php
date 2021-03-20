<?php
/**
 * 系统设置 参数
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2021/3/10 0010
 * Time: 12:55
 */

namespace app\common\services;


use app\common\entity\BookSystemConfigEntity;
use app\common\repository\BookSystemConfigRepository;
use app\common\utTrait\QueryParams;

class BookSystemConfigService extends BaseService
{

    // 所有的配置

    // json格式[ ['url:' => '', 'book_id' => ''] ]
    const SWIPER_IMAGE = 'swiper_image'; // 小程序首页轮播图

    private BookSystemConfigRepository $_bookSystemConfigRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_bookSystemConfigRepository = new BookSystemConfigRepository;
        $this->Entity = new BookSystemConfigEntity;
    }

    /**
     * 获取小程序首页轮播图
     * @return \app\common\BaseAR|\app\common\BaseAR[]|array|bool|\yii\db\ActiveRecord[]
     */
    public function getSwiperImages()
    {
        $query = new QueryParams();
        $query->select('config_value')
            ->where([
            'config_name'   =>  self::SWIPER_IMAGE
        ]);

        return $this->getItem($query, true);
    }

}