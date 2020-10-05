<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookBookmarkEntity;

/**
 * BookBookmarkSearch represents the model behind the search form of `app\common\entity\BookBookmarkEntity`.
 */
class BookBookmarkSearch extends BookBookmarkEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_bookmark_id', 'book_id', 'chapter_id'], 'integer'],
            [['read_schedule', 'create_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BookBookmarkEntity::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'book_bookmark_id' => $this->book_bookmark_id,
            'book_id' => $this->book_id,
            'chapter_id' => $this->chapter_id,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'read_schedule', $this->read_schedule]);

        return $dataProvider;
    }
}
