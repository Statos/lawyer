<?php
use yii\helpers\Html;
?>

<div id="comments">

    <?php if ($options['ctype']): //if (Yii::$app->user->can('createComments')) : ?>
        <?php echo $this->render('_head', ['ctype' => $countCtype]) ?>
    <?php endif; ?>

    <?php if ($options['visible']): //if (Yii::$app->user->can('createComments')) : ?>
        <?= $this->render('_form', ['model' => $model, 'options'=>$options]); ?>
    <?php endif; ?>

    <?php
        echo $this->render('_index_item', ['models' => $models, 'options'=>[
            'answers' => $options['answers']
        ]]);
    ?>
    <!--/ #comments-list -->


</div>

<?php
//$js = "
//    $('.answer-activate').click(function(){
//        var pid = $(this).parents('.comment').attr('comment_id');
//        var div_form = $('#default-comment-form').clone();
//        var pid_input = '<input type=\"hidden\" name=\"". Html::getInputName($model, 'pid') .  "\" value=\"' + pid + '\">';
//
//        $('.answer-activate').show();
//        $('.other-comment-form').remove();
//        div_form.addClass('other-comment-form').find('form#{$model->formName()}').append(pid_input);
//        $(this).closest('.comment').children('.comment-info').after(div_form);
//        $(this).hide();
//        loadAjaxSubmit();
//    });
//";
$js = "
    $('.answer-activate.no-main').click(function(){
        var pid = $(this).parents('.comment').attr('comment_id');
        var div_form = $('#default-comment-form');

        if( $('#". Html::getInputId($model, 'pid') .  "').length == 0  ){
            var pid_input = '<input type=\"hidden\" id=\"". Html::getInputId($model, 'pid') .  "\" name=\"". Html::getInputName($model, 'pid') .  "\" value=\"' + pid + '\">';
            div_form.find('form#{$model->formName()}').append(pid_input);
        } else {
            $('#". Html::getInputId($model, 'pid') .  "').val(pid);
        }

        $('.answer-activate').show();
        $(div_form).show(400);
        $(this).closest('.comment').children('.comment-info').after(div_form);
        $(this).hide();
        //loadAjaxSubmit();
    });
";
$this->registerJs($js);
?>