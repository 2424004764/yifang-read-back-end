<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookAuthorDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Author Detail Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-author-detail-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book Author Detail Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'book_id',
            'book_author',
            'book_author_desc:ntext',
            'create_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
