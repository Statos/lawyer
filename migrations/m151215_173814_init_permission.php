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
                ['index', 'Can view users list', ['chief', 'administrator']],
                ['view', 'Can view user', ['chief', 'administrator']],
                ['create', 'Can create/registration user', ['chief', 'administrator', 'guest']],
                ['update', 'Can update user+password', ['administrator']],
                ['delete', 'Can delete user', ['administrator']],
            ],
            'Law' => [
                ['index', 'Can view Law list', ['lawyer', 'chief']],
                ['view', 'Can view Law', ['lawyer', 'chief']],
                ['create', 'Can create Law', ['chief']],
                ['update', 'Can update Law', ['chief']],
                ['delete', 'Can delete Law', ['chief']],
            ],
            'Work' => [
                ['index', 'Can view Work list', ['lawyer']],
                ['view', 'Can view Work', ['lawyer']],
                ['create', 'Can create Work', ['lawyer']],
                ['update', 'Can update Work', ['lawyer']],
                ['delete', 'Can delete Work', ['lawyer']],
            ],
            'Insurance' => [
                ['index', 'Can view Insurance list', ['lawyer', 'chief']],
                ['view', 'Can view Insurance', ['lawyer', 'chief']],
                ['update', 'Can update Insurance', ['lawyer', 'chief']],
                ['updateAll', 'Can update Insurance', ['chief']],
                ['create', 'Can create Insurance', ['chief']],
                ['delete', 'Can delete Insurance', ['chief']],
            ],
        ];
    }
}
