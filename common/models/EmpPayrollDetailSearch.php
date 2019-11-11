<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpPayrollDetail;

/**
 * EmpPayrollDetailSearch represents the model behind the search form about `common\models\EmpPayrollDetail`.
 */
class EmpPayrollDetailSearch extends EmpPayrollDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payroll_detail_id', 'payroll_head_id', 'created_by', 'updated_by'], 'integer'],
            [['transaction_date', 'status', 'created_at', 'updated_at'], 'safe'],
            [['paid_amount'], 'number'],
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
        $query = EmpPayrollDetail::find();

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
            'payroll_detail_id' => $this->payroll_detail_id,
            'payroll_head_id' => $this->payroll_head_id,
            'transaction_date' => $this->transaction_date,
            'paid_amount' => $this->paid_amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
