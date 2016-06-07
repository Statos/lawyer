<?php

use app\modules\upload\widgets\MultiuploadWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$js = "
    function loadAjaxSubmit(){
        $('form#{$model->formName()}').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $('#" . Html::getInputId($model, 'txt') . "').trigger('blur');
            $('#" . Html::getInputId($model, 'ctype') . "').trigger('blur');


            $.ajax({
                url: '".Url::to(['/comments/default/create'])."',
                type: 'POST',
                data: form.serializeArray(),
                dataType: 'json',
                success: function (data) {
                    if(! data.message ){
                        alert('Ошибка. обратитесь к администратору');
                        return;
                    }
                    if( data.message == 'success' ){
                        $(form).find('#comments-attachment').val('');
                        $(form).find('#comments-txt').val('');
                        $(form).find('#comments-attachment-img').html('');
                        var div_form = $(form).parents('#default-comment-form');
                        $(div_form).hide(400);
                        if($(div_form).next().hasClass('c-responce'))
                            $(div_form).next().html('<div class=\"answers\">' + data.html + '</div>');
                        else
                            $(div_form).after(data.html);

                        //location.reload();
                    }
                }
            });

            return false;
        });
    }
    loadAjaxSubmit();
";
$this->registerJs($js);
$js = "
    $('.answer-activate.main').click(function(){
        var div_form = $('#default-comment-form');

        if( $('#". Html::getInputId($model, 'pid') .  "').length != 0  ){
            $('#". Html::getInputId($model, 'pid') .  "').remove();
        }
        $('.answer-activate').show();

        $(this).after(div_form);
        $(div_form).show(400);
        $(this).hide();
    });
";
$this->registerJs($js);
?>


<span class="answer-activate main btn" style="display: none; clear: both; float: none; margin-bottom: 10px">Ответить</span>
<div id="default-comment-form" class="comment-form">
    <div class="c-avatar" style="background-image: url(<?php //echo Yii::$app->user->identity->photo ;?>)"></div>
    <div class="c-leave">
        <div id="add-status" class="add-status"></div>
        <?php
            $form = ActiveForm::begin([
                'id'=> $model->formName(),
                'method' => 'POST',
                'action' => Url::to(['/comments/default/create']),
                'options' => ['class'=>'add-comment'],
                'fieldConfig' => [
                    'template' => '{input}{error}',
                ],
                'enableClientValidation' => true,
                'validateOnBlur' => true,
                'validateOnSubmit' => false,
            ]);
        ?>
            <?php echo $form->field($model, 'txt')->textarea([
                    'class'=>"comment-leave",
                    'placeholder'=>"Оставить комментарий"
                ]); ?>
            <?php echo $form->field($model, 'model_class')->hiddenInput(); ?>
            <?php echo $form->field($model, 'model_id')->hiddenInput(); ?>

            <?php if($options['ctype']) echo $form->field($model, 'ctype')->dropDownList(\app\modules\comments\models\Comments::getCtypes(), [

                    'data-placeholder'=>"Тип отзыва",
                    'class'=>"comment-type chosen-select-no-single",
                    'prompt'=>'Выберите тип отзыва'
                ]);?>

            <?php echo Html::submitButton('Отправить', [
                'id' => 'send-button',
                'class' => 'btn btn-primary',
            ]) ; ?>


            <div style="float:none;clear:both;">
                <?php echo $form->field($model, 'attachment')->widget(MultiuploadWidget::className(), ['options'=>[
                    'width_img' => '100%',
                    'ajax_options' => ['action'=>'comment-attachment'],
                    'file_button' => [
                        'button_class' => 'btn btn-info'
                    ],
                    'progress_bar' => [
                        'style'=>'display:none'
                    ]
                ]]); ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div style="clear:both;"></div>
</div>