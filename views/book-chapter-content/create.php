<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\entity\BookChapterContentEntity */

$this->title = 'Create Book Chapter Content Entity';
$this->params['breadcrumbs'][] = ['label' => 'Book Chapter Content Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-chapter-content-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
