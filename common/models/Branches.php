<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "branches".
 *
 * @property int $branch_id
 * @property int $org_id
 * @property string $branch_code
 * @property string $branch_name
 * @property string $branch_type
 * @property string $branch_location
 * @property string $branch_contact_no
 * @property string $branch_email
 * @property string $status
 * @property string $branch_head_name
 * @property string $branch_head_contact_no
 * @property string $branch_head_email
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $delete_status
 *
 * @property AllowanceType[] $allowanceTypes
 * @property Organization $org
 * @property Employee[] $employees
 * @property User[] $users
 * @property WageType[] $wageTypes
 */
class Branches extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['org_id'], 'required'],
            [['org_id', 'created_by', 'updated_by', 'delete_status'], 'integer'],
            [['branch_type', 'status'], 'string'],
            [[ 'branch_code', 'branch_name', 'branch_type', 'branch_location', 'branch_contact_no', 'branch_email', 'status', 'branch_head_name', 'branch_head_contact_no', 'branch_head_email','created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['branch_code', 'branch_name', 'branch_contact_no'], 'string', 'max' => 32],
            [['branch_location', 'branch_head_name'], 'string', 'max' => 50],
            [['branch_email'], 'string', 'max' => 100],
            [['branch_head_contact_no'], 'string', 'max' => 15],
            [['branch_head_email'], 'string', 'max' => 120],
            [['org_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['org_id' => 'org_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'branch_id' => 'Branch ID',
            'org_id' => 'Organization Name',
            'branch_code' => 'Branch Code',
            'branch_name' => 'Branch Name',
            'branch_type' => 'Branch Type',
            'branch_location' => 'Branch Location',
            'branch_contact_no' => 'Branch Contact No',
            'branch_email' => 'Branch Email',
            'status' => 'Status',
            'branch_head_name' => 'Branch Head Name',
            'branch_head_contact_no' => 'Branch Head Contact No',
            'branch_head_email' => 'Branch Head Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'delete_status' => 'Delete Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllowanceTypes()
    {
        return $this->hasMany(AllowanceType::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(Organization::className(), ['org_id' => 'org_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWageTypes()
    {
        return $this->hasMany(WageType::className(), ['branch_id' => 'branch_id']);
    }
}
