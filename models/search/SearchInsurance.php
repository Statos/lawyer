<?php

namespace app\models\search;

use app\controllers\InsuranceController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Insurance;

/**
 * SearchInsurance represents the model behind the search form about `app\models\Insurance`.
 */
class SearchInsurance extends Insurance
{
    public $start_max;
    public $end_max;

    public $start_create;
    public $end_create;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['name', 'description'], 'safe'],
            [['start_create', 'end_create', 'start_max', 'end_max'], 'safe'],
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
        $query = Insurance::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        ]);

        $query->andFilterWhere(['>', 'max_at', $this->start_max]);
        $query->andFilterWhere(['<', 'max_at', $this->end_max]);

        $query->andFilterWhere(['>', 'create_at', $this->start_create]);
        $query->andFilterWhere(['<', 'create_at', $this->end_create]);

        if(!Yii::$app->user->can(InsuranceController::PERMISSION_UPDATE_ALL)){
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);



        return $dataProvider;
    }
}
