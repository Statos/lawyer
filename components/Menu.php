<?php

namespace app\components;

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
            $menu = self::ALLOW_ALL ? $menu : self::checkMenuItemsRecursive($menu);
        }
        return $data;
    }

    public static function _items()
    {
        $data = [];

        $data[] = ['label' => 'Главная', 'url' => ['/site/index'], 'visible' => true];
        $data[] = ['label' => 'О нас', 'url' => ['/site/about']];
        $data[] = ['label' => 'Пользователи', 'url' => ['/users/index']];
        $data[] = ['label' => 'Роли', 'url' => ['/admin']];

        $data[] = ['label' => 'Дела', 'url' => ['/work/index']];
        $data[] = ['label' => 'Законы', 'url' => ['/law/index']];
        $data[] = ['label' => 'Страховые случаи', 'url' => ['/insurance/index']];

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
            $data[] = ['label' => 'Регистрация', 'url' => ['/users/create'], 'visible' => true];
            $data[] = ['label' => 'Вход', 'url' => ['/site/login'], 'visible' => true];
        }

        return $data;
    }

    private static function checkMenuItemsRecursive($menu)
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