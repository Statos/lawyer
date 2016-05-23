<?php

use app\components\basic\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Insurance */

$this->title = 'Создание страхового случая';
$this->params['breadcrumbs'][] = ['label' => 'Страховые случаи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insurance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
