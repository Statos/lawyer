<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_attachments".
 *
 * @property integer $id
 * @property string $model_class
 * @property integer $model_id
 * @property string $type
 * @property integer $default
 * @property string $attachment
 * @property string $created
 *
 * @property Insurance $insurance
 * @property Users[] $users
 * @property Work $work
 */
class DataAttachments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_attachments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_class', 'attachment'], 'required'],
            [['model_id', 'default'], 'integer'],
            [['attachment'], 'string'],
            [['created'], 'safe'],
            [['model_class'], 'string', 'max' => 32],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_class' => 'Model Class',
            'model_id' => 'Model ID',
            'type' => 'Type',
            'default' => 'Default',
            'attachment' => 'Attachment',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsurance()
    {
        return $this->hasOne(Insurance::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['avatar_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWork()
    {
        return $this->hasOne(Work::className(), ['id' => 'model_id']);
    }
}
