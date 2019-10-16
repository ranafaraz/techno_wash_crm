<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpComputerCourse;

/**
 * EmpComputerCourseSearch represents the model behind the search form about `common\models\EmpComputerCourse`.
 */
class EmpComputerCourseSearch extends EmpComputerCourse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_comp_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['comp_course_from', 'comp_course_to', 'comp_course_detail', 'comp_institute', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpComputerCourse::find();

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
            'emp_comp_id' => $this->emp_comp_id,
            'emp_id' => $this->emp_id,
            'comp_course_from' => $this->comp_course_from,
            'comp_course_to' => $this->comp_course_to,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comp_course_detail', $this->comp_course_detail])
            ->andFilterWhere(['like', 'comp_institute', $this->comp_institute]);

        return $dataProvider;
    }
}
