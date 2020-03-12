<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_manufacture".
 *
 * @property int $car_manufacture_id
 * @property string $manufacturer
 * @property string $description
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property VehicleTypeSubCatHead[] $vehicleTypeSubCatHeads
 */
class CarManufacture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_manufacture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manufacturer', 'description', 'created_by', 'updated_by'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['manufacturer'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'car_manufacture_id' => 'Car Manufacture ID',
            'manufacturer' => 'Manufacturer',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleTypeSubCatHeads()
    {
        return $this->hasMany(VehicleTypeSubCatHead::className(), ['manufacture' => 'car_manufacture_id']);
    }
}
