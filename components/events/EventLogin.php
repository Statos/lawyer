<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\Users;

class EventLogin extends EventBase
{
    public function __construct($id, $username)
    {
        $this->to = Users::ROLE_ADMINISTRATOR;
        $this->message = 'Пользователь выполнил вход в систему: ' . $username;
    }
}