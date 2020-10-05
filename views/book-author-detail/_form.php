<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookAuthorDetailEntity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-author-detail-entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_id')->textInput() ?>

    <?= $form->field($model, 'book_author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_author_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
