<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpCertification;

/**
 * EmpCertificationSearch represents the model behind the search form about `common\models\EmpCertification`.
 */
class EmpCertificationSearch extends EmpCertification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_certificate_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['certificate_from', 'certificate_to', 'certificate_course_detail', 'certificate_insititute', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmpCertification::find();

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
            'emp_certificate_id' => $this->emp_certificate_id,
            'emp_id' => $this->emp_id,
            'certificate_from' => $this->certificate_from,
            'certificate_to' => $this->certificate_to,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'certificate_course_detail', $this->certificate_course_detail])
            ->andFilterWhere(['like', 'certificate_insititute', $this->certificate_insititute]);

        return $dataProvider;
    }
}
