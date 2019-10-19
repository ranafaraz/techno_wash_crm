<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceDetails;

/**
 * ServiceDetailsSearch represents the model behind the search form about `common\models\ServiceDetails`.
 */
class ServiceDetailsSearch extends ServiceDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_detail_id', 'branch_id', 'vehicle_type_id', 'service_id', 'price', 'created_by', 'updated_by'], 'integer'],
            [['description', 'created_at', 'updated_at'], 'safe'],
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
        $query = ServiceDetails::find();

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
            'service_detail_id' => $this->service_detail_id,
            'branch_id' => $this->branch_id,
            'vehicle_type_id' => $this->vehicle_type_id,
            'service_id' => $this->service_id,
            'price' => $this->price,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
