<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookChapterEntity */

$this->title = 'Update Book Chapter Entity: ' . $model->chapter_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Chapter Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->chapter_id, 'url' => ['view', 'id' => $model->chapter_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-chapter-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
