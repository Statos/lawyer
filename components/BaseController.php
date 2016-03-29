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
    const ALLOW_ALL = false;

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

        $reflectionClass = new \ReflectionClass($this);
        $className = str_replace('Controller', '', $reflectionClass->getShortName());
        $permission = BaseInflector::camelize($this->module->id . '_' . $className . '_' . $action->id);
        //var_dump($permission);exit;
        if (self::ALLOW_ALL || Yii::$app->user->can($permission)) return true;

        $errorMessage = 'Доступ запрещен';
        if(YII_DEBUG) {
            $errorMessage .= ' ' . $permission;
        }

        $this->setDangerFlash('permission', $errorMessage);
        $this->redirect(Yii::$app->request->hostInfo);
        return false;
    }

}