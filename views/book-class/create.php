<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookClassEntity */

$this->title = 'Create Book Class Entity';
$this->params['breadcrumbs'][] = ['label' => 'Book Class Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-class-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
