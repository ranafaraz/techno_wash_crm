<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_payroll_head".
 *
 * @property int $payroll_head_id
 * @property int $branch_id
 * @property int $emp_id
 * @property string $payment_month
 * @property double $total_calculated_pay
 * @property int $over_time
 * @property double $over_time_pay
 * @property double $bonus
 * @property double $tax_deduction
 * @property double $relaxation
 * @property double $net_total
 * @property double $paid_amount
 * @property double $remaining
 * @property string $status
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property EmpPayrollDetail[] $empPayrollDetails
 * @property Branches $branch
 * @property Employee $emp
 */
class EmpPayrollHead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_payroll_head';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'emp_id', 'payment_month', 'over_time', 'status', 'created_by', 'updated_by'], 'required'],
            [['branch_id', 'emp_id', 'over_time', 'created_by', 'updated_by'], 'integer'],
            [['total_calculated_pay', 'over_time_pay', 'bonus', 'tax_deduction', 'relaxation', 'net_total', 'paid_amount', 'remaining'], 'number'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['payment_month'], 'string', 'max' => 10],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payroll_head_id' => 'Payroll Head ID',
            'branch_id' => 'Branch ID',
            'emp_id' => 'Employees',
            'payment_month' => 'Payment Month',
            'total_calculated_pay' => 'Total Calculated Pay',
            'over_time' => 'Over Time',
            'over_time_pay' => 'Over Time Pay',
            'bonus' => 'Bonus',
            'tax_deduction' => 'Tax Deduction',
            'relaxation' => 'Relaxation',
            'net_total' => 'Net Total',
            'paid_amount' => 'Paid Amount',
            'remaining' => 'Remaining',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpPayrollDetails()
    {
        return $this->hasMany(EmpPayrollDetail::className(), ['payroll_head_id' => 'payroll_head_id']);
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
    public function getEmp()
    {
        return $this->hasOne(Employee::className(), ['emp_id' => 'emp_id']);
    }
}
