<?php

use app\modules\upload\widgets\MultiuploadWidget;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Law */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="law-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form->errorSummary($model); ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group field-law-publicate_at required">
        <label class="control-label">Дата издания:</label>
        <?= DatePicker::widget([
            'model' => $model,
            'attribute' => 'publicate_at',
            'language' => 'ru',
            'options' => ['placeholder' => 'Введите дату издания ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]); ?>
    </div>

    <?php echo $form->field($model, 'attach')->widget(MultiuploadWidget::class, [ 'options' => [
        'ajax_options' => ['action' => 'comment-attachment']
    ]]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
