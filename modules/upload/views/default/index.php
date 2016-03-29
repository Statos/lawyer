<?php

use app\modules\upload\widgets\UploadWidget;
use app\modules\upload\widgets\MultiuploadWidget;
use app\modules\comments\models\Attachments;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Загрузка';



?>

<div style="width:100%; height:500px; background: #FFF;">

    <?php $form = ActiveForm::begin([
        'method' => 'POST',
        'fieldConfig' => [
            'template' => '{input}',
        ]
    ]); ?>

    <?php echo $form->field($model, 'cid')->widget(UploadWidget::className(), ['options'=>[
        'ajax_options' => ['action'=>'news-image'],
    ]]); ?>

    <?php echo $form->field($model, 'id')->widget(MultiuploadWidget::className(), ['options'=>[
        'ajax_options' => ['action'=>'news-image'],
    ]]); ?>

    <?php ActiveForm::end(); ?>


</div>


