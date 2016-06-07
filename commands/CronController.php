<?php

namespace app\commands;

use app\components\Catcher;
use app\components\EventBase;
use app\components\EventObject;
use app\components\events\EventInsuranceTimeout;
use app\components\events\EventWorkTimeout;
use app\models\Insurance;
use app\models\Work;
use yii\console\Controller;


class CronController extends Controller
{

    public function init()
    {
        \Yii::$app->on(EventBase::EVENT_DB_CAPTURED, function(EventObject $eventObject) {
            /** @var Catcher $catcher */
            $catcher = \Yii::$container->get('app\components\Catcher');
            $catcher->catchEvent($eventObject->event);
        });
    }

    public function actionTimeout()
    {
        $this->workTimeOut();
        $this->insuranceTimeOut();
    }

    private function workTimeOut()
    {
        $counter = 0;
        $models = Work::find()
            ->select(['*', 'DATEDIFF(max_at, NOW()) as date_diff'])
            ->where('DATEDIFF(max_at, NOW()) < 7')
            ->all();
        foreach($models as $model){
            /** @var \app\models\Work $model */
            if($this->isNeedEvent($model->date_diff)){
                (new EventWorkTimeout($model->user_id, $model->id, $model->name, $model->date_diff))->trigger();
                $counter++;
            }
        }
        if($counter){
            echo 'EventWorkTimeout added:' . $counter;
        }
    }

    private function insuranceTimeOut()
    {
        $counter = 0;
        $models = Insurance::find()
            ->select(['*', 'DATEDIFF(max_at, NOW()) as date_diff'])
            ->where('DATEDIFF(max_at, NOW()) < 7')
            ->all();
        foreach($models as $model){
            /** @var \app\models\Insurance $model */
            if($this->isNeedEvent($model->date_diff)){
                (new EventInsuranceTimeout($model->user_id, $model->id, $model->name, $model->date_diff))->trigger();
                $counter++;
            }
        }
        if($counter){
            echo 'EventInsuranceTimeout added:' . $counter;
        }
    }

    private function isNeedEvent($diff)
    {
        return $diff == 7 || $diff == 3 || $diff == 2 || $diff == 1;
    }
}
