<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Comment Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-comment-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book Comment Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'comment_id',
            'book_id',
            'user_id',
            'comment_content:ntext',
            'parent_comment_id',
            //'comment_like_total',
            //'status',
            //'create_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
