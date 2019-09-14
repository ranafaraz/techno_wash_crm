<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WageType;

/**
 * WageTypeSearch represents the model behind the search form about `common\models\WageType`.
 */
class WageTypeSearch extends WageType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wage_type_id', 'basic_pay', 'created_by', 'updated_by'], 'integer'],
            [['wage_name', 'created_at', 'updated_at','branch_id'], 'safe'],
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
        $query = WageType::find();

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
            'wage_type_id' => $this->wage_type_id,
            //'branch_id' => $this->branch_id,
            'basic_pay' => $this->basic_pay,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'wage_name', $this->wage_name])
        ->andFilterWhere(['like', 'branches.branch_name', $this->branch_id]);;

        return $dataProvider;
    }
}
