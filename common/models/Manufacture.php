<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manufacture".
 *
 * @property int $manufacture_id
 * @property int $stock_type_id
 * @property string $name
 * @property string $description
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property StockType $stockType
 * @property Stock[] $stocks
 */
class Manufacture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manufacture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stock_type_id', 'name'], 'required'],
            [['stock_type_id', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'description'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['stock_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StockType::className(), 'targetAttribute' => ['stock_type_id' => 'stock_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'manufacture_id' => 'Manufacture ID',
            'stock_type_id' => 'Stock Type ID',
            'name' => 'Manufacturer',
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
    public function getStockType()
    {
        return $this->hasOne(StockType::className(), ['stock_type_id' => 'stock_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['manufacture_id' => 'manufacture_id']);
    }
}
