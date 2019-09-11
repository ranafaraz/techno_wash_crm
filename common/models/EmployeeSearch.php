<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form about `common\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_id', 'emp_type_id', 'branch_id', 'salary_id', 'emp_contact', 'created_by', 'updated_by'], 'integer'],
            [['emp_name', 'emp_cnic', 'emp_father_name', 'emp_email', 'emp_image', 'emp_gender', 'emp_qualification', 'emp_reference', 'joining_date', 'learning_date', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = Employee::find();

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
            'emp_id' => $this->emp_id,
            'emp_type_id' => $this->emp_type_id,
            'branch_id' => $this->branch_id,
            'salary_id' => $this->salary_id,
            'emp_contact' => $this->emp_contact,
            'joining_date' => $this->joining_date,
            'learning_date' => $this->learning_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'emp_cnic', $this->emp_cnic])
            ->andFilterWhere(['like', 'emp_father_name', $this->emp_father_name])
            ->andFilterWhere(['like', 'emp_email', $this->emp_email])
            ->andFilterWhere(['like', 'emp_image', $this->emp_image])
            ->andFilterWhere(['like', 'emp_gender', $this->emp_gender])
            ->andFilterWhere(['like', 'emp_qualification', $this->emp_qualification])
            ->andFilterWhere(['like', 'emp_reference', $this->emp_reference])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
