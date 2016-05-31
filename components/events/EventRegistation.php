<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\Users;
use yii\helpers\Html;

class EventRegistation extends EventBase
{
    public function __construct($id, $username)
    {
        $this->to = [Users::ROLE_ADMINISTRATOR, Users::ROLE_CHIEF];
        $this->message = 'Новый пользователь прошел регистрацию, login:' . Html::a($username, ['/users/view' , 'id' => $id]);
    }
}