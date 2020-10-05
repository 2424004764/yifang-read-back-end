<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\common\searchs\BookUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book User Entities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-user-entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book User Entity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'user_nikename',
            'user_headimg',
            'status',
            'birthday',
            //'birthday_type',
            //'password_salt',
            //'password',
            //'bind_email:email',
            //'create_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
