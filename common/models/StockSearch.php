<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Stock;

/**
 * StockSearch represents the model behind the search form about `common\models\Stock`.
 */
class StockSearch extends Stock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
<<<<<<< HEAD
            [['stock_id', 'purchase_price', 'selling_price', 'created_by', 'updated_by'], 'integer'],
            [['barcode', 'name', 'expiry_date', 'status', 'created_at', 'updated_at', 'branch_id', 'stock_type_id', 'purchase_invoice_id', 'manufacture_id'], 'safe'],
=======
            [['stock_id', 'stock_type_id', 'purchase_invoice_id', 'manufacture_id', 'original_price', 'purchase_price', 'selling_price', 'created_by', 'updated_by'], 'integer'],
            [['barcode', 'name', 'expiry_date', 'status', 'created_at', 'updated_at'], 'safe'],
>>>>>>> 9c471f1b28fb96071504970840ecaec5a3229ff3
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
        $query = Stock::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('branch');
        $query->joinWith('stockType');
        $query->joinWith('manufacture');

        $query->andFilterWhere([
            'stock_id' => $this->stock_id,
<<<<<<< HEAD
            //'branch_id' => $this->branch_id,
            //'stock_type_id' => $this->stock_type_id,
=======
            'stock_type_id' => $this->stock_type_id,
>>>>>>> 9c471f1b28fb96071504970840ecaec5a3229ff3
            'purchase_invoice_id' => $this->purchase_invoice_id,
            //'manufacture_id' => $this->manufacture_id,
            'expiry_date' => $this->expiry_date,
            'original_price' => $this->original_price,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'manufacture.name', $this->manufacture_id])
            ->andFilterWhere(['like', 'stock_type.name', $this->stock_type_id])
            ->andFilterWhere(['like', 'branches.branch_name', $this->branch_id]);
        return $dataProvider;
    }
}
