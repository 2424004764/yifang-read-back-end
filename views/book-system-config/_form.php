<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookSystemConfigEntity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-system-config-entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'config_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'config_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'config_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_on')->textInput() ?>

    <?= $form->field($model, 'update_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
