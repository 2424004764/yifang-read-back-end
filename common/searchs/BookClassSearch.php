<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookClassEntity;

/**
 * BookClassSearch represents the model behind the search form of `app\common\entity\BookClassEntity`.
 */
class BookClassSearch extends BookClassEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_class_id', 'parent_id', 'order', 'status'], 'integer'],
            [['class_id_name', 'class_cover_img', 'create_on'], 'safe'],
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
        $query = BookClassEntity::find();

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
            'book_class_id' => $this->book_class_id,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'status' => $this->status,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'class_id_name', $this->class_id_name])
            ->andFilterWhere(['like', 'class_cover_img', $this->class_cover_img]);

        return $dataProvider;
    }
}
