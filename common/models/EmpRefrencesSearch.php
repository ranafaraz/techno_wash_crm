<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpRefrences;

/**
 * EmpRefrencesSearch represents the model behind the search form about `common\models\EmpRefrences`.
 */
class EmpRefrencesSearch extends EmpRefrences
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_ref_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['ref_name', 'ref_address', 'ref_occupation', 'ref_contact', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpRefrences::find();

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
            'emp_ref_id' => $this->emp_ref_id,
            'emp_id' => $this->emp_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'ref_name', $this->ref_name])
            ->andFilterWhere(['like', 'ref_address', $this->ref_address])
            ->andFilterWhere(['like', 'ref_occupation', $this->ref_occupation])
            ->andFilterWhere(['like', 'ref_contact', $this->ref_contact]);

        return $dataProvider;
    }
}
