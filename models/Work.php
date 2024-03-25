<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "work".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property integer $insurance_id
 * @property string $create_at
 * @property string $done_at
 * @property string $max_at
 *
 * @property Insurance $insurance
 */
class Work extends \yii\db\ActiveRecord
{
    public $date_diff;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['insurance_id'], 'integer'],
            [['create_at', 'done_at', 'max_at'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['insurance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Insurance::className(), 'targetAttribute' => ['insurance_id' => 'id']],
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
            'name' => 'Заголовок',
            'description' => 'Описание',
            'insurance_id' => 'Страховой случай',
            'create_at' => 'Дата создания',
            'done_at' => 'Дата выполнения',
            'max_at' => 'Назначено до',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsurance()
    {
        return $this->hasOne(Insurance::className(), ['id' => 'insurance_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUserName()
    {
        return $this->user ? $this->user->username : false;
    }

    public function isDone()
    {
        return !!$this->done_at;
    }

    public function getInsuranceList()
    {
        $data = Insurance::find()->where(['user_id' => $this->user_id]);
        return ArrayHelper::map($data->all(), 'id', 'name');
    }
}
