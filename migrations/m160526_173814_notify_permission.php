<?php

use yii\db\Migration;

class m160526_173814_notify_permission extends Migration
{
    use app\traits\PermissionMigration;

    public function init()
    {
        parent::init();
        $this->authManager = Yii::$app->getAuthManager();
        $this->moduleName = 'Basic';
        $this->permissions = [
            'Notifications' => [
                ['index', 'Can view Notifications list', ['lawyer', 'chief', 'administrator']],
                ['indexAll', 'Can view Notifications all list', ['administrator']],
                ['view', 'Can view Notifications', ['lawyer', 'chief', 'administrator']],
                ['create', 'Can create Notifications', ['administrator']],
            ],
        ];
    }
}
