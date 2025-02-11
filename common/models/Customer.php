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
 * @property string $customer_contact_no
 * @property string $customer_registration_date
 * @property int $customer_age
 * @property string $customer_email
 * @property string $customer_image
 * @property string $customer_occupation
 * @property int $created_by
 * @property int $updated_by
 * @property string $updated_at
 * @property string $created_at
 *
 * @property Branches $branch
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
            [['customer_name','customer_contact_no'], 'required'],
            [['branch_id', 'customer_age', 'created_by', 'updated_by'], 'integer'],
            [['customer_gender'], 'string'],
            [['customer_registration_date', 'updated_at', 'created_at', 'created_by', 'updated_by','customer_whatsapp','customer_social_media', 'customer_father_name', 'customer_registration_date', 'customer_age', 'customer_email', 'customer_occupation','branch_id','customer_gender', 'customer_cnic', 'customer_address'], 'safe'],
            [['customer_name'], 'string', 'max' => 100],
            [['customer_cnic', 'customer_contact_no'], 'string', 'max' => 15],
            [['customer_address', 'customer_email', 'customer_image', 'customer_occupation'], 'string', 'max' => 255],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['customer_image'],'file','extensions' => 'png,jpg'],
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
            'customer_gender' => 'Gender',
            'customer_cnic' => 'CNIC#',
            'customer_address' => 'Address',
            'customer_contact_no' => 'Contact No#',
            'customer_registration_date' => 'Registration Date',
            'customer_age' => 'Age',
            'customer_email' => 'Email',
            'customer_image' => 'Image',
            'customer_occupation' => 'Occupation',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
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
