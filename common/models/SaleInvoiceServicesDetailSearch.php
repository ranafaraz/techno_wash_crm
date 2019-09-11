<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SaleInvoiceServicesDetail;

/**
 * SaleInvoiceServicesDetailSearch represents the model behind the search form about `common\models\SaleInvoiceServicesDetail`.
 */
class SaleInvoiceServicesDetailSearch extends SaleInvoiceServicesDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_inv_ser_detail_id', 'sale_inv_head_id', 'services_id', 'discount_per_service', 'created_by', 'updated_by'], 'integer'],
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
        $query = SaleInvoiceServicesDetail::find();

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
            'sale_inv_ser_detail_id' => $this->sale_inv_ser_detail_id,
            'sale_inv_head_id' => $this->sale_inv_head_id,
            'services_id' => $this->services_id,
            'discount_per_service' => $this->discount_per_service,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
