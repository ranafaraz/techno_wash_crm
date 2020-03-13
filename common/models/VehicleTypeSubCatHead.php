<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vehicle_type_sub_cat_head".
 *
 * @property int $sub_cat_head_id
 * @property int $vehicle_type_id
 * @property int $manufacture
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property CarManufacture $manufacture0
 * @property VehicleType $vehicleType
 * @property VehicleTypeSubCategory[] $vehicleTypeSubCategories
 */
class VehicleTypeSubCatHead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_type_sub_cat_head';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_type_id', 'manufacture'], 'required'],
            [['vehicle_type_id', 'manufacture', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'updated_at', 'updated_by'], 'safe'],
            [['manufacture'], 'exist', 'skipOnError' => true, 'targetClass' => CarManufacture::className(), 'targetAttribute' => ['manufacture' => 'car_manufacture_id']],
            [['vehicle_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleType::className(), 'targetAttribute' => ['vehicle_type_id' => 'vehical_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sub_cat_head_id' => 'Sub Cat Head ID',
            'vehicle_type_id' => 'Vehicle Type',
            'manufacture' => 'Manufacture',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacture0()
    {
        return $this->hasOne(CarManufacture::className(), ['car_manufacture_id' => 'manufacture']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleType()
    {
        return $this->hasOne(VehicleType::className(), ['vehical_type_id' => 'vehicle_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleTypeSubCategories()
    {
        return $this->hasMany(VehicleTypeSubCategory::className(), ['sub_type_head_id' => 'sub_cat_head_id']);
    }
}
