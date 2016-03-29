<?php

namespace app\models;

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
}