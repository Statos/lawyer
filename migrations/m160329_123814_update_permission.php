<?php

use yii\db\Migration;

class m160329_123814_update_permission extends Migration
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
                ['index', 'Can view users list', ['administrator', 'chief']],
                ['view', 'Can view user', ['administrator', 'chief']],
            ],
            'Law' => [
                ['index', 'Can view Law list', ['lawyer', 'chief']],
                ['view', 'Can view Law', ['lawyer', 'chief']],
                ['create', 'Can create Law', ['lawyer', 'chief']],
                ['update', 'Can update Law', ['lawyer', 'chief']],
                ['delete', 'Can delete Law', ['lawyer', 'chief']],
            ],
            'insurance' => [
                ['index', 'Can view Work list', ['chief']],
                ['view', 'Can view Work', ['chief']],
                ['create', 'Can create Work', ['chief']],
                ['update', 'Can update Work', ['chief']],
                ['delete', 'Can delete Work', ['chief']],
            ],
        ];
    }
}
