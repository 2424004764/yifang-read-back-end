<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookScheduleEntity */

$this->title = 'Update Book Schedule Entity: ' . $model->schedule_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Schedule Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->schedule_id, 'url' => ['view', 'id' => $model->schedule_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-schedule-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
