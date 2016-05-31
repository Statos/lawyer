<?php

use app\components\basic\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'label' => 'Аватар',
                'format' => 'html',
                'value' => function($model){ return Html::img($model->avatarUrl, ['class' => 'img-circle index-avatar']);  },
            ],
            'status',
            'username',
            'email:email',
            'create_at',
            'online_at',

            ['class' => 'app\components\basic\ActionColumn'],
        ],
    ]); ?>

</div>
