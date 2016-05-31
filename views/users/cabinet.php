<?php

use app\components\basic\Html;
use app\modules\upload\widgets\AvatarWidget;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Обновление профиля';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="profile-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'avatar_id')->widget(AvatarWidget::className()); ?>
        </div>
        <div class="col-md-8">

            <?= $form->errorSummary($model); ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
