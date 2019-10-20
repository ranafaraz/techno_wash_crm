<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_gross_salary".
 *
 * @property int $emp_gro_sal_id
 * @property int $emp_id
 * @property double $gross_salary
 * @property double $bonus
 * @property string $car
 * @property string $car_fuel
 * @property string $car_maintenance
 * @property string $retirement_benefits
 * @property string $others
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $emp
 */
class EmpGrossSalary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_gross_salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'gross_salary', 'bonus', 'car', 'car_fuel', 'car_maintenance', 'retirement_benefits', 'others', 'created_by', 'updated_by'], 'required'],
            [['emp_id', 'created_by', 'updated_by'], 'integer'],
            [['gross_salary', 'bonus'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['car', 'car_fuel', 'car_maintenance'], 'string', 'max' => 200],
            [['retirement_benefits', 'others'], 'string', 'max' => 255],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_gro_sal_id' => 'Emp Gro Sal ID',
            'emp_id' => 'Emp ID',
            'gross_salary' => 'Gross Salary',
            'bonus' => 'Bonus',
            'car' => 'Car',
            'car_fuel' => 'Car Fuel',
            'car_maintenance' => 'Car Maintenance',
            'retirement_benefits' => 'Retirement Benefits',
            'others' => 'Others',
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
}
