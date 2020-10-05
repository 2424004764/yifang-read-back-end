<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookScheduleEntity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-schedule-entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_id')->textInput() ?>

    <?= $form->field($model, 'chapter_id')->textInput() ?>

    <?= $form->field($model, 'schedule')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
