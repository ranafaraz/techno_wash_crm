<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpAcademic;

/**
 * EmpAcademicSearch represents the model behind the search form about `common\models\EmpAcademic`.
 */
class EmpAcademicSearch extends EmpAcademic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_academic_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['from_date', 'to_date', 'institute', 'degree_diploma', 'division_grade', 'major_subjects', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpAcademic::find();

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
            'emp_academic_id' => $this->emp_academic_id,
            'emp_id' => $this->emp_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'institute', $this->institute])
            ->andFilterWhere(['like', 'degree_diploma', $this->degree_diploma])
            ->andFilterWhere(['like', 'division_grade', $this->division_grade])
            ->andFilterWhere(['like', 'major_subjects', $this->major_subjects]);

        return $dataProvider;
    }
}
