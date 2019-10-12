<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $emp_id
 * @property int $emp_type_id
 * @property int $branch_id
 * @property int $salary_id
 * @property string $emp_name
 * @property string $emp_cnic
 * @property string $emp_father_name
 * @property int $emp_contact
 * @property string $emp_email
 * @property string $emp_image
 * @property string $emp_gender
 * @property string $emp_qualification
 * @property string $emp_reference
 * @property string $joining_date
 * @property string $learning_date
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Salary $salary
 * @property Branches $branch
 * @property EmployeeTypes $empType
 * @property EmployeeAllowances[] $employeeAllowances
 * @property Salary[] $salaries
 * @property StockIssue[] $stockIssues
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_type_id', 'salary_id', 'emp_name', 'emp_cnic', 'emp_father_name', 'emp_contact', 'emp_email', 'emp_gender', 'emp_qualification', 'emp_reference', 'joining_date', 'learning_date', 'status'], 'required'],
            [['emp_type_id', 'branch_id', 'salary_id', 'created_by', 'updated_by'], 'integer'],
            [['emp_gender', 'status'], 'string'],
            [['joining_date', 'learning_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['emp_name', 'emp_father_name', 'emp_reference'], 'string', 'max' => 200],
            [['emp_cnic', 'emp_contact'], 'string', 'max' => 15],
            [['emp_email', 'emp_image', 'emp_qualification'], 'string', 'max' => 255],
            // [['salary_id'], 'exist', 'skipOnError' => true, 'targetClass' => Salary::className(), 'targetAttribute' => ['salary_id' => 'salary_id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['emp_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeTypes::className(), 'targetAttribute' => ['emp_type_id' => 'emp_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_id' => 'Emp ID',
            'emp_type_id' => 'Employee Type',
            'branch_id' => 'Branch Name',
            'salary_id' => 'Salary',
            'emp_name' => 'Employee Name',
            'emp_cnic' => 'Employee Cnic',
            'emp_father_name' => 'Employee Father Name',
            'emp_contact' => 'Employee Contact',
            'emp_email' => 'Employee Email',
            'emp_image' => 'Employee Image',
            'emp_gender' => 'Employee Gender',
            'emp_qualification' => 'Employee Qualification',
            'emp_reference' => 'Employee Reference',
            'joining_date' => 'Joining Date',
            'learning_date' => 'Learning Date',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getSalary()
    // {
    //     return $this->hasOne(Salary::className(), ['salary_id' => 'salary_id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpType()
    {
        return $this->hasOne(EmployeeTypes::className(), ['emp_type_id' => 'emp_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeAllowances()
    {
        return $this->hasMany(EmployeeAllowances::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaries()
    {
        return $this->hasMany(Salary::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockIssues()
    {
        return $this->hasMany(StockIssue::className(), ['emp_id' => 'emp_id']);
    }
}
