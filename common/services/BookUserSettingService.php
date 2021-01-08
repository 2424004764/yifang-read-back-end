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
use app\common\utTrait\error\ErrorCode;
use app\common\utTrait\QueryParams;

class BookUserSettingService extends BaseService
{
    private BookUserSettingRepository $_bookUserSettingRepository;

    const READ_FONT_SIZE = 1; // 阅读时的字体大小 px
    const READ_BG_COLOR = 2; // 阅读页的背景颜色 十六进制
    const READ_FONT_COLOR = 3; // 阅读页字体颜色

    /**
     * @var array|string[] 配置的说明集合
     */
    public static array $SETTINGS = [
        self::READ_FONT_SIZE,
        self::READ_BG_COLOR,
    ];

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

        // 未定义的配置 不允许操作
        if(!in_array($params['name'], BookUserSettingService::$SETTINGS, true)){
            return self::setAndReturn(ErrorCode::SETTING_NAME_NO_EXIST);
        }

        if($item = $this->getItem($query, true)){
            // 有记录 则更新
            $this->Entity = $item;
            $this->Entity->value = $params['value'];
        }else{
            $this->Entity->setAttributes($params);
        }

        return $this->save();
    }

    /**
     * @param $params
     * @return array|bool
     */
    public function getSetting($params)
    {
        $query = new QueryParams();
        $query->where([
            'user_id'   =>  $params['user_id'],
        ]);

        // 过滤
        $settings = explode(",", $params['name']);
        foreach ($settings as $index => &$name) {
            // 未定义的配置名 不允许操作
            $name = intval($name);
            if (!in_array($name, BookUserSettingService::$SETTINGS, true)) {
                unset($settings[$index]);
            }
        }

        $result = []; // 结果
        if (empty($settings)) {
            return $result;
        }

        $query->andWhere([
            'name'      =>  $settings,
        ]);
        $query->select = 'name, value';
        $items = $this->getItem($query);

        if (empty($items)) {
            return $result;
        }

        /** @var BookUserSettingEntity $setting */
        foreach ($items as $setting) {
            $result[] = [
                'name'  =>  intval($setting->name),
                'value' =>  $setting->value,
            ];
        }

        return $result;
    }
}