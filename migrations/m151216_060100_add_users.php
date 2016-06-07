<?php

use app\models\Users;
use yii\db\Migration;

class m151216_060100_add_users extends Migration
{
    const ONLY_LIGHT = true;

    public $defaultPassword = '111111';
    public $users = [
        ['email' => 'chief@test.ru', 'username' => 'chief', 'fio' => 'chief', 'role' => 'chief'],
        ['email' => 'lawyer@test.ru', 'username' => 'lawyer', 'fio' => 'lawyer', 'role' => 'lawyer'],
        ['email' => 'lawyer2@test.ru', 'username' => 'lawyer2', 'fio' => 'lawyer2', 'role' => 'lawyer'],
        ['email' => 'lawyer3@test.ru', 'username' => 'lawyer3', 'fio' => 'lawyer3', 'role' => 'lawyer'],
        ['email' => 'administrator@test.ru', 'username' => 'administrator', 'fio' => 'administrator', 'role' => 'administrator'],
    ];

    public function safeUp()
    {
        return true;
        $authManager = Yii::$app->authManager;

        foreach($this->users as $user) {
            if(self::ONLY_LIGHT || YII_ENV_DEV){
                $password = $this->defaultPassword;
            } else {
                $password = Yii::$app->security->generateRandomString(6);
            }
            $role = $user['role'];
            unset($user['role']);

            $user = Yii::createObject(array_merge([
                'class' => Users::className(),
                'password' => $password,
                'phone' => '+79001112233',
                'status' => Users::STATUS_ACTIVE,
                'set_auth' => false,
            ], $user));
            try {
                if ($user->save()) {
                    echo "Create user. Username: " . $user->username . " Password: $password" . PHP_EOL;
                    $authRole = $authManager->getRole($role);
                    if ($authManager->assign($authRole, $user->id)) {
                        echo "Role $role assign" . PHP_EOL;
                    } else {
                        echo "Error on role $role added" . PHP_EOL;
                    }
                } else {
                    var_dump($user->errors);
                }
            } catch(yii\db\IntegrityException $e) {
                echo "User dont create on {$user->username} - duplicate" . PHP_EOL;
            }
        }
    }

    public function safeDown()
    {
        return true;
        $authManager = Yii::$app->authManager;

        foreach($this->users as $user) {
            $username = $user['username'];
            $role = $user['role'];
            /** @var Users $user */
            if($user = Users::findByUsername($username)) {
                $authRole = $authManager->getRole($role);
                if ($authManager->revoke($authRole, $user->id)) {
                    echo "{$username} Role revoke" . PHP_EOL;
                } else {
                    echo "{$username} Error on role revoke" . PHP_EOL;
                }

                if($user->delete()) {
                    echo "Delete user. Username: {$username}" . PHP_EOL;
                } else {
                    echo "User not delete. Username: {$username}" . PHP_EOL;
                }
            } else {
                echo "User not found. Username: {$username}" . PHP_EOL;
            }
        }
    }
}
