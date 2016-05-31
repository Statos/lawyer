<?php

namespace app\models\search;

use app\controllers\NotificationsController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notifications;

/**
 * SearchNotifications represents the model behind the search form about `app\models\Notifications`.
 */
class SearchNotifications extends Notifications
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'is_read'], 'integer'],
            [['message', 'create_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Notifications::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['create_at' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'is_read' => $this->is_read,
            'create_at' => $this->create_at,
        ]);

        if(!Yii::$app->user->can(NotificationsController::PERMISSION_INDEX_ALL)){
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
