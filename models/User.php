<?php

namespace app\models;

use app\components\events\EventUserBlock;
use app\components\events\EventUserDelete;
use app\modules\upload\models\Attachments;
use Exception;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $status
 * @property integer $avatar_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $fio
 * @property string $create_at
 * @property string $online_at
 *
 * @property DataComments[] $dataComments
 * @property Insurance[] $insurances
 * @property Attachments $avatar
 */
class User extends \mdm\admin\models\User
{
    public $repeat_password;
    public $password;
    public $set_auth = false;

    const STATUS_NEW = 1;

    const ROLE_CHIEF = 'chief';
    const ROLE_LAWYER = 'lawyer';
    const ROLE_ADMINISTRATOR = 'administrator';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'fio'], 'required', 'on' => 'default'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['phone', 'fio'], 'required', 'on' => 'profile'],
            [['password'], 'required', 'on' => 'create'],
            [['fio'], 'string'],
            ['status', 'in', 'range' => array_keys(self::getStatuses())],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            ['username', 'unique', 'message' => 'Данный логин уже занят'],
            ['email', 'unique', 'message' => 'Данный email уже зарегистрирован'],
            ['email', 'email'],
            [['avatar_id'], 'integer'],
            [['create_at', 'online_at'], 'safe'],
            [['username', 'password', 'email', 'phone'], 'string', 'max' => 64],
            [['avatar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attachments::class, 'targetAttribute' => ['avatar_id' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->set_auth) {
            $authManager = Yii::$app->authManager;
            $authRole = $authManager->getRole(self::ROLE_LAWYER);
            if (!$authManager->assign($authRole, $this->id)) {
                //todo logs
            }
        }
        if (!$this->isNewRecord && $this->status == self::STATUS_INACTIVE) {
            (new EventUserBlock($this->id, $this->username))->trigger();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
            'avatar_id' => 'Аватар',
            'username' => 'Login',
            'password' => 'Пароль',
            'repeat_password' => 'Повторите пароль',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'fio' => 'ФИО',
            'create_at' => 'Дата регистрации',
            'online_at' => 'Последний онлайн',
        ];
    }

    public function updateOnline()
    {
        $this->online_at = new Expression('NOW()');
        $this->update(false, ['online_at']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataComments()
    {
        return $this->hasMany(DataComments::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsurances()
    {
        return $this->hasMany(Insurance::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(Attachments::class, ['id' => 'avatar_id']);
    }

    public function getAvatarUrl()
    {
        return $this->avatar ? $this->avatar->getTitleUrl() : '/images/avatar.png';
    }

    public static function getRoles()
    {
        return [
            self::ROLE_LAWYER => self::ROLE_LAWYER,
            self::ROLE_CHIEF => self::ROLE_CHIEF,
            self::ROLE_ADMINISTRATOR => self::ROLE_ADMINISTRATOR,
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_INACTIVE => 'Заблокирован',
            self::STATUS_NEW => 'Новый',
            self::STATUS_ACTIVE => 'Активный',
        ];
    }

    public function getStatusName()
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public static function getListByRoles($roles = [])
    {
        $roles = array_intersect($roles, array_values(self::getRoles()));
        $users = self::find()
            ->innerJoin('auth_assignment', self::tableName() . '.id = ' . 'auth_assignment.user_id')
            ->where(['status' => [self::STATUS_NEW, self::STATUS_ACTIVE]])
            ->andWhere(['auth_assignment.item_name' => $roles]);
        return ArrayHelper::map($users->all(), 'id', 'username');
    }

    public static function getListAll()
    {
        return self::getListByRoles(array_values(self::getRoles()));
    }
}
