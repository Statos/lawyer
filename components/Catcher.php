<?php

namespace app\components;

use app\models\Notifications;
use Yii;

class Catcher
{

    public function catchEvent(EventBase $event)
    {
        foreach ($event->getReceivers() as $receiver) {
            Notifications::sendNotify($receiver, $event->message);
        }
    }

}