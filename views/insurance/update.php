<?php

use app\components\basic\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Insurance */

$this->title = 'Страховые случай: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Страховые случаи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="insurance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
