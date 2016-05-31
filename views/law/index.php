<?php

use app\components\basic\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Законы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="law-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить закон', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'number:ntext',
            'name:ntext',
            [
                'attribute' => 'description',
                'value' => 'smallDescription'
            ],
            'publicate_at',
            'create_at',

            [
                'class' => 'app\components\basic\ActionColumn',
                'contentOptions' => ['style' => 'width:70px']
            ],
        ],
    ]); ?>

</div>
