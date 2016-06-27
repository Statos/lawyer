<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 *  echo $form->field($model, 'cid')->widget(UploadWidget::className());
 *
 *  echo $form->field($model, 'cid')->widget(UploadWidget::className(), [ 'options' => [
 *      'id'        - (string) id input hidden field
 *      'name'      - (string) name input hidden field
 *      'file_button'   - (array) if isset use button [
 *          'button_text'   - (string) if use button, use class
 *          'button_class'  - (string) if use button, use class
 *      ]
 *      'progress_bar'  - (array) htmlOptions
 *
 *      'file_id'       - (string) id file input
 *
 *
 *      'width_id'  - (string) width img
 *
 *      'url_upload'- (string) url for ajax function //TODO YII2
 *      'ajax_options'   - (array) POST parametrs, which send on server by ajax
 *
 *      'div_class' - (string) class block of images
 *      ]
 *  ]);
 */

namespace app\modules\upload\widgets;

use app\modules\upload\models\Attachments;
use Yii;
use yii\base\Widget;
use yii\base\Model;
use yii\base\InvalidConfigException;



class MultiuploadWidget extends UploadWidget
{
    const DIV_CLASS = 'upload_class';

    public function init()
    {
        if(!isset($this->options['div_class']))
            $this->options['div_class'] = self::DIV_CLASS;
        if(!isset($this->options['delete_url']))
            $this->options['delete_url'] = \yii\helpers\Url::to(['/upload/default/delete']);
        if(!isset($this->options['progress_bar']))
            $this->options['progress_bar'] = [];
        if(!isset($this->options['progress_bar']['id']))
            $this->options['progress_bar']['id'] = 'progress';
        if(!isset($this->options['progress_bar']['class']))
            $this->options['progress_bar']['class'] = 'progress';
        if(!isset($this->options['progress_bar']['style']))
            $this->options['progress_bar']['style'] = "width: 300px;float: left;margin: 6px 10px;";
        parent::init();
        return;
    }

    public function run()
    {
		if($this->model->{$this->attribute}){
			$attachment = Attachments::getAttributeAttachments($this->model->{$this->attribute});
		} else{
			$attachment = Attachments::getModelAttachment($this->model);
		}
        return $this->render('multiupload', [
            'self' => $this,
            'options' => $this->options,
            'attachment' => $attachment
        ]);
    }

    protected function registerLocalJs()
    {
        $formData = $this->loadFormData();
        $jsCode = "
            $('#".$this->options['file_id']."').fileupload({
                url: '" . $this->options['url_upload'] . "',
                dataType: 'json',
                " . $formData . "
                maxNumberOfFiles: 1,
                autoUpload: true,
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#" . $this->options['progress_bar']['id'] . " .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                },
                send: function (e, data) {
                    $('#" . $this->options['progress_bar']['id'] . " .progress-bar').css('width','0%');
                },
                done: function (e, data) {
                    var file = data.result[0].attachment;
                    if(data.result[0].error){
                        alert(data.result[0].error);
                        return;
                    }

                    var input= $('#".$this->options['id']."');
                    var file_ids = input.val().split(',');
                    if(file_ids[0] == '')
                        file_ids.splice(0,1);
                    file_ids.push(JSON.stringify(data.result[0].id));
                    input.val(file_ids.join(','));

                    var delete_button = '<div class=\"delete-button\" onclick=\"remove_attachment(' + data.result[0].id + ');\">&times</div>';
                    if ( data.result[0].type == '" . Attachments::TYPE_IMAGES . "'){
                        var img = data.result[0].attachment;
                        var img_src = img.titleUrl ? img.titleUrl : img.url;
                        var new_img = '<img src=\"' + img_src + '\" width=\"" . $this->options['width_img'] . "\">';
                        var new_block = '<div id=\"upload-img-' + data.result[0].id + '\" class=\"upload-img\" style=\"display:none\">' + delete_button + new_img + '</div>';
                    } else if ( data.result[0].type == '" . Attachments::TYPE_DOCUMENTS . "'){
                        var img_src = '/images/text-file-icon.png';
                        var new_doc = '<img src=\"' + img_src + '\" width=\"" . $this->options['width_img'] . "\">';
                        var new_block = '<div id=\"upload-img-' + data.result[0].id + '\" class=\"upload-img\" style=\"display:none\">' + delete_button + new_doc + '</div>';
                    }

                    $('#" . $this->options['img_id'] . "').append(new_block);
                    $('#" . $this->options['img_id'] . " #upload-img-' + data.result[0].id).show(400);
                },
                fail: function (e, data) {
                    alert('Что то не так...');
                    console.log(data.jqXHR.responseText);
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        ";

        Yii::$app->view->registerJs($jsCode, \yii\web\View::POS_READY);

        Yii::$app->view->registerJsFile('/js/jquery/jquery.ui.widget.js', [
            'depends' => [
                'yii\web\YiiAsset',
            ],
        ]);
        Yii::$app->view->registerJsFile('/js/jquery/jquery.fileupload.js', [
            'depends' => [
                'yii\web\YiiAsset',
            ],
        ]);
    }
}