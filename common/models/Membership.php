<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "membership".
 *
 * @property int $membership_id
 * @property int $card_type_id
 * @property int $customer_id
 * @property int $customer_vehicle_id
 * @property string $membership_start_date
 * @property string $membership_end_date
 * @property string $card_issued_by
 * @property string $car_registration_no
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property CardType $cardType
 * @property Customer $customer
 * @property CustomerVehicles $customerVehicle
 */
class Membership extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'membership';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_type_id', 'customer_id', 'customer_vehicle_id', 'membership_start_date', 'membership_end_date', 'card_issued_by', 'car_registration_no'], 'required'],
            [['card_type_id', 'customer_id', 'customer_vehicle_id', 'created_by', 'updated_by'], 'integer'],
            [['membership_start_date', 'membership_end_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['card_issued_by'], 'string', 'max' => 50],
            [['car_registration_no'], 'string', 'max' => 20],
            [['card_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CardType::className(), 'targetAttribute' => ['card_type_id' => 'card_type_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['customer_vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerVehicles::className(), 'targetAttribute' => ['customer_vehicle_id' => 'customer_vehicle_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'membership_id' => 'Membership ID',
            'card_type_id' => 'Card Name',
            'customer_id' => 'Customer Name',
            'customer_vehicle_id' => 'Vehicle Registration No',
            'membership_start_date' => 'Membership Start Date',
            'membership_end_date' => 'Membership End Date',
            'card_issued_by' => 'Card Issued By',
            'car_registration_no' => 'Car Registration No',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardType()
    {
        return $this->hasOne(CardType::className(), ['card_type_id' => 'card_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerVehicle()
    {
        return $this->hasOne(CustomerVehicles::className(), ['customer_vehicle_id' => 'customer_vehicle_id']);
    }
}
