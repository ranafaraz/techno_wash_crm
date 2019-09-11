<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Organization;

/**
 * OrganizationSearch represents the model behind the search form about `common\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'created_by', 'updated_by'], 'integer'],
            [['org_name', 'org_address', 'org_owner', 'org_contact', 'org_head_office', 'org_owner_cnic', 'business_ntn', 'org_logo', 'created_at', 'updated_at'], 'safe'],
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
        $query = Organization::find();

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
            'org_id' => $this->org_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'org_name', $this->org_name])
            ->andFilterWhere(['like', 'org_address', $this->org_address])
            ->andFilterWhere(['like', 'org_owner', $this->org_owner])
            ->andFilterWhere(['like', 'org_contact', $this->org_contact])
            ->andFilterWhere(['like', 'org_head_office', $this->org_head_office])
            ->andFilterWhere(['like', 'org_owner_cnic', $this->org_owner_cnic])
            ->andFilterWhere(['like', 'business_ntn', $this->business_ntn])
            ->andFilterWhere(['like', 'org_logo', $this->org_logo]);

        return $dataProvider;
    }
}
