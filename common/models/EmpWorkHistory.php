<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_work_history".
 *
 * @property int $emp_w_h_id
 * @property int $emp_id
 * @property string $work_from
 * @property string $work_to
 * @property string $name_of_employeer
 * @property string $position_held
 * @property double $monthly_gross_salary
 * @property string $reason_for_leaving
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $emp
 */
class EmpWorkHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_work_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'work_from', 'work_to', 'name_of_employeer', 'position_held', 'monthly_gross_salary', 'reason_for_leaving', 'created_by', 'updated_by'], 'required'],
            [['emp_id', 'created_by', 'updated_by'], 'integer'],
            [['work_from', 'work_to', 'created_at', 'updated_at'], 'safe'],
            [['monthly_gross_salary'], 'number'],
            [['name_of_employeer', 'position_held'], 'string', 'max' => 200],
            [['reason_for_leaving'], 'string', 'max' => 255],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_w_h_id' => 'Emp W H ID',
            'emp_id' => 'Emp ID',
            'work_from' => 'Work From',
            'work_to' => 'Work To',
            'name_of_employeer' => 'Name Of Employeer',
            'position_held' => 'Position Held',
            'monthly_gross_salary' => 'Monthly Gross Salary',
            'reason_for_leaving' => 'Reason For Leaving',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Employee::className(), ['emp_id' => 'emp_id']);
    }
}
