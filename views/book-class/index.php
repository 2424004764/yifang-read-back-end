<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Class Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-class-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book Class Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'book_class_id',
            'parent_id',
            'class_id_name',
            'class_cover_img',
            'order',
            //'status',
            //'create_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
