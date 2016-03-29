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
 *      'id'            - (string) id input hidden field
 *      'name'          - (string) name input hidden field
 *      'file_button'   - (array) if isset use button [
 *          'button_text'   - (string) if use button, use class
 *          'button_class'  - (string) if use button, use class
 *      ]
 *      'file_id'       - (string) id file input
 *      'img_none'      - (string) if TRUE no display img
 *      'img_id'        - (string) id img
 *      'alt_img'       - (string) alt img
 *      'width_id'      - (string) width img
 *
 *      'url_upload'- (string) url for ajax function //TODO YII2
 *      'ajax_options'   - (array) POST parametrs, which send on server by ajax
 *      ]
 *  ]);
 */

namespace app\modules\upload\widgets;

use app\modules\upload\models\Attachments;
use Yii;
use yii\base\Widget;
use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\helpers\Html;


class UploadWidget extends Widget
{
    const ID_FILE_INPUT = '-file';
    const ID_FILE_BUTTON = '-button';
    const ID_IMG = '-img';
    const ALT_IMG = 'NO';
    const WIDTH_IMG = '200px';
    const URL_UPLOAD = '/upload/default/upload/';
    const APPLICATION_IMAGE = '/images/filetypes-icons/text-file-icon.png';

    public $model;

    public $attribute;

    public $options = [];

    public function init()
    {
        if (!$this->hasModel()) {
            throw new InvalidConfigException("Either 'name', or 'model' and 'attribute' properties must be specified.");
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        if (!isset($this->options['name'])) {
            $this->options['name'] = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->getId();
        }
        if (!isset($this->options['file_id'])) {
            $this->options['file_id'] = $this->options['id'] . self::ID_FILE_INPUT;
        }
        if (!isset($this->options['img_id'])) {
            $this->options['img_id'] = $this->options['id'] . self::ID_IMG;
        }
        if (!isset($this->options['url_upload'])) {
            $this->options['url_upload'] = self::URL_UPLOAD;
        }
        if(!isset($this->options['width_img']))
            $this->options['width_img'] = self::WIDTH_IMG;

        $this->registerLocalJs();

        parent::init();
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }

    public function run()
    {
		$attach = Attachments::getAttributeAttachment($this->model->{$this->attribute});
        if ( ! (isset($this->options['img_none']) && $this->options['img_none'] === true) ){
            echo Html::img($attach ? $attach->url : false, [
                'id' => $this->options['img_id'],
                'alt' => isset($this->options['alt_img']) ? $this->options['alt_img'] : self::ALT_IMG,
                'width' => $this->options['width_img'],
                'style'=> $attach ? '' : 'display: none',
            ]);
        }

        $this->loadFileInput();

        echo Html::hiddenInput($this->options['name'], $this->model->{$this->attribute}, [
            'id'=> $this->options['id'],
        ]);

    }

    public function loadFileInput()
    {
        if( isset($this->options['file_button']) ){
            if(!isset($this->options['file_button']['button_text']))
                $this->options['file_button']['button_text'] = 'Добавить файлы';
            if(!isset($this->options['file_button']['button_id']))
                $this->options['file_button']['button_id'] = $this->options['file_id'] . self::ID_FILE_BUTTON;
            if(!isset($this->options['file_button']['button_class']))
                $this->options['file_button']['button_class'] = 'btn';
        }

        if( ! isset($this->options['file_button']) ) {
            echo Html::fileInput('files', '', [
                'id' => $this->options['file_id'],
                'multiple'=>true
            ]);
        } else {
            $fileInputOptions = [];
            $fileInputOptions['id'] = $this->options['file_id'];
            $fileInputOptions['style'] = 'display:none';
            if( \yii\helpers\StringHelper::basename(get_class($this)) == 'MultiuploadWidget') {
                $fileInputOptions['multiple'] = true;
            }

            echo Html::fileInput('files', '', $fileInputOptions);
            echo Html::button(
                $this->options['file_button']['button_text'], [
                    'id' => $this->options['file_button']['button_id'],
                    'class' =>  $this->options['file_button']['button_class'],
                ]);
            $this->registerButtonJs();
        }
    }

    protected function loadFormData()
    {
        if(!isset($this->options['ajax_options']))
            $this->options['ajax_options'] = array();
        if(!isset($this->options['ajax_options']['model_id']))
            if( ($model_id = $this->model->getPrimaryKey() ) !== NULL)
                $this->options['ajax_options']['model_id'] = $model_id;
        if(!isset($this->options['ajax_options']['model_class']))
            $this->options['ajax_options']['model_class'] = \yii\helpers\StringHelper::basename(get_class($this->model));

        return !empty($this->options['ajax_options']) ? 'formData : '. json_encode($this->options['ajax_options']) . ',' : '';
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
                done: function (e, data) {
                    var img = data.result[0].attachment;
                    if(img.error){
                        alert(img.error);
                        return;
                    }
                    $('#".$this->options['id']."').val(JSON.stringify(data.result[0].id));
                    if(img.thumbUrl)
                        $('#".$this->options['img_id']."').attr('src', img.thumbUrl);
                    else
                        $('#".$this->options['img_id']."').attr('src', img.url);

                    $('#".$this->options['img_id']."').show();
                },
                fail: function (e, data) {
                    alert('Что то пошло не так...');
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

    private function registerButtonJs()
    {
        $jsCode = "
            $('#" . $this->options['file_button']['button_id'] . "').on('click', function(){
                $('#" . $this->options['file_id'] . "').trigger('click');
                return false;
            });
        ";
        Yii::$app->view->registerJs($jsCode, \yii\web\View::POS_READY);
    }
}