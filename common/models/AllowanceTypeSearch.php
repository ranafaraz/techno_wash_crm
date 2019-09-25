<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AllowanceType;

/**
 * AllowanceTypeSearch represents the model behind the search form about `common\models\AllowanceType`.
 */
class AllowanceTypeSearch extends AllowanceType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allowance_type_id', 'amount', 'created_by', 'updated_by'], 'integer'],
            [['allowance_name', 'created_at', 'updated_at', 'branch_id'], 'safe'],
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
        $query = AllowanceType::find();

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
            'allowance_type_id' => $this->allowance_type_id,
            //'branch_id' => $this->branch_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'allowance_name', $this->allowance_name])
        ->andFilterWhere(['like', 'branches.branch_name', $this->branch_id]);

        return $dataProvider;
    }
}
