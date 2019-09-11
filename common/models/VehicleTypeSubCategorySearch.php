<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VehicleTypeSubCategory;

/**
 * VehicleTypeSubCategorySearch represents the model behind the search form about `common\models\VehicleTypeSubCategory`.
 */
class VehicleTypeSubCategorySearch extends VehicleTypeSubCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicle_typ_sub_id', 'vehicle_type_id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'manufacture', 'created_at', 'updated_at'], 'safe'],
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
        $query = VehicleTypeSubCategory::find();

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
            'vehicle_typ_sub_id' => $this->vehicle_typ_sub_id,
            'vehicle_type_id' => $this->vehicle_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'manufacture', $this->manufacture]);

        return $dataProvider;
    }
}
