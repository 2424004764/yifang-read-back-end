<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookCommentEntity */

$this->title = 'Update Book Comment Entity: ' . $model->comment_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Comment Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->comment_id, 'url' => ['view', 'id' => $model->comment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-comment-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
