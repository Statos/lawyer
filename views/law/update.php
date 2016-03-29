<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Law */

$this->title = 'Обновление закона: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Законы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="law-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
