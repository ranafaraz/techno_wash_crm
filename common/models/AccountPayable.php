<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "account_payable".
 *
 * @property int $id
 * @property double $amount
 * @property int $account_payable
 * @property string $due_date
 * @property string $narration
 * @property string $created_at
 * @property string $updated_at
 * @property int $updated_by
 * @property string $status
 *
 * @property AccountHead $accountPayable
 */
class AccountPayable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account_payable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['account_payable', 'narration', 'created_at', 'status'], 'required'],
            [['updated_by'], 'integer'],
            [['due_date', 'created_at', 'updated_at','account_payable'], 'safe'],
            [['narration', 'status'], 'string'],
            [['account_payable'], 'exist', 'skipOnError' => true, 'targetClass' => AccountHead::className(), 'targetAttribute' => ['account_payable' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'account_payable' => 'Account Payable',
            'due_date' => 'Due Date',
            'narration' => 'Narration',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountPayable()
    {
        return $this->hasOne(AccountHead::className(), ['id' => 'account_payable']);
    }
}
