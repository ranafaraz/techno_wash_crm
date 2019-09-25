<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockIssue;

/**
 * StockIssueSearch represents the model behind the search form about `common\models\StockIssue`.
 */
class StockIssueSearch extends StockIssue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock_issue_id', 'created_by', 'updated_by'], 'integer'],
            [['stock_issue_date', 'description', 'created_at', 'updated_at', 'emp_id', 'stock_id'], 'safe'],
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
        $query = StockIssue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('emp');
        $query->joinWith('stock');


        $query->andFilterWhere([
            'stock_issue_id' => $this->stock_issue_id,
            //'emp_id' => $this->emp_id,
            //'stock_id' => $this->stock_id,
            'stock_issue_date' => $this->stock_issue_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
              ->andFilterWhere(['like', 'employee.emp_name', $this->emp_id])
              ->andFilterWhere(['like', 'stock.name', $this->stock_id]);


        return $dataProvider;
    }
}
