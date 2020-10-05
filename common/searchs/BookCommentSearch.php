<?php

namespace app\common\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\entity\BookCommentEntity;

/**
 * BookCommentSearch represents the model behind the search form of `app\common\entity\BookCommentEntity`.
 */
class BookCommentSearch extends BookCommentEntity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id', 'book_id', 'user_id', 'parent_comment_id', 'comment_like_total', 'status'], 'integer'],
            [['comment_content', 'create_on'], 'safe'],
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
        $query = BookCommentEntity::find();

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
            'comment_id' => $this->comment_id,
            'book_id' => $this->book_id,
            'user_id' => $this->user_id,
            'parent_comment_id' => $this->parent_comment_id,
            'comment_like_total' => $this->comment_like_total,
            'status' => $this->status,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'comment_content', $this->comment_content]);

        return $dataProvider;
    }
}
