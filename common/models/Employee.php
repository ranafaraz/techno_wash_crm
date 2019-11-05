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
 * @property string $emp_father_name
 * @property string $emp_father_position
 * @property string $emp_cnic
 * @property string $emp_contact
 * @property string $emp_emergency_contact
 * @property string $emp_emergency_contact_relation
 * @property string $emp_email
 * @property string $emp_image
 * @property string $emp_gender
 * @property string $emp_marital_status
 * @property string $emp_dob
 * @property string $emp_birth_place
 * @property string $emp_religion
 * @property string $emp_blood_group
 * @property string $emp_nationality
 * @property string $emp_passport_no
 * @property string $passport_expiry_date
 * @property string $emp_residence
 * @property string $emp_present_address
 * @property string $emp_permanent_address
 * @property string $emp_joining_date
 * @property string $emp_learning_date
 * @property string $emp_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EmpAcademic[] $empAcademics
 * @property EmpCertification[] $empCertifications
 * @property EmpComputerCourse[] $empComputerCourses
 * @property EmpGrossSalary[] $empGrossSalaries
 * @property EmpRefrences[] $empRefrences
 * @property EmpTraining[] $empTrainings
 * @property EmpWorkHistory[] $empWorkHistories
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
            [['emp_type_id', 'emp_name', 'emp_father_name', 'emp_cnic', 'emp_contact', 'emp_email', 'emp_gender','emp_permanent_address','emp_joining_date', 'emp_learning_date', 'emp_status'], 'required'],
            [['emp_type_id', 'branch_id', 'created_by', 'updated_by'], 'integer'],
            [['salary_id'], 'number'],
            [['emp_gender', 'emp_marital_status', 'emp_residence', 'emp_status','emp_blood_group'], 'string'],
            [['emp_dob', 'passport_expiry_date', 'emp_joining_date', 'emp_learning_date', 'created_at', 'updated_at', 'created_by', 'updated_by', 'emp_image', 'emp_emergency_contact', 'emp_emergency_contact_relation'], 'safe'],
            [['emp_name', 'emp_father_name', 'emp_father_position'], 'string', 'max' => 200],
            [['emp_cnic', 'emp_contact', 'emp_emergency_contact', 'emp_emergency_contact_relation'], 'string', 'max' => 15],
            [['emp_email', 'emp_image'], 'string', 'max' => 255],
            [['emp_birth_place'], 'string', 'max' => 150],
            [['emp_religion', 'emp_nationality'], 'string', 'max' => 100],
            [['emp_passport_no'], 'string', 'max' => 50],
            [['emp_present_address', 'emp_permanent_address'], 'string', 'max' => 250],
            [['emp_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeTypes::className(), 'targetAttribute' => ['emp_type_id' => 'emp_type_id']],
            [['emp_image'],'file','extensions' => 'png,jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_id' => 'Emp ID',
            'emp_type_id' => 'Job Position',
            'branch_id' => 'Branch',
            'salary_id' => 'Salary',
            'emp_name' => 'Name',
            'emp_father_name' => 'Father Name',
            'emp_father_position' => 'Father Position',
            'emp_cnic' => 'CNIC #',
            'emp_contact' => 'Contact #',
            'emp_emergency_contact' => 'Emergency Contact',
            'emp_emergency_contact_relation' => 'Emergency Contact Relation',
            'emp_email' => 'Email',
            'emp_image' => 'Image',
            'emp_gender' => 'Gender',
            'emp_marital_status' => 'Marital Status',
            'emp_dob' => 'Date of Birth',
            'emp_birth_place' => 'Birth Place',
            'emp_religion' => 'Religion',
            'emp_blood_group' => 'Blood Group',
            'emp_nationality' => 'Nationality',
            'emp_passport_no' => 'Passport No',
            'passport_expiry_date' => 'Passport Expiry Date',
            'emp_residence' => 'Residence',
            'emp_present_address' => 'Present Address',
            'emp_permanent_address' => 'Permanent Address',
            'emp_joining_date' => 'Joining Date',
            'emp_learning_date' => 'Learning Date',
            'emp_status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpAcademics()
    {
        return $this->hasMany(EmpAcademic::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpCertifications()
    {
        return $this->hasMany(EmpCertification::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpComputerCourses()
    {
        return $this->hasMany(EmpComputerCourse::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpGrossSalaries()
    {
        return $this->hasMany(EmpGrossSalary::className(), ['emp_id' => 'emp_id']);
    }

     public function getEmpLanguages() 
   { 
       return $this->hasMany(EmpLanguage::className(), ['emp_id' => 'emp_id']); 
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpRefrences()
    {
        return $this->hasMany(EmpRefrences::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpTrainings()
    {
        return $this->hasMany(EmpTraining::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpWorkHistories()
    {
        return $this->hasMany(EmpWorkHistory::className(), ['emp_id' => 'emp_id']);
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
