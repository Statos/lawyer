<?php

use yii\db\Migration;

class m240220_173740_create_roles extends Migration
{
    /** @var  \yii\rbac\ManagerInterface */
    private $authManager;

    public function init()
    {
        parent::init();
        $this->authManager = \Yii::$app->authManager;
    }

    public function up()
    {
        $guest = $this->authManager->createRole('guest');
        $chief = $this->authManager->createRole('chief');
        $lawyer = $this->authManager->createRole("lawyer");
        $administrator = $this->authManager->createRole("administrator");

        $this->authManager->add($guest);
        $this->authManager->add($chief);
        $this->authManager->add($lawyer);
        $this->authManager->add($administrator);
    }

    public function down()
    {
        if($this->authManager->getRole('guest')) {
            $this->authManager->remove($this->authManager->getRole('guest'));
        }
        if($this->authManager->getRole('chief')) {
            $this->authManager->remove($this->authManager->getRole('chief'));
        }
        if($this->authManager->getRole('lawyer')) {
            $this->authManager->remove($this->authManager->getRole('lawyer'));
        }
        if($this->authManager->getRole('administrator')) {
            $this->authManager->remove($this->authManager->getRole('administrator'));
        }
    }
}
