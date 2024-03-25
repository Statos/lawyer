<?php

namespace app\components;

use app\models\Notifications;
use Yii;
use yii\helpers\BaseInflector;
use yii\helpers\Html;


/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class Menu {

    const ALLOW_ALL = false;

    public static function getItems()
    {
        $data = self::_items();
        foreach($data as &$menu){
            $menu = self::ALLOW_ALL ? $menu : self::checkMenuItems($menu);
        }
        return $data;
    }

    private static function _items()
    {
        $data = [];

        $data[] = [
            'label' => self::getUserAvatar() . 'Профиль',
            'encode' => false,
            'url' => ['/users/cabinet'],
            'options' => ['class' => 'li-profile'],
        ];
        $data[] = ['label' => 'О нас', 'url' => ['/site/about']];
        $data[] = ['label' => 'Пользователи', 'url' => ['/users/index']];
        $data[] = ['label' => 'Роли', 'url' => ['/admin']];

        $data[] = ['label' => 'Дела', 'url' => ['/work/index']];
        $data[] = ['label' => 'Законы', 'url' => ['/law/index']];
        $data[] = ['label' => 'Страховые случаи', 'url' => ['/insurance/index']];

        $data[] = ['label' => 'Уведомления' . self::getNotifyBadge(), 'encode' => false, 'url' => ['/notifications/index']];

        if(!Yii::$app->user->isGuest) {
            $data[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>';
        } else {
            //$data[] = ['label' => 'Регистрация', 'url' => ['/users/create'], 'visible' => true];
            $data[] = ['label' => 'Вход', 'url' => ['/site/login'], 'visible' => true];
        }

        return $data;
    }

    public static function getUserAvatar()
    {
        /** @var \app\models\User $userModel */
        if(!Yii::$app->user->isGuest) {
            $userModel = Yii::$app->user->identity;
            return Html::img($userModel->avatarUrl, ['class' => 'img-circle nav-avatar']);
        }
        return '';
    }

    public static function getNotifyBadge()
    {
        if(!Yii::$app->user->isGuest){
            $count = Notifications::getCountUnreadNotify(Yii::$app->user->id);
            if($count){
                return '<span class="badge">' . $count . '</span>';
            }
        }
        return '';
    }

    private static function checkMenuItems($menu)
    {
        if(is_string($menu)){
            return $menu;
        }
        if (!empty($menu['url']) && !isset($menu['visible'])) {
            $menu['visible'] = isset($menu['visible'])
                ? $menu['visible']
                : Yii::$app->user->can(BaseInflector::camelize('basic_' . $menu['url'][0]));
        }

        return $menu;
    }

}