<?php

namespace app\models;

use app\components\events\EventLaw;
use app\modules\upload\models\Attachments;
use Yii;

/**
 * This is the model class for table "law".
 *
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $description
 * @property string $create_at
 */
class Law extends \yii\db\ActiveRecord
{
    public $attach;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'law';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'name', 'description', 'publicate_at'], 'required'],
            [['number', 'name', 'description'], 'string'],
            [['create_at'], 'safe'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        (new EventLaw($insert, $this->id, $this->name))->trigger();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер',
            'name' => 'Имя',
            'description' => 'Описание',
            'publicate_at' => 'Дата издания',
            'create_at' => 'Дата создания',
        ];
    }

    public function getSmallDescription()
    {
        return strlen($this->description) > 500 ? substr($this->description, 0, 500) . '...' : $this->description;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::className(), [
            'model_id' => 'id',
            'model_class' => \yii\helpers\StringHelper::basename($this->className())
        ]);
    }
}
