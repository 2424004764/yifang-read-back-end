<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookChapterContentEntity */

$this->title = 'Update Book Chapter Content Entity: ' . $model->chapter_content_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Chapter Content Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->chapter_content_id, 'url' => ['view', 'id' => $model->chapter_content_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-chapter-content-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
