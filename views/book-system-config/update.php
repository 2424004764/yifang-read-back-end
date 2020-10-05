<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookSystemConfigEntity */

$this->title = 'Update Book System Config Entity: ' . $model->config_id;
$this->params['breadcrumbs'][] = ['label' => 'Book System Config Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->config_id, 'url' => ['view', 'id' => $model->config_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-system-config-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
