<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookDetailEntity */

$this->title = 'Update Book Detail Entity: ' . $model->book_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Detail Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->book_id, 'url' => ['view', 'id' => $model->book_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-detail-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
