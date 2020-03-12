<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vehicle_type_sub_category".
 *
 * @property int $vehicle_typ_sub_id
 * @property int $sub_type_head_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property CustomerVehicles[] $customerVehicles
 * @property VehicleTypeSubCatHead $subTypeHead
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
            [['sub_type_head_id', 'name', 'created_by', 'updated_by'], 'required'],
            [['sub_type_head_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['sub_type_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleTypeSubCatHead::className(), 'targetAttribute' => ['sub_type_head_id' => 'sub_cat_head_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehicle_typ_sub_id' => 'Vehicle Typ Sub ID',
            'sub_type_head_id' => 'Sub Type Head ID',
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
    public function getSubTypeHead()
    {
        return $this->hasOne(VehicleTypeSubCatHead::className(), ['sub_cat_head_id' => 'sub_type_head_id']);
    }
}
