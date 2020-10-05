<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\searchs\BookSystemConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-system-config-entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'config_id') ?>

    <?= $form->field($model, 'config_name') ?>

    <?= $form->field($model, 'config_value') ?>

    <?= $form->field($model, 'config_desc') ?>

    <?= $form->field($model, 'create_on') ?>

    <?php // echo $form->field($model, 'update_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
