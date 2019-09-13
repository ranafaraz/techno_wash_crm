<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "allowance_type".
 *
 * @property int $allowance_type_id
 * @property int $branch_id
 * @property string $allowance_name
 * @property int $amount
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Branches $branch
 * @property EmployeeAllowances[] $employeeAllowances
 */
class AllowanceType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allowance_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'allowance_name', 'amount', 'created_by', 'updated_by'], 'required'],
            [['branch_id', 'amount', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['allowance_name'], 'string', 'max' => 50],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'allowance_type_id' => 'Allowance Type ID',
            'branch_id' => 'Branch Name',
            'allowance_name' => 'Allowance Name',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

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
    public function getEmployeeAllowances()
    {
        return $this->hasMany(EmployeeAllowances::className(), ['allowance_type_id' => 'allowance_type_id']);
    }
}
