<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookBookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Book Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-book-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book Book Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'book_id',
            'book_name',
            'book_cover_imgs',
            'book_word_count',
            'book_favorites_count',
            //'book_click_count',
            //'book_watch_count',
            //'book_class_id',
            //'book_current_read_count',
            //'book_unit_count',
            //'book_status',
            //'create_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
