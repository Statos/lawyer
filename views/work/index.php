<?php

use app\controllers\WorkController;
use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\SearchWork */

$this->title = 'Рабочее пространство';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создание задачи', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            Yii::$app->user->can(WorkController::PERMISSION_UPDATE_ALL)
                ? [
                'attribute' => 'user_id',
                'filter' => Html::activeDropdownList($searchModel, 'user_id', User::getListAll(), [
                    'prompt' => 'Все',
                    'class' => 'form-control'
                ]),
                'value' => function($model){ return $model->userName; }
            ]
                : ['visible' => false],
            'name',
            'description:ntext',
            'insurance_id',
            'create_at',
            'max_at',
            'done_at',
            [
                'class' => 'app\components\basic\ActionColumn',
                'contentOptions' => ['style' => 'width:100px'],
                'template' => '{done} {view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
