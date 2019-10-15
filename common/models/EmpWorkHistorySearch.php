<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpWorkHistory;

/**
 * EmpWorkHistorySearch represents the model behind the search form about `common\models\EmpWorkHistory`.
 */
class EmpWorkHistorySearch extends EmpWorkHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_w_h_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['work_from', 'work_to', 'name_of_employeer', 'position_held', 'reason_for_leaving', 'created_at', 'updated_at'], 'safe'],
            [['monthly_gross_salary'], 'number'],
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
        $query = EmpWorkHistory::find();

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
            'emp_w_h_id' => $this->emp_w_h_id,
            'emp_id' => $this->emp_id,
            'work_from' => $this->work_from,
            'work_to' => $this->work_to,
            'monthly_gross_salary' => $this->monthly_gross_salary,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name_of_employeer', $this->name_of_employeer])
            ->andFilterWhere(['like', 'position_held', $this->position_held])
            ->andFilterWhere(['like', 'reason_for_leaving', $this->reason_for_leaving]);

        return $dataProvider;
    }
}
