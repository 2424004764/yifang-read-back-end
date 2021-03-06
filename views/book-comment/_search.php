<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\searchs\BookCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-comment-entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'comment_id') ?>

    <?= $form->field($model, 'book_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'comment_content') ?>

    <?= $form->field($model, 'parent_comment_id') ?>

    <?php // echo $form->field($model, 'comment_like_total') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
