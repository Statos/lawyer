<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\Users;
use yii\helpers\Html;

class EventLaw extends EventBase
{
    public function __construct($insert, $id, $name)
    {
        $this->to = [Users::ROLE_LAWYER, Users::ROLE_CHIEF];
        $this->message = ($insert ? 'Добавлен новый закон: ' : 'Изменен закон: ')
            . Html::a($name, ['/law/view' , 'id' => $id]);
    }
}