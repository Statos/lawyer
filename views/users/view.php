<?php

use app\components\basic\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <div class="row">
        <div class="col-md-4"><?= Html::img($model->avatarUrl, ['class' => 'img-circle view-avatar']); ?></div>
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить пользователя?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'fio',
                    'username',
                    'statusName',
                    'email:email',
                    'phone',
                    'create_at',
                    'online_at',
                ],
            ]) ?>
        </div>
    </div>

</div>
