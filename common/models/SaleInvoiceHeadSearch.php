<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SaleInvoiceHead;

/**
 * SaleInvoiceHeadSearch represents the model behind the search form about `common\models\SaleInvoiceHead`.
 */
class SaleInvoiceHeadSearch extends SaleInvoiceHead
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_inv_head_id', 'customer_id', 'total_amount', 'discount', 'net_total', 'paid_amount', 'remaining_amount', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
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
        $query = SaleInvoiceHead::find();

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
            'sale_inv_head_id' => $this->sale_inv_head_id,
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'net_total' => $this->net_total,
            'paid_amount' => $this->paid_amount,
            'remaining_amount' => $this->remaining_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
