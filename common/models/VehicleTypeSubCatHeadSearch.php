<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VehicleTypeSubCatHead;

/**
 * VehicleTypeSubCatHeadSearch represents the model behind the search form about `common\models\VehicleTypeSubCatHead`.
 */
class VehicleTypeSubCatHeadSearch extends VehicleTypeSubCatHead
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_cat_head_id', 'vehicle_type_id', 'manufacture', 'created_by', 'updated_by'], 'integer'],
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
        $query = VehicleTypeSubCatHead::find();

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
            'sub_cat_head_id' => $this->sub_cat_head_id,
            'vehicle_type_id' => $this->vehicle_type_id,
            'manufacture' => $this->manufacture,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
