<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "account_nature".
 *
 * @property int $id
 * @property int $branch_id
 * @property string $name
 * @property string $account_no
 * @property string $created_at
 *
 * @property AccountHead[] $accountHeads
 */
class AccountNature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account_nature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'name', 'account_no', 'created_at'], 'required'],
            [['branch_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['account_no'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_id' => 'Branch ID',
            'name' => 'Name',
            'account_no' => 'Account No',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountHeads()
    {
        return $this->hasMany(AccountHead::className(), ['nature_id' => 'id']);
    }
}
