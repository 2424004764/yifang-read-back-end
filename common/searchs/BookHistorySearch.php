<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookHistoryEntity;

/**
 * BookHistorySearch represents the model behind the search form of `app\common\entity\BookHistoryEntity`.
 */
class BookHistorySearch extends BookHistoryEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['history_id', 'user_id', 'book_id', 'status'], 'integer'],
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
        $query = BookHistoryEntity::find();

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
            'history_id' => $this->history_id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'status' => $this->status,
            'create_on' => $this->create_on,
        ]);

        return $dataProvider;
    }
}
