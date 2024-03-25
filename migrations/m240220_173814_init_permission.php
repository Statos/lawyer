<?php

use app\components\traits\PermissionMigration;
use yii\db\Migration;

class m240220_173814_init_permission extends Migration
{
    use PermissionMigration;

    public function init()
    {
        parent::init();

        $this->authManager = Yii::$app->getAuthManager();
        $this->moduleName = 'Basic';
        $this->permissions = [
            '' => [
                ['admin', 'Can manage roles', ['administrator']]
            ],
            'Users' => [
                ['index', 'Can view users list', ['chief', 'administrator']],
                ['view', 'Can view user', ['chief', 'administrator']],
                ['create', 'Can create/registration user', ['chief', 'administrator', 'guest']],
                ['update', 'Can update user+password', ['administrator']],
                ['delete', 'Can delete user', ['administrator']],
                ['cabinet', 'Can update profile', ['lawyer', 'chief', 'administrator']],
            ],
            'Law' => [
                ['index', 'Can view Law list', ['lawyer', 'chief']],
                ['view', 'Can view Law', ['lawyer', 'chief']],
                ['create', 'Can create Law', ['lawyer', 'chief']],
                ['update', 'Can update Law', ['lawyer', 'chief']],
                ['delete', 'Can delete Law', ['chief']],
            ],
            'Work' => [
                ['index', 'Can view Work list', ['chief', 'lawyer']],
                ['view', 'Can view Work', ['chief', 'lawyer']],
                ['create', 'Can create Work', ['chief', 'lawyer']],
                ['update', 'Can update Work', ['chief', 'lawyer']],
                ['done', 'Can update Work', ['chief', 'lawyer']],
                ['updateAll', 'Can update Work', ['chief']],
                ['delete', 'Can delete Work', ['chief', 'lawyer']],
            ],
            'Insurance' => [
                ['index', 'Can view Insurance list', ['lawyer', 'chief']],
                ['view', 'Can view Insurance', ['lawyer', 'chief']],
                ['update', 'Can update Insurance', ['lawyer', 'chief']],
                ['updateAll', 'Can update Insurance', ['chief']],
                ['create', 'Can create Insurance', ['chief']],
                ['delete', 'Can delete Insurance', ['chief']],
                ['excel', 'Can export to excel', ['lawyer', 'chief']],
            ],
            'Notifications' => [
                ['index', 'Can view Notifications list', ['lawyer', 'chief', 'administrator']],
                ['indexAll', 'Can view Notifications all list', ['administrator']],
                ['view', 'Can view Notifications', ['lawyer', 'chief', 'administrator']],
                ['create', 'Can create Notifications', ['administrator']],
            ],
        ];
    }
}
