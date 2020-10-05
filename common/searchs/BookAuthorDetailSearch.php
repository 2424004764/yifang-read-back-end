<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookAuthorDetailEntity;

/**
 * BookAuthorDetailSearch represents the model behind the search form of `app\common\entity\BookAuthorDetailEntity`.
 */
class BookAuthorDetailSearch extends BookAuthorDetailEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id'], 'integer'],
            [['book_author', 'book_author_desc', 'create_on'], 'safe'],
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
        $query = BookAuthorDetailEntity::find();

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
            'book_id' => $this->book_id,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'book_author', $this->book_author])
            ->andFilterWhere(['like', 'book_author_desc', $this->book_author_desc]);

        return $dataProvider;
    }
}
