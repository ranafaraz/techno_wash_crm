<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $customer_id
 * @property int $branch_id
 * @property string $customer_name
 * @property string $customer_gender
 * @property string $customer_cnic
 * @property string $customer_address
 * @property int $customer_contact_no
 * @property string $customer_registration_date
 * @property int $customer_age
 * @property string $customer_email
 * @property string $customer_image
 * @property string $customer_occupation
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CustomerVehicles[] $customerVehicles
 * @property Membership[] $memberships
 * @property SaleInvoiceHead[] $saleInvoiceHeads
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'customer_name', 'customer_gender', 'customer_cnic', 'customer_address', 'customer_contact_no', 'customer_registration_date', 'customer_age', 'customer_email', 'customer_image', 'customer_occupation'], 'required'],
            [['branch_id', 'customer_contact_no', 'customer_age', 'created_by', 'updated_by'], 'integer'],
            [['customer_gender'], 'string'],
            [['customer_registration_date', 'created_at', 'updated_at'], 'safe'],
            [['customer_name'], 'string', 'max' => 100],
            [['customer_cnic'], 'string', 'max' => 15],
            [['customer_address', 'customer_email', 'customer_image', 'customer_occupation'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'branch_id' => 'Branch Name',
            'customer_name' => 'Customer Name',
            'customer_gender' => 'Customer Gender',
            'customer_cnic' => 'Customer Cnic',
            'customer_address' => 'Customer Address',
            'customer_contact_no' => 'Customer Contact No',
            'customer_registration_date' => 'Customer Registration Date',
            'customer_age' => 'Customer Age',
            'customer_email' => 'Customer Email',
            'customer_image' => 'Customer Image',
            'customer_occupation' => 'Customer Occupation',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerVehicles()
    {
        return $this->hasMany(CustomerVehicles::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberships()
    {
        return $this->hasMany(Membership::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleInvoiceHeads()
    {
        return $this->hasMany(SaleInvoiceHead::className(), ['customer_id' => 'customer_id']);
    }
}
