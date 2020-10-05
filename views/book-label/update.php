<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookLabelEntity */

$this->title = 'Update Book Label Entity: ' . $model->label_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Label Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label_id, 'url' => ['view', 'id' => $model->label_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-label-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
