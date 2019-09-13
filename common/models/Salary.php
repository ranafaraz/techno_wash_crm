<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "salary".
 *
 * @property int $salary_id
 * @property int $emp_id
 * @property int $emp_allowance_id
 * @property int $wage_type_id
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee[] $employees
 * @property Employee $emp
 * @property WageType $wageType
 * @property EmployeeAllowances $empAllowance
 */
class Salary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'emp_allowance_id', 'wage_type_id'], 'required'],
            [['emp_id', 'emp_allowance_id', 'wage_type_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
            [['wage_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => WageType::className(), 'targetAttribute' => ['wage_type_id' => 'wage_type_id']],
            [['emp_allowance_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeAllowances::className(), 'targetAttribute' => ['emp_allowance_id' => 'emp_allowance_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'salary_id' => 'Salary ID',
            'emp_id' => 'Emp ID',
            'emp_allowance_id' => 'Emp Allowance ID',
            'wage_type_id' => 'Wage Type ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['salary_id' => 'salary_id']);
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
    public function getWageType()
    {
        return $this->hasOne(WageType::className(), ['wage_type_id' => 'wage_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpAllowance()
    {
        return $this->hasOne(EmployeeAllowances::className(), ['emp_allowance_id' => 'emp_allowance_id']);
    }
}
