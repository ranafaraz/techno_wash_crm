<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $emp_id
 * @property int $emp_type_id
 * @property int $branch_id
 * @property double $salary_id
 * @property string $emp_name
 * @property string $emp_cnic
 * @property string $emp_father_name
 * @property string $emp_contact
 * @property string $emp_email
 * @property string $emp_image
 * @property string $emp_gender
 * @property int $emp_age
 * @property string $emp_address
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
            [['emp_name', 'emp_cnic', 'emp_father_name', 'emp_contact', 'emp_email', 'emp_gender', 'emp_age', 'emp_address', 'emp_qualification', 'emp_reference', 'joining_date', 'learning_date', 'status'], 'required'],
            [['emp_type_id', 'branch_id', 'emp_age', 'created_by', 'updated_by'], 'integer'],
            [['salary_id'], 'number'],
            [['emp_gender', 'status'], 'string'],
            [['joining_date', 'learning_date', 'created_at', 'updated_at','emp_type_id', 'branch_id', 'created_by', 'updated_by'], 'safe'],
            [['emp_name', 'emp_father_name', 'emp_reference'], 'string', 'max' => 200],
            [['emp_cnic', 'emp_contact'], 'string', 'max' => 15],
            [['emp_email', 'emp_image', 'emp_qualification'], 'string', 'max' => 255],
            [['emp_address'], 'string', 'max' => 250],
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
            'branch_id' => 'Branch',
            'salary_id' => 'Salary',
            'emp_name' => 'Name',
            'emp_cnic' => 'CNIC #',
            'emp_father_name' => 'Father Name',
            'emp_contact' => 'Contact #',
            'emp_email' => 'Email',
            'emp_image' => 'Image',
            'emp_gender' => 'Gender',
            'emp_age' => 'Age',
            'emp_address' => 'Address',
            'emp_qualification' => 'Qualification',
            'emp_reference' => 'Reference',
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
