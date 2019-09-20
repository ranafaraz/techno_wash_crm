<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vehicle_type".
 *
 * @property int $vehical_type_id
 * @property string $name
 * @property string $description
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property VehicleTypeSubCategory[] $vehicleTypeSubCategories
 */
class VehicleType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehical_type_id' => 'Vehical Type ID',
            'name' => 'Vehical Type Name',
            'description' => 'Description',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleTypeSubCategories()
    {
        return $this->hasMany(VehicleTypeSubCategory::className(), ['vehicle_type_id' => 'vehical_type_id']);
    }
}
