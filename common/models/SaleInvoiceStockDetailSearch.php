<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SaleInvoiceStockDetail;

/**
 * SaleInvoiceStockDetailSearch represents the model behind the search form about `common\models\SaleInvoiceStockDetail`.
 */
class SaleInvoiceStockDetailSearch extends SaleInvoiceStockDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_inv_stock_detail_id', 'sale_inv_head_id', 'stock_id', 'discount_per_item', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = SaleInvoiceStockDetail::find();

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
            'sale_inv_stock_detail_id' => $this->sale_inv_stock_detail_id,
            'sale_inv_head_id' => $this->sale_inv_head_id,
            'stock_id' => $this->stock_id,
            'discount_per_item' => $this->discount_per_item,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
