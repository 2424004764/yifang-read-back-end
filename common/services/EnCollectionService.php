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
use phpDocumentor\Reflection\Types\This;

class EnCollectionService extends BaseService
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

    public function del($collection_id)
    {
        return EnCollectionEntity::deleteAll('collection_id=:collection_id', [':collection_id' => $collection_id]);
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
        /** @var EnCollectionEntity $item */
        $item = new EnCollectionEntity;

        $item->en_id = $params['en_id'];
        $item->user_id = $params['user_id'];

        return $item->save();
    }

    public function detail($params)
    {
        return EnCollectionEntity::find()->where([
            'en_id' => $params['en_id'],
            'user_id' => $params['user_id']
        ])->one();
    }

    // 添加|取消收藏
    public function collection($params)
    {
        /** @var EnCollectionEntity $entity */
        $entity = EnCollectionEntity::find()->where([
            'en_id' => $params['en_id'],
            'user_id' => $params['user_id']
        ])->one();

        if (!empty($entity)) {
            return $this->del($entity->collection_id);
        }

        return $this->add($params);
    }

    public function isCollection($params)
    {
        return $this->detail($params);
    }

    public function getCollectionListQuery($params)
    {
        return EnCollectionEntity::find()->where(['user_id' => $params]);
    }

    public function collectionList($params, $ps)
    {
        $query = $this->getCollectionListQuery($params);
        $sql = $query->createCommand()->getRawSql();

        $count = $query->count();
        if (empty($count)) {
            return [];
        }

        $list = $query->limit($ps['size'])->offset(($ps['page'] - 1) * $ps['size'])
            ->orderBy('collection_id desc')->asArray()->all();
        $en_id = array_column($list, 'en_id');
        // 获取美句详情
        $en_list = EnEverydayEnglishEntity::find()->where(['en_id' => $en_id])->asArray()->all();
        foreach ($list as &$collection) {
            foreach ($en_list as $en) {
                if ($collection['en_id'] == $en['en_id']) {
                    $collection['content'] = $en['content'];
                    $collection['translate'] = $en['translate'];
                }
            }
        }

        return [
            'list' => $list,
            'page' => $ps['page'],
            'size' => $ps['size'],
            'count' => (int)$count,
        ];
    }

}