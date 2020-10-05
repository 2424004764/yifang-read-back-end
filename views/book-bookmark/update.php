<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookBookmarkEntity */

$this->title = 'Update Book Bookmark Entity: ' . $model->book_bookmark_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Bookmark Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->book_bookmark_id, 'url' => ['view', 'id' => $model->book_bookmark_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-bookmark-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
