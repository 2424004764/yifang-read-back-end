<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookBookEntity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-book-entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_cover_imgs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_word_count')->textInput() ?>

    <?= $form->field($model, 'book_favorites_count')->textInput() ?>

    <?= $form->field($model, 'book_click_count')->textInput() ?>

    <?= $form->field($model, 'book_watch_count')->textInput() ?>

    <?= $form->field($model, 'book_class_id')->textInput() ?>

    <?= $form->field($model, 'book_current_read_count')->textInput() ?>

    <?= $form->field($model, 'book_unit_count')->textInput() ?>

    <?= $form->field($model, 'book_status')->textInput() ?>

    <?= $form->field($model, 'create_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
