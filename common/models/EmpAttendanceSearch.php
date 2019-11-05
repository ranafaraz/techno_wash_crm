<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpAttendance;

/**
 * EmpAttendanceSearch represents the model behind the search form about `common\models\EmpAttendance`.
 */
class EmpAttendanceSearch extends EmpAttendance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['att_id', 'created_by', 'updated_by'], 'integer'],
            [['emp_id', 'att_date', 'check_in', 'check_out', 'attendance', 'created_at', 'updated_at'], 'safe'],
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
            $branch_id = Yii::$app->user->identity->branch_id;
            $query = EmpAttendance::find()->where(['emp_attendance.att_date'=>Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'),'emp_attendance.branch_id'=>$branch_id]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }
            $query->joinWith('emp');
            $query->andFilterWhere([
                'att_id' => $this->att_id,
                //'emp_id' => $this->emp_id,
                'att_date' => $this->att_date,
                'check_in' => $this->check_in,
                'check_out' => $this->check_out,
                'created_by' => $this->created_by,
                'updated_by' => $this->updated_by,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]);

            $query->andFilterWhere(['like', 'attendance', $this->attendance])
                ->andFilterWhere(['like', 'employee.emp_name', $this->emp_id]);

            return $dataProvider;
    }
}
