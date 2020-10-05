<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookFavoritesEntity */

$this->title = 'Update Book Favorites Entity: ' . $model->favorites_id;
$this->params['breadcrumbs'][] = ['label' => 'Book Favorites Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->favorites_id, 'url' => ['view', 'id' => $model->favorites_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-favorites-entity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
