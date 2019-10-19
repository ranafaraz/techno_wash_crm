<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service_details".
 *
 * @property int $service_detail_id
 * @property int $branch_id
 * @property int $vehicle_type_id
 * @property int $service_id
 * @property int $price
 * @property string $description
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Branches $branch
 * @property VehicleType $vehicleType
 * @property Services $service
 */
class ServiceDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'vehicle_type_id', 'service_id', 'price'], 'required'],
            [['branch_id', 'vehicle_type_id', 'service_id', 'price', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'description', 'created_by', 'updated_by'], 'safe'],
            [['description'], 'string', 'max' => 200],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['vehicle_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleType::className(), 'targetAttribute' => ['vehicle_type_id' => 'vehical_type_id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'service_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_detail_id' => 'Service Detail ID',
            'branch_id' => 'Branch',
            'vehicle_type_id' => 'Vehicle Type',
            'service_id' => 'Service',
            'price' => 'Price',
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
    public function getBranch()
    {
        return $this->hasOne(Branches::className(), ['branch_id' => 'branch_id']);
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
    public function getService()
    {
        return $this->hasOne(Services::className(), ['service_id' => 'service_id']);
    }
}
