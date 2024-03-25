<?php

namespace app\modules\upload\widgets;

use app\modules\upload\models\Attachments;
use yii\base\Widget;

class AttachmentWidget extends Widget
{
    public $model;

    public function run()
    {
        $attachments = Attachments::getModelAttachment($this->model);

        return $this->render('attachment', [
            'self' => $this,
            'attachments' => $attachments
        ]);
    }
}