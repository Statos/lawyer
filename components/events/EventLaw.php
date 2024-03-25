<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\User;
use yii\helpers\Html;

class EventLaw extends EventBase
{
    public function __construct($insert, $id, $name)
    {
        $this->to = [User::ROLE_LAWYER, User::ROLE_CHIEF];
        $this->message = ($insert ? 'Добавлен новый закон: ' : 'Изменен закон: ')
            . Html::a($name, ['/law/view' , 'id' => $id]);
    }
}