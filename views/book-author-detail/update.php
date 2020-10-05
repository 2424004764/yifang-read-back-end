<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookAuthorDetailEntity */

$this->title = 'Update Book Author Detail Entity: ' . $model->book_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Author Detail Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->book_id, 'url' => ['view', 'id' => $model->book_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-author-detail-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
