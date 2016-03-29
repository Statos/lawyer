<?php

namespace app\modules\upload\models;

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
 * @property DataUsers[] $dataUsers
 */
class Attachments extends \yii\db\ActiveRecord
{
    const TYPE_IMAGES = 'image';
    const TYPE_DOCUMENTS = 'application';
    const TYPE_VIDEO = 'video';

    const REGEX_IMAGE = 'gif|jpe?g|png';
    const REGEX_DOCUMENT = 'docx?|xlsx?|txt|rtf|pdf';
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
            //[['attachment'], 'string'], //@TODO before validate or test object
            [['attachment'], 'safe'],
            [['created'], 'safe'],
            [['model_class'], 'string', 'max' => 20],
            [['type'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_class' => 'Belong To',
            'model_id' => 'Belong ID',
            'type' => 'Type',
            'default' => 'Default',
            'attachment' => 'Attachment',
            'created' => 'Created',
        ];
    }

    public function beforeSave($insert)
    {
        $this->attachment = json_encode($this->attachment);
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->attachment = json_decode($this->attachment);
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        $this->attachment = json_decode($this->attachment);
        return parent::afterFind();
    }

    public static function preRegex($types)
    {
        return '/\.(' . $types . ')$/i';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataUsers()
    {
        return $this->hasMany(DataUsers::className(), ['avatar_id' => 'id']);
    }

    public function toHash(){
        return [
            'id' => $this->id,
            'attachment' => $this->attachment,
        ];
    }

    public function getUrl()
    {
        return isset($this->attachment->url) ? $this->attachment->url : '';
    }

    public function getThumbUrl()
    {
        return isset($this->attachment->thumbUrl) ? $this->attachment->thumbUrl : $this->getUrl();
    }

    public function getTitleUrl()
    {
        return isset($this->attachment->titleUrl) ? $this->attachment->titleUrl : $this->getUrl();
    }

    public function getFancyImg()
    {
        $data = '<a class="zoom noajax" rel="zoom" href="'.$this->getUrl().'">';
        $data .= '<img class="many-pic" src="'.$this->getThumbUrl().'"/>';
        $data .= '</a>';
        return $data;
    }

    public function getMimeType($id = NULL)
    {
        $data = explode('/',$this->attachment->type);
        if($id !== NULL)
            return isset($data[$id]) ? $data[$id] : false;
        return $data;
    }

    public function typeImages()
    {
        if($this->type)
            return $this->type == self::TYPE_IMAGES;
        return preg_match('/(' . self::REGEX_IMAGE . ')/i', $this->getMimeType(1));
    }
    public function typeDocuments()
    {
        if($this->type)
            return $this->type == self::TYPE_DOCUMENTS;
        return preg_match('/(' . self::TYPE_DOCUMENTS . ')/i', $this->getMimeType(1));
    }
    public function typeVideo()
    {
        return $this->type == self::TYPE_VIDEO;
    }

	//Получение приложений по id и классу модели
    public static function getModelAttachment(yii\base\Model $model)
    {
        if($model->id === NULL)
            return [];
        return Attachments::find()->where([
            'model_class'=>\yii\helpers\StringHelper::basename(get_class($model)),
            'model_id'=>$model->id
        ])->all();
    }

	//Получение приложения по аттрибуту модели, аттрибут int
    public static function getAttributeAttachment($id)
    {
        if($id === NULL)
            return false;
        return Attachments::find()->where([
            'id'=>$id
        ])->one();
    }
	
	//Получение приложений по аттрибуту модели, аттрибут строковый цифры через зяпятую
	public static function getAttributeAttachments($ids)
    {
        if($ids === NULL)
            return false;
		if(!is_array($ids))
			$ids = explode(',', $ids);
        return Attachments::find()->where([
            'id'=>$ids
        ])->all();
    }

}