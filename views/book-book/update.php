<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookBookEntity */

$this->title = 'Update Book Book Entity: ' . $model->book_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Book Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->book_id, 'url' => ['view', 'id' => $model->book_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-book-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
