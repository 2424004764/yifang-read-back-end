<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookClassEntity */

$this->title = 'Update Book Class Entity: ' . $model->book_class_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Class Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->book_class_id, 'url' => ['view', 'id' => $model->book_class_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-class-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
