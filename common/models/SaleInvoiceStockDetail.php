<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_invoice_stock_detail".
 *
 * @property int $sale_inv_stock_detail_id
 * @property int $sale_inv_head_id
 * @property int $stock_id
 * @property int $discount_per_item
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property SaleInvoiceHead $saleInvHead
 * @property Stock $stock
 */
class SaleInvoiceStockDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_invoice_stock_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_inv_head_id', 'stock_id', 'discount_per_item', 'created_by', 'updated_by'], 'required'],
            [['sale_inv_head_id', 'stock_id', 'discount_per_item', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['sale_inv_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => SaleInvoiceHead::className(), 'targetAttribute' => ['sale_inv_head_id' => 'sale_inv_head_id']],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stock::className(), 'targetAttribute' => ['stock_id' => 'stock_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sale_inv_stock_detail_id' => 'Sale Inv Stock Detail ID',
            'sale_inv_head_id' => 'Sale Inv Head ID',
            'stock_id' => 'Stock ID',
            'discount_per_item' => 'Discount Per Item',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleInvHead()
    {
        return $this->hasOne(SaleInvoiceHead::className(), ['sale_inv_head_id' => 'sale_inv_head_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['stock_id' => 'stock_id']);
    }
}
