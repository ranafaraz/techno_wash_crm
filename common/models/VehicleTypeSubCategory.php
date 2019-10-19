<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vehicle_type_sub_category".
 *
 * @property int $vehicle_typ_sub_id
 * @property int $manufacture
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property CustomerVehicles[] $customerVehicles
 * @property CarManufacture $manufacture0
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
            [['name'], 'required'],
            [['manufacture', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by','manufacture'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['manufacture'], 'exist', 'skipOnError' => true, 'targetClass' => CarManufacture::className(), 'targetAttribute' => ['manufacture' => 'car_manufacture_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehicle_typ_sub_id' => 'Vehicle Typ Sub ID',
            'manufacture' => 'Manufacture',
            'name' => 'Name',
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
    public function getManufacture0()
    {
        return $this->hasOne(CarManufacture::className(), ['car_manufacture_id' => 'manufacture']);
    }
}
