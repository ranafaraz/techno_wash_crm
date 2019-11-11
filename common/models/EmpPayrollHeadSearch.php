<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpPayrollHead;

/**
 * EmpPayrollHeadSearch represents the model behind the search form about `common\models\EmpPayrollHead`.
 */
class EmpPayrollHeadSearch extends EmpPayrollHead
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payroll_head_id', 'branch_id', 'emp_id', 'over_time', 'created_by', 'updated_by'], 'integer'],
            [['payment_month', 'status', 'created_at', 'updated_at'], 'safe'],
            [['total_calculated_pay', 'over_time_pay', 'bonus', 'tax_deduction', 'relaxation', 'net_total', 'paid_amount', 'remaining'], 'number'],
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
        $query = EmpPayrollHead::find();

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
            'payroll_head_id' => $this->payroll_head_id,
            'branch_id' => $this->branch_id,
            'emp_id' => $this->emp_id,
            'total_calculated_pay' => $this->total_calculated_pay,
            'over_time' => $this->over_time,
            'over_time_pay' => $this->over_time_pay,
            'bonus' => $this->bonus,
            'tax_deduction' => $this->tax_deduction,
            'relaxation' => $this->relaxation,
            'net_total' => $this->net_total,
            'paid_amount' => $this->paid_amount,
            'remaining' => $this->remaining,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'payment_month', $this->payment_month])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
