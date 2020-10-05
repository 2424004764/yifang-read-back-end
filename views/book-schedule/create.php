<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookScheduleEntity */

$this->title = 'Create Book Schedule Entity';
$this->params['breadcrumbs'][] = ['label' => 'Book Schedule Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-schedule-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
