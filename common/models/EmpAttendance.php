<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_attendance".
 *
 * @property int $att_id
 * @property int $emp_id
 * @property string $att_date
 * @property string $check_in
 * @property string $check_out
 * @property string $attendance
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EmpInfo $emp
 */
class EmpAttendance extends \yii\db\ActiveRecord
{
    public $emp_cnic;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_cnic'], 'required'],
            [['emp_id', 'created_by', 'updated_by'], 'integer'],
            [['att_date', 'check_in', 'check_out', 'created_at', 'updated_at', 'emp_id', 'att_date', 'attendance', 'created_by', 'updated_by', 'branch_id'], 'safe'],
            [['attendance'], 'string', 'max' => 2],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
           [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'att_id' => 'Att ID',
            'emp_id' => 'Employee Name',
            'emp_cnic' => 'Employee CNIC:',
            'att_date' => 'Date',
            'check_in' => 'Check In',
            'check_out' => 'Check Out',
            'attendance' => 'Attendance',
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
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getBranch()
   {
       return $this->hasOne(Branches::className(), ['branch_id' => 'branch_id']);
   }
}
