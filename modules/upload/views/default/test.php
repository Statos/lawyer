<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\upload\widgets\AvatarWidget;

?>

<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'photo')->widget(AvatarWidget::className()); ?>

<?php ActiveForm::end(); ?>

<?php /*

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<p>
id=<?php echo $model->id; ?>
</p>

<p>
<?php var_dump($model->photo); ?>
<?php echo $model->photo; ?>
</p>


<link rel="stylesheet" href="/css/imgarea/imgareaselect-animated.css" type="text/css">
<link rel="stylesheet" href="/css/awesome-avatar.css" type="text/css">

<?php 

Yii::$app->view->registerJsFile('/js/jquery/jquery.imgareaselect.pack.js', [
	'depends' => [
		'yii\web\YiiAsset',
	],
]);

Yii::$app->view->registerJsFile('/js/awesome-avatar.js', [
	'depends' => [
		'yii\web\YiiAsset',
	],
]);

$jsCode = "
	bind_on_change_input_file('#id_image', {
		select_area_width: 400,
		select_area_height: 250,
		width: 100,
		height: 100
	});
	
	$('#avatar_modal').on('hide.bs.modal', function () {
		for (var i = 1; i <= 4; i++)
			$('.imgareaselect-border' + i).hide();
		$('.imgareaselect-outer').hide();
	});

	$('#avatar_modal').on('shown.bs.modal', function() {
		for (var i = 1; i <= 4; i++)
			$('.imgareaselect-border' + i).show();
		$('.imgareaselect-outer').show();
	});
";

Yii::$app->view->registerJs($jsCode, \yii\web\View::POS_READY);


?>


<div class="col-md-3 col-xs-4">
		<div class="profile-block page-profile">		
			<div class="panel profile-photo pull-right">
				<a onclick="$('#avatar_modal').modal('show');">
					<img width="160" height="160" src="<?php echo $model->getUrlAvatar(); ?>" alt>
				</a>
			</div>
		</div>
	</div>


<div class="modal fade" id="avatar_modal" tabindex="-1" role="dialog" aria-labelledby="avatar_modal_label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <?php $form = ActiveForm::begin([
				'action' => ['/upload/default/upload'],
				'options' => ['enctype' => 'multipart/form-data']
			]); ?>
			<input id="action" type="hidden" name="action" value="ava-image">
			<input id="action" type="hidden" name="model_class" value="User" >
			<input id="action" type="hidden" name="model_id" value="<?php echo $model->id; ?>">
			<div class="modal-header">
                <h4 class="modal-title text-center" id="avatar_modal_label">Загрузить аватар</h4>
            </div>

            <div class="modal-body">
                <label for="id_image">Image:</label><div class="awesome-avatar-widget">

                    <div style="display:none">
                        <input id="id_image-x1" type="hidden" name="image-x1">
                        <input id="id_image-y1" type="hidden" name="image-y1">
                        <input id="id_image-x2" type="hidden" name="image-x2">
                        <input id="id_image-y2" type="hidden" name="image-y2">
                        <input id="id_image-ratio" type="hidden" name="image-ratio">
                    </div>

                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <div id="id_image-preview" class="awesome-avatar-preview" style="width:100px;height:100px">
                                    <img width="100" height="100" src="<?php echo $model->getUrlAvatar(); ?>">
                                </div>
                            </td>
                            <td>
                                <div id="id_image-select-area" class="awesome-avatar-select-area" style="width:400px;height:250px">
                                    <img src="<?php echo $model->getUrlAvatar(); ?>">
                                </div>
                                <input type="file" class="awesome-avatar-input" id="id_image" name="files" accept="image/jpeg,image/png,image/gif">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <script>
                        
                    </script>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

*/ ?>