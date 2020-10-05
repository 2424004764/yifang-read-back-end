<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookRelatedLabelEntity */

$this->title = 'Update Book Related Label Entity: ' . $model->related_label_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Related Label Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->related_label_id, 'url' => ['view', 'id' => $model->related_label_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-related-label-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
