<?php

namespace app\modules\upload\controllers;


use Yii;
use yii\web\Controller;

use app\modules\upload\models\Attachments;
use app\modules\upload\helpers\RUploadHandler;

use yii\web\Response;

class DefaultController extends Controller
{
    private $uploadPath = '/uploads/';
    private $uh_settings = array();



//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['upload', 'delete'],
//                        'allow' => true,
//                        'roles' => ['*'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'post' => ['delete'],
//                ],
//            ],
//        ];
//    }


    public function getUhSettings($file_type = 'image', $addUploadPath = '')
    {
        $addUploadPath = $addUploadPath ? $addUploadPath . '/' : '';
        if(!isset($this->uh_settings['upload_dir']))
            if(isset($_SERVER['SCRIPT_FILENAME']))
                $this->uh_settings['upload_dir'] =  dirname($_SERVER['SCRIPT_FILENAME']).$this->uploadPath . $addUploadPath;

        if(!isset($this->uh_settings['upload_url'])) {
            $this->uh_settings['upload_url'] = $this->uploadPath . $addUploadPath;
        }

        if(!isset($this->uh_settings['accept_file_types'])) {
            if ($file_type === 'image')
                $accept_file_types = Attachments::REGEX_IMAGE;
            elseif($file_type === 'document')
                $accept_file_types = Attachments::REGEX_DOCUMENT;
            elseif($file_type === 'image+document')
                $accept_file_types = Attachments::REGEX_IMAGE . '|' . Attachments::REGEX_DOCUMENT;
            else
                $accept_file_types = Attachments::REGEX_IMAGE;
            $this->uh_settings['accept_file_types'] = Attachments::preRegex($accept_file_types);
        }

        return $this->uh_settings;
    }

    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $action         = Yii::$app->request->post('action', 'error');
        $model_class    = Yii::$app->request->post('model_class', NULL);
        $model_id       = Yii::$app->request->post('model_id', NULL);

        ob_start();
        switch ($action) {
            case 'ava-image':
                $settings = $this->getUhSettings('image', $model_class);
                $settings['crop'] = [];
                $ratio = floatval(Yii::$app->request->post('image-ratio', 1));
                $settings['crop']['src_x'] = $ratio * floatval(Yii::$app->request->post('image-x1', 0));
                $settings['crop']['src_y'] = $ratio * floatval(Yii::$app->request->post('image-y1', 0));
                $x2 = $ratio * floatval(Yii::$app->request->post('image-x2', 0));
                $settings['crop']['new_width'] = $x2 - $settings['crop']['src_x'];
                $y2 = $ratio * floatval(Yii::$app->request->post('image-y2', 0));
                $settings['crop']['new_height'] = $y2 - $settings['crop']['src_y'];
                new RUploadHandler($settings);
                break;
            case 'product-image':
                $settings = $this->getUhSettings('image', $model_class);
                $settings['image_versions'] = [
                    'title' => [
                        'crop' => true,
                        'max_width' => 200,
                        'max_height' => 200,
                    ]
                ];
                new RUploadHandler($settings);
                break;
            case 'comment-attachment':
                $settings = $this->getUhSettings('image+document', $model_class);
                new RUploadHandler($settings);
                break;
            case 'error':
            default:
                ob_end_flush();
                return ['status' => false, 'error' => 'Error action'];
        }
        $files = ob_get_clean();
        ob_end_clean();

        $attachments = [];
        if(isset(json_decode($files)->files))
            foreach (json_decode($files)->files as $file) {
                if(isset($file->error)) {
                    $attachments[] = $file;
                    continue;
                }
                $attachment = new Attachments();
                $attachment->model_class = $model_class;
                $attachment->model_id = $model_id;
                $attachment->attachment = $file;
                if($attachment->save()) {
                    $attachments[] = $attachment->toHash();
                }
                else {
                    $attachments[] = $attachment->getErrors();
                }
            }
        return $attachments;
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id', NULL);
        if(!$id)
            echo json_encode(['error'=>true, 'message'=>'no params']);
        $model = Attachments::find()->where(['id'=>$id])->one();
        if($model->delete())
            echo json_encode(['success'=>true]);
        else
            echo json_encode(['error'=>true, 'message'=>'error delete model']);
    }


}