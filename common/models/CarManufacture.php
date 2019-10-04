<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_manufacture".
 *
 * @property int $car_manufacture_id
 * @property int $vehical_type_id
 * @property string $manufacturer
 * @property string $description
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property VehicleType $vehicalType
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
            [['vehical_type_id', 'manufacturer'], 'required'],
            [['vehical_type_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'description'], 'safe'],
            [['manufacturer'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
            [['vehical_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleType::className(), 'targetAttribute' => ['vehical_type_id' => 'vehical_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'car_manufacture_id' => 'Car Manufacture ID',
            'vehical_type_id' => 'Vehical Type ID',
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
    public function getVehicalType()
    {
        return $this->hasOne(VehicleType::className(), ['vehical_type_id' => 'vehical_type_id']);
    }
}
