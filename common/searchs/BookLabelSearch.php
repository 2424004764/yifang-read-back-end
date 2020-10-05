<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookLabelEntity;

/**
 * BookLabelSearch represents the model behind the search form of `app\common\entity\BookLabelEntity`.
 */
class BookLabelSearch extends BookLabelEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label_id'], 'integer'],
            [['label_name', 'create_on'], 'safe'],
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
        $query = BookLabelEntity::find();

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
            'label_id' => $this->label_id,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'label_name', $this->label_name]);

        return $dataProvider;
    }
}
