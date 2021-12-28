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
use app\common\entity\EnCollectionEntity;
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
        if (empty($count)) {
            return [0, []];
        }

        $list = $query->limit($ps['size'])
            ->offset(($ps['page'] - 1) * $ps['size'])
            ->orderBy('created_on desc')
            ->asArray()->all();

        if (!empty($params['user_id'])) {
            // 是否收藏
            $en_ids = array_column($list, 'en_id');
            $collection_list = EnCollectionEntity::find()->where([
                'en_id' => $en_ids,
                'user_id' => $params['user_id'],
            ])->asArray()->all();
            foreach ($list as &$en) {
                $en['is_collection'] = 0; // 默认未收藏
                $en['is_release'] = (int)$en['is_release'];
                foreach ($collection_list as $collection) {
                    if (($collection['en_id'] == $en['en_id']) && ($collection['user_id'] == $params['user_id'])) {
                        $en['is_collection'] = 1;
                    }
                }
            }
        }

        foreach ($list as &$en) {
            $en['is_release'] = (int)$en['is_release'];
        }

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

        !empty($params['content']) && $item->content = $params['content'];
        !empty($params['cover_img']) && $item->cover_img = $params['cover_img'];
        !empty($params['translate']) && $item->translate = $params['translate'];
        !empty($params['source']) && $item->source = $params['source'];
        !empty($params['release_date']) && $item->release_date = $params['release_date'];
        !empty($params['is_release']) && $item->is_release = $params['is_release'];

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

    public function detail($params)
    {
        $entity = EnEverydayEnglishEntity::find()->where(['en_id' => $params['en_id']])->asArray()->one();
        if (!empty($params['user_id'])) {
            // 是否收藏
            $isCollection = (new EnCollectionService())->isCollection($params);
            $entity['is_collection'] = (int)$isCollection;
        }

        return $entity;
    }

}