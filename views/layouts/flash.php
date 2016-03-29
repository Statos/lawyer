<?php
foreach (Yii::$app->session->getAllFlashes() as $data) {
    $key = !empty($data) && count($data) > 1 ? $data[0] : \kartik\growl\Growl::TYPE_INFO;
    $message = !empty($data) && count($data) > 1 ? $data[1] : $data[0];
    echo kartik\growl\Growl::widget([
        'type' => $key,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => $message,
        'showSeparator' => false,
        'delay' => 0,
        'pluginOptions' => [
            'showProgressbar' => true,
            'placement' => [
                'from' => 'top',
                'align' => 'right',
            ]
        ]
    ]);
}