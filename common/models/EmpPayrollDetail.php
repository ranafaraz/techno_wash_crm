<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_payroll_detail".
 *
 * @property int $payroll_detail_id
 * @property int $payroll_head_id
 * @property string $transaction_date
 * @property double $paid_amount
 * @property string $status
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property EmpPayrollHead $payrollHead
 */
class EmpPayrollDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_payroll_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payroll_head_id', 'transaction_date', 'status', 'created_by', 'updated_by'], 'required'],
            [['payroll_head_id', 'created_by', 'updated_by'], 'integer'],
            [['transaction_date', 'created_at', 'updated_at'], 'safe'],
            [['paid_amount'], 'number'],
            [['status'], 'string'],
            [['payroll_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmpPayrollHead::className(), 'targetAttribute' => ['payroll_head_id' => 'payroll_head_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payroll_detail_id' => 'Payroll Detail ID',
            'payroll_head_id' => 'Payroll Head ID',
            'transaction_date' => 'Transaction Date',
            'paid_amount' => 'Paid Amount',
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
    public function getPayrollHead()
    {
        return $this->hasOne(EmpPayrollHead::className(), ['payroll_head_id' => 'payroll_head_id']);
    }
}
