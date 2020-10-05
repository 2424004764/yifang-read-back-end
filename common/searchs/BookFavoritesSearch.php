<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookFavoritesEntity;

/**
 * BookFavoritesSearch represents the model behind the search form of `app\common\entity\BookFavoritesEntity`.
 */
class BookFavoritesSearch extends BookFavoritesEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['favorites_id', 'book_id', 'user_id'], 'integer'],
            [['create_on'], 'safe'],
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
        $query = BookFavoritesEntity::find();

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
            'favorites_id' => $this->favorites_id,
            'book_id' => $this->book_id,
            'user_id' => $this->user_id,
            'create_on' => $this->create_on,
        ]);

        return $dataProvider;
    }
}
