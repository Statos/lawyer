<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\Users;
use yii\helpers\Html;

class EventUserBlock extends EventBase
{
    public function __construct($id, $username)
    {
        $this->to = [Users::ROLE_ADMINISTRATOR, Users::ROLE_CHIEF];
        $this->message = 'Пользователь заблокирован в системе: ' . Html::a($username, ['/users/view' , 'id' => $id]);
    }
}