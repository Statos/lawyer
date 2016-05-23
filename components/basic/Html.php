<?php

namespace app\components\basic;

use Yii;
use yii\helpers\BaseInflector;
use yii\helpers\Html as BaseHtml;
use yii\helpers\Url;

class Html extends BaseHtml
{
    public static function a($text, $url = null, $options = [])
    {
        if(!is_array($url) || isset($options['noAuth'])){
            unset($options['noAuth']);
            return parent::a($text, $url, $options);
        }
        if(Yii::$app->user->can(BaseInflector::camelize('basic_' . Url::toRoute($url[0])))){
            return parent::a($text, $url, $options);
        }
        return '';
    }
}