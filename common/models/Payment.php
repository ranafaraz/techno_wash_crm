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
 * @property int $account_title_id
 * @property int $debit_account
 * @property double $debit_amount
 * @property int $credit_account
 * @property double $credit_amount
 * @property string $transactions_date
 * @property string $ref_no
 * @property string $created_by
 *
 * @property AccountTitle $accountTitle
 * @property AccountHead $debitAccount
 * @property AccountHead $creditAccount
 */
class Payment extends \yii\db\ActiveRecord
{
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
            [['transaction_id', 'type', 'debit_account', 'debit_amount', 'credit_account', 'credit_amount', 'transactions_date', 'created_by'], 'required'],
            [['transaction_id', 'debit_account', 'credit_account'], 'integer'],
            [['type', 'narration'], 'string'],
            [['transactions_date','prev_remaning','payable_narration','updateid','checkstate','debit_amount','credit_amount','transactions_date'], 'safe'],
            [['ref_no'], 'string', 'max' => 50],
            [['created_by'], 'string', 'max' => 150],

            [['debit_account'], 'exist', 'skipOnError' => true, 'targetClass' => AccountHead::className(), 'targetAttribute' => ['debit_account' => 'id']],
            [['credit_account'], 'exist', 'skipOnError' => true, 'targetClass' => AccountHead::className(), 'targetAttribute' => ['credit_account' => 'id']],
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
            'account_title_id' => 'Account Title ID',
            'debit_account' => 'Debit Account',
            'credit_account' => 'Credit Account',
            'amount' => 'Amount',
            'transactions_date' => 'Transactions Date',
            'ref_no' => 'Ref No',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebitAccount()
    {
        return $this->hasOne(AccountHead::className(), ['id' => 'debit_account']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreditAccount()
    {
        return $this->hasOne(AccountHead::className(), ['id' => 'credit_account']);
    }
}
