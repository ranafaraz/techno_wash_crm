<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpGrossSalary;

/**
 * EmpGrossSalarySearch represents the model behind the search form about `common\models\EmpGrossSalary`.
 */
class EmpGrossSalarySearch extends EmpGrossSalary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_gro_sal_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['gross_salary', 'bonus'], 'number'],
            [['car', 'car_fuel', 'car_maintenance', 'retirement_benefits', 'others', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpGrossSalary::find();

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
            'emp_gro_sal_id' => $this->emp_gro_sal_id,
            'emp_id' => $this->emp_id,
            'gross_salary' => $this->gross_salary,
            'bonus' => $this->bonus,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'car', $this->car])
            ->andFilterWhere(['like', 'car_fuel', $this->car_fuel])
            ->andFilterWhere(['like', 'car_maintenance', $this->car_maintenance])
            ->andFilterWhere(['like', 'retirement_benefits', $this->retirement_benefits])
            ->andFilterWhere(['like', 'others', $this->others]);

        return $dataProvider;
    }
}
