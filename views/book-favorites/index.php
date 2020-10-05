<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookFavoritesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Favorites Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-favorites-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book Favorites Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'favorites_id',
            'book_id',
            'user_id',
            'create_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
