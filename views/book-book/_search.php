<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\searchs\BookBookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-book-entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'book_id') ?>

    <?= $form->field($model, 'book_name') ?>

    <?= $form->field($model, 'book_cover_imgs') ?>

    <?= $form->field($model, 'book_word_count') ?>

    <?= $form->field($model, 'book_favorites_count') ?>

    <?php // echo $form->field($model, 'book_click_count') ?>

    <?php // echo $form->field($model, 'book_watch_count') ?>

    <?php // echo $form->field($model, 'book_class_id') ?>

    <?php // echo $form->field($model, 'book_current_read_count') ?>

    <?php // echo $form->field($model, 'book_unit_count') ?>

    <?php // echo $form->field($model, 'book_status') ?>

    <?php // echo $form->field($model, 'create_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
