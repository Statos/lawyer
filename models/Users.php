<?php

namespace app\models;

use Exception;
use Yii;
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
 * @property DataAttachments $avatar
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $repeat_password;
    public $password;
    public $set_auth = true;

    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    const ROLE_CHIEF = 'chief';
    const ROLE_LAWYER = 'lawyer';
    const ROLE_ADMINISTRATOR = 'administrator';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'phone', 'fio'], 'required'],
            [['status', 'fio'], 'string'],
            [['avatar_id'], 'integer'],
            [['create_at', 'online_at'], 'safe'],
            [['username', 'password', 'email', 'phone'], 'string', 'max' => 64],
            [['avatar_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataAttachments::className(), 'targetAttribute' => ['avatar_id' => 'id']],
        ];
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

    public function beforeSave($insert)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->set_auth) {
            $authManager = Yii::$app->authManager;
            $authRole = $authManager->getRole('user');
            if (!$authManager->assign($authRole, $this->id)) {
                //todo logs
            }
        }
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new Exception('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataComments()
    {
        return $this->hasMany(DataComments::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsurances()
    {
        return $this->hasMany(Insurance::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(DataAttachments::className(), ['id' => 'avatar_id']);
    }

    public static function getDropdownList()
    {
        $users = self::find()
            ->innerJoin('auth_assignment', self::tableName() . '.id = ' . 'auth_assignment.user_id')
            ->where(['status' => [self::STATUS_NEW, self::STATUS_ACTIVE]])
            ->andWhere(['auth_assignment.item_name' => [self::ROLE_CHIEF]])
            ->all();
        return ArrayHelper::map($users, 'id', 'username');
    }
}
