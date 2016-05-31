<?php

use app\controllers\NotificationsController;
use app\models\Users;
use app\components\basic\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchNotifications */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Уведомления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать уведомление', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => function ($model, $key, $index, $grid){
            if(!$model->is_read) return ['class' => 'bg-info']; return [];
        },
        'columns' => [
            Yii::$app->user->can(NotificationsController::PERMISSION_INDEX_ALL) ? 'id' : ['visible' => false],
            Yii::$app->user->can(NotificationsController::PERMISSION_INDEX_ALL)
                ? [
                    'attribute' => 'user_id',
                    'filter' => Html::activeDropdownList($searchModel, 'user_id', Users::getListAll(), [
                        'prompt' => 'Все',
                        'class' => 'form-control'
                    ]),
                    'value' => function($model){ return $model->userName; }
                ]
                : ['visible' => false],
            'message:ntext',
            [
                'attribute' => 'is_read',
                'format' => 'html',
                'value' => function($model){ return $model->getReadIcon(); },
                'filter' => Html::activeDropdownList($searchModel, 'is_read', $searchModel->getReadStatuses(), [
                    'prompt' => 'Все',
                    'class' => 'form-control'
                ]),
            ],
            'create_at',
            ['class' => 'app\components\basic\ActionColumn'],
        ],
    ]); ?>

</div>
