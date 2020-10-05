<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookHistoryEntity */

$this->title = 'Update Book History Entity: ' . $model->history_id;
$this->params['breadcrumbs'][] = ['label' => 'Book History Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->history_id, 'url' => ['view', 'id' => $model->history_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-history-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
