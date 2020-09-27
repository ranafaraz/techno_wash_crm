<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property int $transaction_id
 * @property int $branch_id
 * @property string $type
 * @property string $narration
 * @property int $account_head_id
 * @property double $amount
 * @property string $transactions_date
 * @property int $head_id
 * @property string $ref_no
 * @property string $ref_name
 * @property string $created_by
 *
 * @property Branches $branch
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public $prev_remaning;
    public $payable_narration;
    public $updateid;
    public $checkstate;
    public $debit_amount;
    public $credit_amount;
    public $transactions_date;
    public $emp_id;
    
    public function rules()
    {
        return [
            [['type', 'account_head_id', 'amount', 'credit_amount', 'debit_amount', 'prev_remaning'], 'required'],
            [['branch_id', 'account_head_id', 'head_id'], 'integer'],
            [['type', 'narration'], 'string'],
            [['amount'], 'number'],
            [['transactions_date', 'payable_narration', 'updateid', 'emp_id'], 'safe'],
            [['ref_no', 'ref_name'], 'string', 'max' => 50],
            [['created_by'], 'string', 'max' => 150],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'branch_id' => 'Branch ID',
            'type' => 'Type',
            'narration' => 'Narration',
            'account_head_id' => 'Account Head ID',
            'amount' => 'Amount',
            'transactions_date' => 'Transactions Date',
            'head_id' => 'Head ID',
            'ref_no' => 'Ref No',
            'ref_name' => 'Ref Name',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::className(), ['branch_id' => 'branch_id']);
    }
}
