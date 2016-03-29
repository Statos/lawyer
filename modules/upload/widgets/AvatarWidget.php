<?php

namespace app\modules\upload\widgets;

use app\modules\upload\models\Attachments;
use Yii;


class AvatarWidget extends UploadWidget
{
    public $success_callback = 'false';

    public function init()
    {
		if (!isset($this->options['form_id']))
			$this->options['form_id'] = 'ava-widget-form-' . $this->attribute;
		if (!isset($this->options['action']))
			$this->options['action'] = 'ava-image';

        parent::init();
    }
	
	public function run()
    {
		if(is_integer($this->model->{$this->attribute}))
			$attach = Attachments::getAttributeAttachment($this->model->{$this->attribute});
		else{
			$attach = new Attachments;
			if($this->model->{$this->attribute})
				$attachment = [
					'url' => $this->model->{$this->attribute},
				];
			else
				$attachment = [
					'url' => '/images/avatar.png',
				];
				
			$attachment = json_encode($attachment);
			$attach->attachment = json_decode($attachment);
		}
		
		return $this->render('avatar', [
            'self' => $this,
            'attachment' => $attach
        ]);
    }

    protected function registerLocalJs()
    {
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
			bind_on_change_input_file('#" . $this->attribute . "', {
				select_area_width: 400,
				select_area_height: 300,
			});
			
			$('#" . $this->attribute . "_modal').on('hide.bs.modal', function () {
				for (var i = 1; i <= 4; i++)
					$('.imgareaselect-border' + i).hide();
				$('.imgareaselect-outer').hide();
			});

			$('#" . $this->attribute . "_modal').on('shown.bs.modal', function() {
				for (var i = 1; i <= 4; i++)
					$('.imgareaselect-border' + i).show();
				$('.imgareaselect-outer').show();
			});
			
		";

		Yii::$app->view->registerJs($jsCode, \yii\web\View::POS_READY);
		
		$jsCode = "
			$('#modal-button-send').on('click', function(){
				var modal_box = $('#" . $this->attribute . "_modal');
				
				var fd = new FormData();
				
				$(modal_box).find('input[type=\"hidden\"]').each(function(){
					var name=$(this).attr('name'); 
					fd.append(name, $(this).val()); 
				});
				fd.append('files', $('#" . $this->attribute . "').prop('files')[0]);
				
				var url = '/upload/default/upload';
				var success_callback = " . $this->success_callback . ";
				
				$.ajax({
					url: url,
					data: fd,
					processData: false,
					contentType: false,
					dataType: 'json',
					type: 'POST',
					success: function (data) {
						var img = data[0];
						if(img.error){
							alert(img.error);
							return;
						}
						$('#".$this->options['id']."').val(JSON.stringify(data[0].id));
						if(img.attachment && img.attachment.thumbUrl)
							$('#".$this->options['img_id']."').attr('src', img.attachment.thumbUrl);
						else
							$('#".$this->options['img_id']."').attr('src', img.attachment.url);

						$('#".$this->options['img_id']."').show();
						$('#" . $this->attribute . "_modal').modal('hide');

						if (success_callback)
						    success_callback(img);
					},
					fail: function (e, data) {
						alert('Что то пошло не так...');
						console.log(data.jqXHR.responseText);
					}
				});
				return false;
			});";
			
		Yii::$app->view->registerJs($jsCode, \yii\web\View::POS_READY);
    }

}
