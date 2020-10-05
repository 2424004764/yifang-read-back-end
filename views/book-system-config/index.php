<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookSystemConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book System Config Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-system-config-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book System Config Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'config_id',
            'config_name',
            'config_value:ntext',
            'config_desc',
            'create_on',
            //'update_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
