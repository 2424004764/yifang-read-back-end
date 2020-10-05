<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookBookEntity */

$this->title = $model->book_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Book Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-book-entity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->book_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->book_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'book_id',
            'book_name',
            'book_cover_imgs',
            'book_word_count',
            'book_favorites_count',
            'book_click_count',
            'book_watch_count',
            'book_class_id',
            'book_current_read_count',
            'book_unit_count',
            'book_status',
            'create_on',
        ],
    ]) ?>

</div>
