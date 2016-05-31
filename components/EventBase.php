<?php

namespace app\components;

use app\models\Users;
use Yii;

abstract class EventBase
{
    const EVENT_DB_CAPTURED = 'event_db_captured';

    public $to;
    public $message;

    public function getReceivers()
    {
        if(!$this->to){
            return [];
        }
        if(is_array($this->to)){
            return array_keys(Users::getListByRoles($this->to));
        } elseif(is_numeric($this->to)){
            return [$this->to];
        } elseif(is_string($this->to)){
            return array_keys(Users::getListByRoles([$this->to]));
        }
        return [];
    }

    public function getEventId()
    {
        return static::className();
    }

    public static function className()
    {
        return get_called_class();
    }

    public function trigger()
    {
        $eventObject = new EventObject();
        $eventObject->event = $this;

        Yii::$app->trigger($this->getEventId(), $eventObject);
        Yii::$app->trigger(self::EVENT_DB_CAPTURED, $eventObject);
    }
}