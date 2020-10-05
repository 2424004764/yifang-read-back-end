<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookUserEntity */

$this->title = 'Update Book User Entity: ' . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Book User Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-user-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
