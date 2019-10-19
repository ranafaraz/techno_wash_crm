<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `common\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'customer_age', 'created_by', 'updated_by'], 'integer'],
            [['customer_name', 'customer_gender', 'customer_cnic', 'customer_address', 'customer_contact_no', 'customer_registration_date', 'customer_email', 'customer_image', 'customer_occupation', 'updated_at', 'created_at', 'branch_id'], 'safe'],
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
        $query = Customer::find()->orderBy(['customer_id' => SORT_DESC]);

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

        $query->andFilterWhere([
            'customer_id' => $this->customer_id,
            //'branch_id' => $this->branch_id,
            'customer_registration_date' => $this->customer_registration_date,
            'customer_age' => $this->customer_age,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_gender', $this->customer_gender])
            ->andFilterWhere(['like', 'customer_cnic', $this->customer_cnic])
            ->andFilterWhere(['like', 'customer_address', $this->customer_address])
            ->andFilterWhere(['like', 'customer_contact_no', $this->customer_contact_no])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'customer_image', $this->customer_image])
            ->andFilterWhere(['like', 'customer_occupation', $this->customer_occupation])
             ->andFilterWhere(['like', 'branches.branch_name', $this->branch_id]);

        return $dataProvider;
    }
}
