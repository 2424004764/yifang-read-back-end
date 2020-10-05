<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookFavoritesEntity */

$this->title = 'Create Book Favorites Entity';
$this->params['breadcrumbs'][] = ['label' => 'Book Favorites Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-favorites-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
