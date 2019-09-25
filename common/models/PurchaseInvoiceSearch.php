<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseInvoice;

/**
 * PurchaseInvoiceSearch represents the model behind the search form about `common\models\PurchaseInvoice`.
 */
class PurchaseInvoiceSearch extends PurchaseInvoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_invoice_id', 'vendor_id', 'total_amount', 'discount', 'net_total', 'paid_amount', 'remaining_amount', 'created_by', 'updated_by'], 'integer'],
            [['bilty_no', 'purchase_date', 'dispatch_date', 'receiving_date', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = PurchaseInvoice::find();

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
            'purchase_invoice_id' => $this->purchase_invoice_id,
            'vendor_id' => $this->vendor_id,
            'purchase_date' => $this->purchase_date,
            'dispatch_date' => $this->dispatch_date,
            'receiving_date' => $this->receiving_date,
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

        $query->andFilterWhere(['like', 'bilty_no', $this->bilty_no])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
