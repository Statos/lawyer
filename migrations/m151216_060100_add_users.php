<?php

use app\models\Users;
use yii\db\Migration;

class m151216_060100_add_users extends Migration
{
    const ONLY_LIGHT = true;

    public $defaultPassword = '111111';
    public $users = [
        ['email' => 'chief@test.ru', 'username' => 'chief', 'fio' => 'chief'],
        ['email' => 'lawyer@test.ru', 'username' => 'lawyer', 'fio' => 'lawyer'],
        ['email' => 'administrator@test.ru', 'username' => 'administrator', 'fio' => 'administrator'],
    ];

    public function up()
    {
        $authManager = Yii::$app->authManager;

        foreach($this->users as $user) {
            if(self::ONLY_LIGHT || YII_ENV_DEV){
                $password = $this->defaultPassword;
            } else {
                $password = Yii::$app->security->generateRandomString(6);
            }

            $user = Yii::createObject(array_merge([
                'class' => Users::className(),
                //'scenario' => 'create',
                'password' => $password,
                'phone' => '+79001112233',
                'set_auth' => false,
            ], $user));
            try {
                if ($user->save()) {
                    echo "Create user. Username: " . $user->username . " Password: $password" . PHP_EOL;
                    $authRole = $authManager->getRole($user->username);
                    if ($authManager->assign($authRole, $user->id)) {
                        echo 'Role added' . PHP_EOL;
                    } else {
                        echo 'Error on role added' . PHP_EOL;
                    }
                } else {
                    var_dump($user->errors);
                }
            } catch(yii\db\IntegrityException $e) {
                echo "User dont create on {$user->username} - duplicate" . PHP_EOL;
            }
        }
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        foreach($this->users as $user) {
            $username = $user['username'];
            /** @var Users $user */
            if($user = Users::findByUsername($username)) {
                $authRole = $authManager->getRole($user->username);
                if ($authManager->revoke($authRole, $user->id)) {
                    echo '{$username} Role revoke' . PHP_EOL;
                } else {
                    echo '{$username} Error on role revoke' . PHP_EOL;
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
