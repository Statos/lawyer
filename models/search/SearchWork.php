<?php

namespace app\models\search;

use app\controllers\WorkController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Work;

/**
 * SearchWork represents the model behind the search form about `app\models\Work`.
 */
class SearchWork extends Work
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'insurance_id', 'user_id'], 'integer'],
            [['name', 'description', 'create_at', 'done_at', 'max_at'], 'safe'],
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
        $query = Work::find();

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
            'insurance_id' => $this->insurance_id,
            'create_at' => $this->create_at,
            'done_at' => $this->done_at,
            'max_at' => $this->max_at,
        ]);

        if(!Yii::$app->user->can(WorkController::PERMISSION_UPDATE_ALL)){
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
