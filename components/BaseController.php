<?php

namespace app\components;

use kartik\growl\Growl;
use Yii;
use yii\helpers\BaseInflector;
use yii\web\Controller;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class BaseController extends Controller
{
    public $allowAll = false;

    public function init()
    {
        \Yii::$app->on(EventBase::EVENT_DB_CAPTURED, function(EventObject $eventObject) {
            /** @var Catcher $catcher */
            $catcher = \Yii::$container->get('app\components\Catcher');
            $catcher->catchEvent($eventObject->event);
        });
    }

    public function setFlash($key, $data = [])
    {
        Yii::$app->session->setFlash($key, $data);
    }

    public function setDangerFlash($key, $message)
    {
        $this->setFlash($key, [Growl::TYPE_DANGER, $message]);
    }

    public function setSuccessFlash($key, $message)
    {
        $this->setFlash($key, [Growl::TYPE_SUCCESS, $message]);
    }

    public function beforeAction($action)
    {
        /** @var InlineAction $action */
        if (!parent::beforeAction($action)) return false;

        if (!Yii::$app->user->isGuest) Yii::$app->user->identity->updateOnline();

        $reflectionClass = new \ReflectionClass($this);
        $className = str_replace('Controller', '', $reflectionClass->getShortName());
        $permission = BaseInflector::camelize($this->module->id . '_' . $className . '_' . $action->id);
        //var_dump($permission);exit;
        if ($this->allowAll || Yii::$app->user->can($permission)) return true;

        $errorMessage = 'Доступ запрещен';
        if(YII_DEBUG) {
            $errorMessage .= ' ' . $permission;
        }

        $this->setDangerFlash('permission', $errorMessage);
        $this->redirect(Yii::$app->request->hostInfo);
        return false;
    }

}
