<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookLabelEntity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-label-entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
