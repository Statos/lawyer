<?php

use yii\db\Migration;

class m160527_071029_new_permission extends Migration
{
    use app\traits\PermissionMigration;

    public function init()
    {
        parent::init();
        $this->authManager = Yii::$app->getAuthManager();
        $this->moduleName = 'Basic';
        $this->permissions = [
            'Users' => [
                ['cabinet', 'Can update profile', ['lawyer', 'chief', 'administrator']],
            ],
        ];
    }
}
