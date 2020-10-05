<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookChapterContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Chapter Content Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-chapter-content-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book Chapter Content Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'chapter_content_id',
            'chapter_id',
            'book_id',
            'chapter_content:ntext',
            'create_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
