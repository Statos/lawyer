<?php

namespace app\components\traits;

use Exception;

trait PermissionMigration
{
    /** @var  \yii\rbac\ManagerInterface */
    public $authManager;
    public $moduleName;
    public $permissions = [];

    protected $roles;
    protected $rules;

    public function up()
    {
        if (!count($this->permissions)) return;
        foreach ($this->permissions as $controller => $rulesArray) {

            foreach ($rulesArray as $rulesArrayItem) {

                $action = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 0);
                $description = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 1);
                $roles = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 2, []);
                $rules = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 3, []);

                $permissionName = $this->getPermissionName($controller, $action);

                $permission = $this->createOrGetPermission($permissionName, $description);

                if (count($roles)) foreach ($roles as $roleName) {
                    $role = $this->createOrGetRole($roleName);
                    if (!$this->authManager->hasChild($role, $permission)) {
                        $this->authManager->addChild($role, $permission);
                    }
                }

                if (isset($rules) && count($rules) && is_array($rules)) foreach ($rules as $ruleName => $ruleClass) {
                    $rule = $this->createOrGetRule($ruleClass, $ruleName);
                    $rulePermission = $this->createOrGetPermission($ruleName, $rule->description, $ruleName);
                    if (!$this->authManager->hasChild($permission, $rulePermission)) {
                        $this->authManager->addChild($permission, $rulePermission);
                    }
                }
            }
        }
    }

    public function down()
    {
        if (!count($this->permissions)) return;

        foreach ($this->permissions as $controller  => $rulesArray) {
            foreach ($rulesArray as $rulesArrayItem) {

                $action = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 0, []);
//        $description = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 1);
//        $roles = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 2);
                $rules = \yii\helpers\ArrayHelper::getValue($rulesArrayItem, 3, []);

                $permissionName = $this->getPermissionName($controller, $action);
                if ($permission = $this->authManager->getPermission($permissionName)) {
                    $this->authManager->remove($permission);
                }

                if (count($rules)) foreach ($rules as $ruleName) {
                    if ($rule = $this->authManager->getRule($ruleName)) {
                        $this->authManager->remove($rule);
                    }
                }
            }
        }
    }

    private function createOrGetRole($roleName)
    {
        if ($role = \yii\helpers\ArrayHelper::getValue($this->roles, $roleName)) {
            return $role;
        }

        if ($role = $this->authManager->getRole($roleName)) {
            $this->roles[$roleName] = $role;
            return $role;
        }

        throw new Exception('Invalid role name');
    }

    private function createOrGetRule($ruleClass, $ruleName)
    {
        if ($rule = \yii\helpers\ArrayHelper::getValue($this->rules, $ruleName)) {
            return $rule;
        }

        $ruleClass = new $ruleClass;
        $ruleName = $ruleClass->name;
        if ($rule = $this->authManager->getRule($ruleName)) {
            $this->rules[$ruleName] = $rule;
            return $rule;
        }

        if ($ruleClass instanceof \yii\rbac\Rule) {
            $this->authManager->add($ruleClass);
            $this->rules[$ruleName] = $ruleClass;

            return $ruleClass;
        }

        throw new Exception('Invalid rule name');
    }

    private function createOrGetPermission($permissionName, $permissionDescription, $ruleName = null)
    {
        $permission = $this->authManager->getPermission($permissionName);
        if (!$permission) {
            $permission = $this->authManager->createPermission($permissionName);
            $permission->description = $permissionDescription;
            $permission->ruleName = $ruleName;

            $this->authManager->add($permission);
        }

        return $permission;
    }

    private function getPermissionName($controller, $action)
    {
        return \yii\helpers\BaseInflector::camelize(sprintf('%s_%s_%s', $this->moduleName, $controller, $action));
    }
}