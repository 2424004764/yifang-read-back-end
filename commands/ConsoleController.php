<?php


namespace app\commands;

use yii\console\Controller;
use app\common\entity\EnEverydayEnglishEntity;
use yii\console\ExitCode;

class ConsoleController extends Controller
{
    // 每日清洗一条每日美句为发布状态
    public function actionClearEverydayEn()
    {
        // 当日是否有数据
        $crrent_date = date("Y-m-d");
        $current_day_data = EnEverydayEnglishEntity::find()->where([
            'like', 'release_date', $crrent_date
        ])->one();

        if (!empty($current_day_data)) {
            $current_day_data->is_release = 1;
            $current_day_data->release_date = date("Y-m-d H:i:s");
            $current_day_data->save();
        } else {
            // 邮箱提醒管理人员发布美句
        }

        return ExitCode::OK;
    }
}