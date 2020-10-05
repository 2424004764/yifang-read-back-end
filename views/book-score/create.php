<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookScoreEntity */

$this->title = 'Create Book Score Entity';
$this->params['breadcrumbs'][] = ['label' => 'Book Score Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-score-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
