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
            [['emp_id', 'emp_type_id', 'branch_id', 'created_by', 'updated_by'], 'integer'],
            [['salary_id'], 'number'],
            [['emp_name', 'emp_father_name', 'emp_father_position', 'emp_cnic', 'emp_contact', 'emp_emergency_contact', 'emp_emergency_contact_relation', 'emp_email', 'emp_image', 'emp_gender', 'emp_marital_status', 'emp_dob', 'emp_birth_place', 'emp_religion', 'emp_blood_group', 'emp_nationality', 'emp_passport_no', 'passport_expiry_date', 'emp_residence', 'emp_present_address', 'emp_permanent_address', 'emp_joining_date', 'emp_learning_date', 'emp_status', 'created_at', 'updated_at'], 'safe'],
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
            'emp_dob' => $this->emp_dob,
            'passport_expiry_date' => $this->passport_expiry_date,
            'emp_joining_date' => $this->emp_joining_date,
            'emp_learning_date' => $this->emp_learning_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'emp_father_name', $this->emp_father_name])
            ->andFilterWhere(['like', 'emp_father_position', $this->emp_father_position])
            ->andFilterWhere(['like', 'emp_cnic', $this->emp_cnic])
            ->andFilterWhere(['like', 'emp_contact', $this->emp_contact])
            ->andFilterWhere(['like', 'emp_emergency_contact', $this->emp_emergency_contact])
            ->andFilterWhere(['like', 'emp_emergency_contact_relation', $this->emp_emergency_contact_relation])
            ->andFilterWhere(['like', 'emp_email', $this->emp_email])
            ->andFilterWhere(['like', 'emp_image', $this->emp_image])
            ->andFilterWhere(['like', 'emp_gender', $this->emp_gender])
            ->andFilterWhere(['like', 'emp_marital_status', $this->emp_marital_status])
            ->andFilterWhere(['like', 'emp_birth_place', $this->emp_birth_place])
            ->andFilterWhere(['like', 'emp_religion', $this->emp_religion])
            ->andFilterWhere(['like', 'emp_blood_group', $this->emp_blood_group])
            ->andFilterWhere(['like', 'emp_nationality', $this->emp_nationality])
            ->andFilterWhere(['like', 'emp_passport_no', $this->emp_passport_no])
            ->andFilterWhere(['like', 'emp_residence', $this->emp_residence])
            ->andFilterWhere(['like', 'emp_present_address', $this->emp_present_address])
            ->andFilterWhere(['like', 'emp_permanent_address', $this->emp_permanent_address])
            ->andFilterWhere(['like', 'emp_status', $this->emp_status]);

        return $dataProvider;
    }
}
