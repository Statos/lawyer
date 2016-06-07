<?php

namespace app\components\events;

use app\components\EventBase;
use app\models\Users;
use yii\helpers\Html;

class EventInsuranceTimeout extends EventBase
{
    public function __construct($user_id, $id, $name, $day)
    {
        $this->to = [Users::ROLE_CHIEF, $user_id];
        $this->message = 'До окончания страхового случая осталось: '
            . self::convertDay($day)
            . ' - ' . Html::a($name, ['/insurance/view' , 'id' => $id]);
    }

    public static function convertDay($day)
    {
        if($day > 4) return $day . ' Дней';
        if($day > 1) return $day . ' Дня';
        return $day . ' День';
    }
}