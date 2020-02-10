<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_vehicles".
 *
 * @property int $customer_vehicle_id
 * @property int $customer_id
 * @property int $vehicle_typ_sub_id
 * @property string $registration_no
 * @property string $color
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Customer $customer
 * @property VehicleTypeSubCategory $vehicleTypSub
 * @property Membership[] $memberships
 */
class CustomerVehicles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_vehicles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_typ_sub_id', 'registration_no', 'color'], 'required'],
            [['customer_id', 'vehicle_typ_sub_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by','image','customer_id'], 'safe'],
            [['registration_no'], 'string', 'max' => 20],
            [['color'], 'string', 'max' => 10],
            [['image'], 'string', 'max' => 200],
            [['image'],'image', 'extensions' => 'png, jpg'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['vehicle_typ_sub_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleTypeSubCategory::className(), 'targetAttribute' => ['vehicle_typ_sub_id' => 'vehicle_typ_sub_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_vehicle_id' => 'Customer Vehicle ID',
            'customer_id' => 'Customer',
            'vehicle_typ_sub_id' => 'Vehicle Sub Type Name',
            'registration_no' => 'Registration No: (Ex. ABC-123-01)',
            'color' => 'Color',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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
    public function getVehicleTypSub()
    {
        return $this->hasOne(VehicleTypeSubCategory::className(), ['vehicle_typ_sub_id' => 'vehicle_typ_sub_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberships()
    {
        return $this->hasMany(Membership::className(), ['customer_vehicle_id' => 'customer_vehicle_id']);
    }
}
