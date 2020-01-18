<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "account_head".
 *
 * @property int $id
 * @property int $nature_id
 * @property string $account_name
 * @property string $account_no
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property AccountNature $nature
 */
class AccountHead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account_head';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nature_id', 'account_name', 'account_no', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['nature_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['account_name', 'created_by', 'updated_by'], 'string', 'max' => 150],
            [['account_no'], 'string', 'max' => 20],
            [['nature_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccountNature::className(), 'targetAttribute' => ['nature_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nature_id' => 'Nature ID',
            'account_name' => 'Account Name',
            'account_no' => 'Account No',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNature()
    {
        return $this->hasOne(AccountNature::className(), ['id' => 'nature_id']);
    }
}
