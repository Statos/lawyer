<?php

namespace app\components\basic;

use Yii;
use yii\helpers\BaseInflector;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{

    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['done'])) {
            $this->buttons['done'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Выполнено'),
                    'aria-label' => Yii::t('yii', 'Выполнено'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                if(!$model->isDone()) {
                    return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                } else {
                    return '';
                }
            };
        }
    }

    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;
            return Yii::$app->user->can(BaseInflector::camelize('basic_' . Url::toRoute($params[0])))
                ? Url::toRoute($params)
                : false;
        }
    }
}