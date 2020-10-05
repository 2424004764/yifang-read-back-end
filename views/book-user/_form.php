<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookUserEntity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-user-entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_nikename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_headimg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'birthday')->textInput() ?>

    <?= $form->field($model, 'birthday_type')->textInput() ?>

    <?= $form->field($model, 'password_salt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bind_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
