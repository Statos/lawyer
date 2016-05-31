<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $insurance_id
 * @property string $create_at
 * @property string $done_at
 * @property string $max_at
 *
 * @property Insurance $insurance
 * @property DataAttachments $id0
 */
class Work extends \yii\db\ActiveRecord
{
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
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => DataAttachments::className(), 'targetAttribute' => ['id' => 'model_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
    public function getAttachments()
    {
        return $this->hasOne(DataAttachments::className(), ['model_id' => 'id']);
    }
}
