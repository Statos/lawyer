<?php

use yii\db\Migration;

class m151215_173814_init_permission extends Migration
{
    use app\traits\PermissionMigration;

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
                ['index', 'Can view users list', ['administrator']],
                ['view', 'Can view user', ['administrator']],
                ['create', 'Can create/registration user', ['administrator', 'guest']],
                ['update', 'Can update user+password', ['administrator']],
                ['delete', 'Can delete user', ['administrator']],
            ],
            'Law' => [
                ['index', 'Can view Law list', ['lawyer']],
                ['view', 'Can view Law', ['lawyer']],
                ['create', 'Can create Law', ['lawyer']],
                ['update', 'Can update Law', ['lawyer']],
                ['delete', 'Can delete Law', ['lawyer']],
            ],
            'Work' => [
                ['index', 'Can view Work list', ['lawyer']],
                ['view', 'Can view Work', ['lawyer']],
                ['create', 'Can create Work', ['lawyer']],
                ['update', 'Can update Work', ['lawyer']],
                ['delete', 'Can delete Work', ['lawyer']],
            ],
        ];
    }
}
