<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\searchs\BookUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-user-entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'user_nikename') ?>

    <?= $form->field($model, 'user_headimg') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'birthday_type') ?>

    <?php // echo $form->field($model, 'password_salt') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'bind_email') ?>

    <?php // echo $form->field($model, 'create_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
