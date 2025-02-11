<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Branches;

/**
 * BranchesSearch represents the model behind the search form about `common\models\Branches`.
 */
class BranchesSearch extends Branches
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'created_by', 'updated_by'], 'integer'],

            [['branch_code', 'branch_name', 'branch_type', 'branch_location', 'branch_contact_no', 'branch_email', 'status', 'branch_head_name', 'branch_head_contact_no', 'branch_head_email', 'created_at', 'updated_at', 'delete_status', 'org_id'], 'safe'],

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
        $query = Branches::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('org');

        $query->andFilterWhere([
            'branch_id' => $this->branch_id,
            //'org_id' => $this->org_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'branch_code', $this->branch_code])
            ->andFilterWhere(['like', 'branch_name', $this->branch_name])
            ->andFilterWhere(['like', 'branch_type', $this->branch_type])
            ->andFilterWhere(['like', 'branch_location', $this->branch_location])
            ->andFilterWhere(['like', 'branch_contact_no', $this->branch_contact_no])
            ->andFilterWhere(['like', 'branch_email', $this->branch_email])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'branch_head_name', $this->branch_head_name])
            ->andFilterWhere(['like', 'branch_head_contact_no', $this->branch_head_contact_no])
            ->andFilterWhere(['like', 'branch_head_email', $this->branch_head_email])
            ->andFilterWhere(['like', 'delete_status', $this->delete_status])
            ->andFilterWhere(['like', 'organization.org_name', $this->org_id]);
            
        return $dataProvider;
    }
}
