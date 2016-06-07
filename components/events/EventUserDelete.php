<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\Users;
use yii\helpers\Html;

class EventUserDelete extends EventBase
{
    public function __construct($id, $username)
    {
        $this->to = [Users::ROLE_ADMINISTRATOR, Users::ROLE_CHIEF];
        $this->message = "Пользователь удален из системы: id:$id, login:$username";
    }
}