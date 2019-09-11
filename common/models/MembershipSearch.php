<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Membership;

/**
 * MembershipSearch represents the model behind the search form about `common\models\Membership`.
 */
class MembershipSearch extends Membership
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['membership_id', 'card_type_id', 'customer_id', 'customer_vehicle_id', 'created_by', 'updated_by'], 'integer'],
            [['membership_start_date', 'membership_end_date', 'card_issued_by', 'car_registration_no', 'created_at', 'updated_at'], 'safe'],
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
        $query = Membership::find();

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
            'membership_id' => $this->membership_id,
            'card_type_id' => $this->card_type_id,
            'customer_id' => $this->customer_id,
            'customer_vehicle_id' => $this->customer_vehicle_id,
            'membership_start_date' => $this->membership_start_date,
            'membership_end_date' => $this->membership_end_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'card_issued_by', $this->card_issued_by])
            ->andFilterWhere(['like', 'car_registration_no', $this->car_registration_no]);

        return $dataProvider;
    }
}
