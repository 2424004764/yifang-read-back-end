<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookScheduleEntity;

/**
 * BookScheduleSearch represents the model behind the search form of `app\common\entity\BookScheduleEntity`.
 */
class BookScheduleSearch extends BookScheduleEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schedule_id', 'book_id', 'chapter_id'], 'integer'],
            [['schedule', 'create_on'], 'safe'],
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
        $query = BookScheduleEntity::find();

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
            'schedule_id' => $this->schedule_id,
            'book_id' => $this->book_id,
            'chapter_id' => $this->chapter_id,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'schedule', $this->schedule]);

        return $dataProvider;
    }
}
