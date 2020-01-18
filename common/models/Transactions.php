<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property int $transaction_id
 * @property string $type
 * @property string $narration
 * @property int $debit_account
 * @property string $debit_type
 * @property int $credit_account
 * @property string $credit_type
 * @property double $amount
 * @property string $transactions_date
 * @property string $ref_no
 * @property string $created_by
 */
class Transactions extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['transaction_id', 'type', 'debit_account', 'debit_type', 'credit_account', 'credit_type', 'amount', 'transactions_date', 'created_by'], 'required'],
            [['transaction_id', 'debit_account', 'credit_account'], 'integer'],
            [['type', 'narration'], 'string'],
            [['amount'], 'number'],
            [['transactions_date'], 'safe'],
            [['debit_type', 'credit_type', 'ref_no'], 'string', 'max' => 50],
            [['created_by'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'type' => 'Type',
            'narration' => 'Narration',
            'debit_account' => 'Debit Account',
            'debit_type' => 'Debit Type',
            'credit_account' => 'Credit Account',
            'credit_type' => 'Credit Type',
            'amount' => 'Amount',
            'transactions_date' => 'Transactions Date',
            'ref_no' => 'Ref No',
            'created_by' => 'Created By',
        ];
    }
}
