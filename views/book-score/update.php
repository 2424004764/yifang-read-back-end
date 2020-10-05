<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookScoreEntity */

$this->title = 'Update Book Score Entity: ' . $model->score_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Score Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->score_id, 'url' => ['view', 'id' => $model->score_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-score-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
