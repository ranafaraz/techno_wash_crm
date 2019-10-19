<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $service_id
 * @property string $service_name
 * @property string $description
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property ServiceDetails[] $serviceDetails
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_name'], 'required'],
            [['created_at', 'updated_at', 'description', 'created_by', 'updated_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['service_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'service_name' => 'Service Name',
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
    public function getServiceDetails()
    {
        return $this->hasMany(ServiceDetails::className(), ['service_id' => 'service_id']);
    }
}
