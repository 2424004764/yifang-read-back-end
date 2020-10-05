<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookUserEntity;

/**
 * BookUserSearch represents the model behind the search form of `app\common\entity\BookUserEntity`.
 */
class BookUserSearch extends BookUserEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'birthday_type'], 'integer'],
            [['user_nikename', 'user_headimg', 'birthday', 'password_salt', 'password', 'bind_email', 'create_on'], 'safe'],
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
        $query = BookUserEntity::find();

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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'birthday' => $this->birthday,
            'birthday_type' => $this->birthday_type,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'user_nikename', $this->user_nikename])
            ->andFilterWhere(['like', 'user_headimg', $this->user_headimg])
            ->andFilterWhere(['like', 'password_salt', $this->password_salt])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'bind_email', $this->bind_email]);

        return $dataProvider;
    }
}
