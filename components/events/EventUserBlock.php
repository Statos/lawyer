<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\User;
use yii\helpers\Html;

class EventUserBlock extends EventBase
{
    public function __construct($id, $username)
    {
        $this->to = [User::ROLE_ADMINISTRATOR, User::ROLE_CHIEF];
        $this->message = 'Пользователь заблокирован в системе: ' . Html::a($username, ['/users/view' , 'id' => $id]);
    }
}