<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AccountPayable;

/**
 * AccountPayableSearch represents the model behind the search form about `common\models\AccountPayable`.
 */
class AccountPayableSearch extends AccountPayable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['due_date', 'narration', 'created_at', 'updated_at', 'status','account_payable'], 'safe'],
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
        $query = AccountPayable::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('accountPayable');
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]); 
        $query->andFilterWhere(['like', 'narration', $this->narration])
        ->andFilterWhere(['like', 'account_name', $this->account_payable])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
