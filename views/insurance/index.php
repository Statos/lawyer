<?php

use app\components\basic\Html;
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
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'userName',
            'name',
            'description:ntext',
            'create_at',

            [
                'class' => 'app\components\basic\ActionColumn',
                'contentOptions' => ['style' => 'width:70px']
            ],
        ],
    ]); ?>

</div>
