<?php
/**
 * Created by PhpStorm.
 * User: yifang
 * Email：2424004764@qq.com
 * Date: 2020/11/3 0003
 * Time: 11:38
 */

namespace app\common\services;


use app\common\entity\BookAuthorDetailEntity;
use app\common\entity\EnEverydayEnglishEntity;
use app\common\repository\BookBookAuthDetailRepository;
use app\common\utTrait\error\ErrorCode;

class EnEverydayEnglishService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getListQuery($params)
    {
        $query = EnEverydayEnglishEntity::find()->where('1=1');
        if (!empty($params['content'])) {
            $query->andWhere(['like', 'content', $params['content']]);
        }
        if (!empty($params['translate'])) {
            $query->andWhere(['like', 'translate', $params['translate']]);
        }
        if (!empty($params['created_on'])) {
            $query->andWhere(['like', 'created_on', $params['created_on']]);
        }
        if (!empty($params['is_release'])) {
            $query->andWhere(['is_release' => $params['is_release']]);
        }

        return $query;
    }

    public function list($ps, $params)
    {
        $query = $this->getListQuery($params);
        $sql = $query->createCommand()->getRawSql();

        $count = $query->count();

        $list = $query->limit($ps['size'])
            ->offset(($ps['page'] - 1) * $ps['size'])
            ->orderBy('created_on desc')
            ->all();

        return [$count, $list];
    }

    public function del($en_id)
    {
        return EnEverydayEnglishEntity::deleteAll('en_id=:en_id', [':en_id' => $en_id]);
    }

    public function edit($params)
    {
        /** @var EnEverydayEnglishEntity $item */
        $item = EnEverydayEnglishEntity::find()->where(['en_id' => $params['en_id']])->one();
        if (empty($item)) {
            return self::setAndReturn(ErrorCode::PARAM_EMPTY);
        }

        $item->content = $params['content'];
        $item->cover_img = $params['cover_img'];
        $item->translate = $params['translate'];
        $item->source = $params['source'];
        $item->release_date = $params['release_date'];
        $item->is_release = $params['is_release'];

        return $item->save();
    }

    public function add($params)
    {
        /** @var EnEverydayEnglishEntity $item */
        $item = new EnEverydayEnglishEntity;

        $item->content = $params['content'];
        $item->cover_img = $params['cover_img'];
        $item->translate = $params['translate'];
        $item->source = $params['source'];
        $item->release_date = $params['release_date'];

        return $item->save();
    }

    public function detail($en_id)
    {
        return EnEverydayEnglishEntity::find()->where(['en_id' => $en_id])->one();
    }

}