<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_leave".
 *
 * @property int $app_id
 * @property int $emp_id
 * @property string $leave_type
 * @property string $starting_date
 * @property string $ending_date
 * @property string $applying_date
 * @property int $no_of_days
 * @property string $leave_purpose
 * @property string $status
 * @property string $remarks
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property EmpInfo $emp
 */
class EmpLeave extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_leave';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leave_type', 'starting_date', 'ending_date','no_of_days', 'leave_purpose'], 'required'],
            [['no_of_days', 'created_by', 'updated_by'], 'integer'],
            [['leave_type'], 'string'],
            [['emp_id', 'starting_date', 'ending_date', 'applying_date', 'created_at', 'updated_at', 'status', 'remarks', 'created_by', 'updated_by','branch_id'], 'safe'],
            [['leave_purpose'], 'string', 'max' => 100],
            [['status'], 'string'],
            [['remarks'], 'string', 'max' => 200],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app_id' => 'App ID',
            'emp_id' => 'Employee Name',
            'leave_type' => 'Leave Type',
            'starting_date' => 'Starting Date',
            'ending_date' => 'Ending Date',
            'applying_date' => 'Applying Date',
            'no_of_days' => 'No of days',
            'leave_purpose' => 'Reason',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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
