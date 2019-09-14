<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_types".
 *
 * @property int $emp_type_id
 * @property string $emp_type_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Employee[] $employees
 */
class EmployeeTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_type_name'], 'required'],
            [['created_at', 'updated_at', 'description', 'created_by', 'updated_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['emp_type_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_type_id' => 'Emp Type ID',
            'emp_type_name' => 'Emp Type Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['emp_type_id' => 'emp_type_id']);
    }
}
