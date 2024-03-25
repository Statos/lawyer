<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $message
 * @property integer $is_read
 * @property string $create_at
 *
 * @property User $user
 */
class Notifications extends \yii\db\ActiveRecord
{
    const READ_YES = 1;
    const READ_NO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id', 'is_read'], 'integer'],
            [['message'], 'string'],
            [['create_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'userName' => 'Пользователь',
            'message' => 'Сообщение',
            'is_read' => 'Прочитано',
            'readIcon' => 'Прочитано',
            'create_at' => 'Дата создания',
        ];
    }

    public function getReadStatuses()
    {
        return [
            self::READ_NO => 'Не прочитано',
            self::READ_YES => 'Прочитано',
        ];
    }

    public function getReadIcon()
    {
        return \yii\bootstrap\Html::icon($this->is_read ? 'ok' : 'remove');
    }

    public function setReaded()
    {
        $this->is_read = self::READ_YES;
        $this->update(false, ['is_read']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserName()
    {
        return $this->user->username;
    }

    public static function sendNotify($user_id, $message)
    {
        $model = new Notifications();
        $model->user_id = $user_id;
        $model->message = $message;
        return $model->save();
    }

    public static function getCountUnreadNotify($user_id)
    {
        return self::find()->where(['user_id' => $user_id, 'is_read' => self::READ_NO])->count();
    }
}
