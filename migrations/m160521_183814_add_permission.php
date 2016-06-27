<?php

use app\components\traits\PermissionMigration;
use yii\db\Migration;

class m160521_183814_add_permission extends Migration
{
    use PermissionMigration;

    public function init()
    {
        parent::init();
        $this->authManager = Yii::$app->getAuthManager();
        $this->moduleName = 'Basic';
        $this->permissions = [
            'Insurance' => [
                ['excel', 'Can export to excel', ['lawyer', 'chief']],
            ],
        ];
    }
}
