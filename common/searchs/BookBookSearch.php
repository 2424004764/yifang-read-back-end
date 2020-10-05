<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookBookEntity;

/**
 * BookBookSearch represents the model behind the search form of `app\common\entity\BookBookEntity`.
 */
class BookBookSearch extends BookBookEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'book_word_count', 'book_favorites_count', 'book_click_count', 'book_watch_count', 'book_class_id', 'book_current_read_count', 'book_unit_count', 'book_status'], 'integer'],
            [['book_name', 'book_cover_imgs', 'create_on'], 'safe'],
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
        $query = BookBookEntity::find();

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
            'book_word_count' => $this->book_word_count,
            'book_favorites_count' => $this->book_favorites_count,
            'book_click_count' => $this->book_click_count,
            'book_watch_count' => $this->book_watch_count,
            'book_class_id' => $this->book_class_id,
            'book_current_read_count' => $this->book_current_read_count,
            'book_unit_count' => $this->book_unit_count,
            'book_status' => $this->book_status,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'book_name', $this->book_name])
            ->andFilterWhere(['like', 'book_cover_imgs', $this->book_cover_imgs]);

        return $dataProvider;
    }
}
