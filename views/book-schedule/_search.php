<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\searchs\BookScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-schedule-entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'schedule_id') ?>

    <?= $form->field($model, 'book_id') ?>

    <?= $form->field($model, 'chapter_id') ?>

    <?= $form->field($model, 'schedule') ?>

    <?= $form->field($model, 'create_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
