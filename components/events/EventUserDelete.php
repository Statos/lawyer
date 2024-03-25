<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\User;
use yii\helpers\Html;

class EventUserDelete extends EventBase
{
    public function __construct($id, $username)
    {
        $this->to = [User::ROLE_ADMINISTRATOR, User::ROLE_CHIEF];
        $this->message = "Пользователь удален из системы: id:$id, login:$username";
    }
}