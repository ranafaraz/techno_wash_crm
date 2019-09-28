<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $product_id
 * @property int $manufacture_id
 * @property string $product_name
 * @property string $description
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Manufacture $manufacture
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name'], 'required'],
            [['manufacture_id', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'description', 'created_by', 'updated_by','manufacture_id'], 'safe'],
            [['product_name'], 'string', 'max' => 50],
            [['manufacture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacture::className(), 'targetAttribute' => ['manufacture_id' => 'manufacture_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'manufacture_id' => 'Manufacture ID',
            'product_name' => 'Product Name',
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
    public function getManufacture()
    {
        return $this->hasOne(Manufacture::className(), ['manufacture_id' => 'manufacture_id']);
    }
}
