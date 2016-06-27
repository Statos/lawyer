<?php

namespace app\modules\comments\models;

use app\models\Users;
use app\modules\upload\models\Attachments;
use Yii;

/**
 * This is the model class for table "data_comments".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $model_class
 * @property integer $model_id
 * @property string $created
 * @property integer $ctype
 * @property integer $state
 * @property string $title
 * @property string $txt
 * @property string $attachment
 * @property integer $likes
 * @property integer $user_id
 */
class Comments extends \yii\db\ActiveRecord
{
    const CTYPE_POSITIVE = 0;
    const CTYPE_NEGATIVE = 1;
    const CTYPE_NEUTRAL = 2;

    /**
     * @inheritdoc
     */
    public $children;

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
            [['pid', 'model_id', 'ctype', 'state', 'likes', 'user_id'], 'integer'],
            [['model_class', 'model_id', 'txt', 'user_id'], 'required', 'message'=>'Заполните поле'],
            [['created'], 'safe'],
            [['title', 'txt'], 'string'],
            [['model_class'], 'string', 'max' => 32],
            [['attachment'], 'string', 'max' => 256]
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
            'ctype' => 'Ctype',
            'state' => 'State',
            'title' => 'Title',
            'txt' => 'Txt',
            'attachment' => 'Attachment',
            'likes' => 'Likes',
            'user_id' => 'User ID',
        ];
    }

    public static function getCtypes()
    {
        return [
            self::CTYPE_POSITIVE => 'Положительный',
            self::CTYPE_NEGATIVE => 'Отрицательный',
            self::CTYPE_NEUTRAL  => 'Нейтральный',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getDate()
    {
        setlocale(LC_ALL, 'rus');
        setlocale(LC_ALL, 'ru_RU.UTF8');
        $x = $this->created;
        $x = strtotime($x);
        $x = strftime('%e %B %Y | %H:%M', $x);
        return $x;
    }

    public function getLogin()
    {
        $u = $this->author;
        return $u ? $u->username : '';
    }

    public function getAttach()
    {
        $a = array_filter(explode(',', $this->attachment));
        if( $a )
            return Attachments::find()
                ->where(['id'=>$a])
                ->all();
        return array();

    }

    public function getAuthorPhoto()
    {
        $u = $this->author;
        return $u->getAvatarUrl();
    }

    public static function getTree($id, $class, $counter = true)
    {
        $models = self::find()->where([
            'model_id' => $id,
            'model_class' => $class
        ])->orderBy(['created' => SORT_DESC])->with(['author'])->all();
        $countCtype = NULL;
        if($counter)
            $countCtype = self::getCountCtype($models);
        if ($models !== null) {
            $models = self::buildTree($models);
        }
        return [$models, $countCtype];
    }

    protected static function buildTree(&$data, $rootID = 0)
    {
        $tree = [];
        foreach ($data as $id => $node) {
            if ($node->pid == $rootID) {
                unset($data[$id]);
                $node->children = self::buildTree($data, $node->id);
                $tree[] = $node;
            }
        }
        return $tree;
    }

    public static function getCountCtype($models = array())
    {
        $data = [0, 0, 0];
        foreach($models as $model)
            $data[$model->ctype] += 1;
        return $data;
    }
}
