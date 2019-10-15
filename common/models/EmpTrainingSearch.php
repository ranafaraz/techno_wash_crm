<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpTraining;

/**
 * EmpTrainingSearch represents the model behind the search form about `common\models\EmpTraining`.
 */
class EmpTrainingSearch extends EmpTraining
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_trainind_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['train_from_date', 'train_to_date', 'training_course', 'training_institute', 'training_certificate', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpTraining::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'emp_trainind_id' => $this->emp_trainind_id,
            'emp_id' => $this->emp_id,
            'train_from_date' => $this->train_from_date,
            'train_to_date' => $this->train_to_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'training_course', $this->training_course])
            ->andFilterWhere(['like', 'training_institute', $this->training_institute])
            ->andFilterWhere(['like', 'training_certificate', $this->training_certificate]);

        return $dataProvider;
    }
}
