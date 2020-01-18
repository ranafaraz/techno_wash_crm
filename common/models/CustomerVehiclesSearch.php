<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerVehicles;

/**
 * CustomerVehiclesSearch represents the model behind the search form about `common\models\CustomerVehicles`.
 */
class CustomerVehiclesSearch extends CustomerVehicles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_vehicle_id','created_by', 'updated_by'], 'integer'],
            [['customer_id', 'vehicle_typ_sub_id', 'registration_no', 'color', 'image', 'created_at', 'updated_at'], 'safe'],
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
        $query = CustomerVehicles::find()->orderBy(['customer_id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('customer');
        $query->joinWith('vehicleTypSub');

        $query->andFilterWhere([
            'customer_vehicle_id' => $this->customer_vehicle_id,
            //'customer_id' => $this->customer_id,
            //'vehicle_typ_sub_id' => $this->vehicle_typ_sub_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'registration_no', $this->registration_no])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'customer.customer_contact_no', $this->customer_id])
            ->andFilterWhere(['like', 'vehicleTypSub.name', $this->vehicle_typ_sub_id]);

        return $dataProvider;
    }
}
