<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmployeeTypes;

/**
 * EmployeeTypesSearch represents the model behind the search form about `common\models\EmployeeTypes`.
 */
class EmployeeTypesSearch extends EmployeeTypes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_type_id', 'created_by', 'updated_by', 'working_hours'], 'integer'],
            [['emp_type_name', 'description', 'created_at', 'updated_at', 'duty_time_start', 'duty_time_end'], 'safe'],
            [['monthly_salary'], 'number'],
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
        $query = EmployeeTypes::find();

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
            'emp_type_id' => $this->emp_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'working_hours' => $this->working_hours,
            'duty_time_start' => $this->duty_time_start,
            'duty_time_end' => $this->duty_time_end,
            'monthly_salary' => $this->monthly_salary,
        ]);

        $query->andFilterWhere(['like', 'emp_type_name', $this->emp_type_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
