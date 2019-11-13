<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpLeave;

/**
 * EmpLeaveSearch represents the model behind the search form about `common\models\EmpLeave`.
 */
class EmpLeaveSearch extends EmpLeave
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_id', 'emp_id', 'no_of_days', 'created_by', 'updated_by'], 'integer'],
            [['leave_type', 'starting_date', 'ending_date', 'applying_date', 'leave_purpose', 'status', 'remarks', 'created_at', 'updated_at'], 'safe'],
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
        if(Yii::$app->user->identity->user_type == 'dexdevs'){
            $branch_id = Yii::$app->user->identity->branch_id;

            $query = EmpLeave::find()->where(['branch_id'=>$branch_id, 'status'=>'Pending']);

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
                'app_id' => $this->app_id,
                'emp_id' => $this->emp_id,
                'starting_date' => $this->starting_date,
                'ending_date' => $this->ending_date,
                'applying_date' => $this->applying_date,
                'no_of_days' => $this->no_of_days,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'created_by' => $this->created_by,
                'updated_by' => $this->updated_by,
            ]);

            $query->andFilterWhere(['like', 'leave_type', $this->leave_type])
                ->andFilterWhere(['like', 'leave_purpose', $this->leave_purpose])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'remarks', $this->remarks]);

            return $dataProvider;
        } else {
            $branch_id = Yii::$app->user->identity->branch_id;
            $userCnic = Yii::$app->user->identity->username;
            $empId = Yii::$app->db->createCommand("SELECT emp.emp_id FROM employee as emp WHERE emp.emp_cnic = '$userCnic'")->queryAll();

            // $query = EmpLeave::find()->where(['emp_leave.emp_id'=>$empId[0]['emp_id'], 'emp_leave.branch_id'=>$branch_id]);

            $query = EmpLeave::find();

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
                'app_id' => $this->app_id,
                'emp_id' => $this->emp_id,
                'starting_date' => $this->starting_date,
                'ending_date' => $this->ending_date,
                'applying_date' => $this->applying_date,
                'no_of_days' => $this->no_of_days,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'created_by' => $this->created_by,
                'updated_by' => $this->updated_by,
            ]);

            $query->andFilterWhere(['like', 'leave_type', $this->leave_type])
                ->andFilterWhere(['like', 'leave_purpose', $this->leave_purpose])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'remarks', $this->remarks]);

            return $dataProvider;
        }
    }
}
