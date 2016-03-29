<?php

namespace app\commands;

use app\models\Users;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    const ROLE_ROOT = 'admin';

    public function actionSetRootRole($username)
    {
        $this->stdout(sprintf("Setting root role to %s \n", $username));
        $user = Users::findByUsername($username);
        if ($user === null) {
            $this->stdout('User not found', Console::FG_RED);
            exit();
        }

        $authManager = Yii::$app->authManager;
        $rootRole = $authManager->getRole(self::ROLE_ROOT);
        if ($rootRole === null) {
            $this->stdout(sprintf('Role %s not found', self::ROLE_ROOT), Console::FG_RED);
            exit();
        }

        try {
            $authManager->assign($rootRole, $user->id);
        } catch (\Exception $e) {
            $this->stdout(
                sprintf(
                    "Role %s has already been assigned to the user \n", self::ROLE_ROOT),
                Console::FG_RED
            );
            exit();
        }

        $this->stdout(sprintf("Role %s has been assigned\n", self::ROLE_ROOT), Console::FG_GREEN);
    }
}
