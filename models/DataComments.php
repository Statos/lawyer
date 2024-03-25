<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_comments".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $model_class
 * @property integer $model_id
 * @property string $created
 * @property integer $state
 * @property string $title
 * @property string $txt
 * @property string $attachment
 * @property integer $likes
 * @property integer $user_id
 *
 * @property User $user
 */
class DataComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'model_id', 'state', 'likes', 'user_id'], 'integer'],
            [['model_class', 'model_id', 'txt', 'user_id'], 'required'],
            [['created'], 'safe'],
            [['title', 'txt'], 'string'],
            [['model_class'], 'string', 'max' => 32],
            [['attachment'], 'string', 'max' => 256],
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
            'pid' => 'Pid',
            'model_class' => 'Model Class',
            'model_id' => 'Model ID',
            'created' => 'Created',
            'state' => 'State',
            'title' => 'Title',
            'txt' => 'Txt',
            'attachment' => 'Attachment',
            'likes' => 'Likes',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
