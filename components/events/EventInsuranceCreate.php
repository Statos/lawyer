<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\User;
use yii\helpers\Html;

class EventInsuranceCreate extends EventBase
{
    public function __construct($user_id, $id, $name)
    {
        $this->to = $user_id;
        $this->message = 'На вас возложен новый страховой случай: ' . Html::a($name, ['/insurance/view' , 'id' => $id]);
    }
}