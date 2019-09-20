<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vehicle_type_sub_category".
 *
 * @property int $vehicle_typ_sub_id
 * @property int $vehicle_type_id
 * @property string $name
 * @property string $manufacture
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property CustomerVehicles[] $customerVehicles
 * @property VehicleType $vehicleType
 */
class VehicleTypeSubCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_type_sub_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['vehicle_type_id', 'name', 'manufacture'], 'required'],
            [['vehicle_type_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['manufacture'], 'string', 'max' => 200],
            [['vehicle_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleType::className(), 'targetAttribute' => ['vehicle_type_id' => 'vehical_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehicle_typ_sub_id' => 'Vehicle Typ Sub ID',
            'vehicle_type_id' => 'Vehicle Type Name',
            'name' => 'Vehicle Sub Type Name',
            'manufacture' => 'Manufacture',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerVehicles()
    {
        return $this->hasMany(CustomerVehicles::className(), ['vehicle_typ_sub_id' => 'vehicle_typ_sub_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleType()
    {
        return $this->hasOne(VehicleType::className(), ['vehical_type_id' => 'vehicle_type_id']);
    }
}
