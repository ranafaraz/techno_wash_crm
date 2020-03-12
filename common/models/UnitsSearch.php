<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Units;

/**
 * UnitsSearch represents the model behind the search form about `common\models\Units`.
 */
class UnitsSearch extends Units
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'created_by', 'updated_by'], 'integer'],
            [['unit_name', 'unit_description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Units::find();

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
            'unit_id' => $this->unit_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'unit_name', $this->unit_name])
            ->andFilterWhere(['like', 'unit_description', $this->unit_description]);

        return $dataProvider;
    }
}
