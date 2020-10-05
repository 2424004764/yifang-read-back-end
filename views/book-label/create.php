<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookLabelEntity */

$this->title = 'Create Book Label Entity';
$this->params['breadcrumbs'][] = ['label' => 'Book Label Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-label-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
