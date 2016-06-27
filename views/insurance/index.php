<?php

use app\components\basic\Html;
use kartik\date\DatePicker;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchInsurance */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страховые случаи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insurance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать страховой случай', ['create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a('Получить отчет', ['excel'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'userName',
            'name',
            'description:ntext',
            [
                'attribute' => 'create_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'start_create',
                    'attribute2' => 'end_create',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd'],
                ])
            ],
            [
                'attribute' => 'max_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'start_max',
                    'attribute2' => 'end_max',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd'],
                ])
            ],
            [
                'class' => 'app\components\basic\ActionColumn',
                'contentOptions' => ['style' => 'width:70px']
            ],
        ],
    ]); ?>

</div>
