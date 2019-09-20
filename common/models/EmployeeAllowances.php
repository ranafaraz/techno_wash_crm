<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_allowances".
 *
 * @property int $emp_allowance_id
 * @property int $emp_id
 * @property int $allowance_type_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Employee $emp
 * @property AllowanceType $allowanceType
 * @property Salary[] $salaries
 */
class EmployeeAllowances extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_allowances';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'allowance_type_id'], 'required'],
            [['emp_id', 'allowance_type_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
            [['allowance_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllowanceType::className(), 'targetAttribute' => ['allowance_type_id' => 'allowance_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_allowance_id' => 'Emp Allowance ID',
            'emp_id' => 'Employee Name',
            'allowance_type_id' => 'Allowance Type Name',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllowanceType()
    {
        return $this->hasOne(AllowanceType::className(), ['allowance_type_id' => 'allowance_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaries()
    {
        return $this->hasMany(Salary::className(), ['emp_allowance_id' => 'emp_allowance_id']);
    }
}
