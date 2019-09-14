<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property int $stock_id
 * @property int $branch_id
 * @property int $stock_type_id
 * @property int $purchase_invoice_id
 * @property int $manufacture_id
 * @property string $barcode
 * @property string $name
 * @property string $expiry_date
 * @property int $purchase_price
 * @property int $selling_price
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property SaleInvoiceStockDetail[] $saleInvoiceStockDetails
 * @property StockType $stockType
 * @property PurchaseInvoice $purchaseInvoice
 * @property Manufacture $manufacture
 * @property StockIssue[] $stockIssues
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'stock_type_id', 'purchase_invoice_id', 'manufacture_id', 'barcode', 'name', 'expiry_date', 'purchase_price', 'selling_price', 'status'], 'required'],
            [['branch_id', 'stock_type_id', 'purchase_invoice_id', 'manufacture_id', 'purchase_price', 'selling_price', 'created_by', 'updated_by'], 'integer'],
            [['expiry_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['status'], 'string'],
            [['barcode', 'name'], 'string', 'max' => 200],
            [['stock_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StockType::className(), 'targetAttribute' => ['stock_type_id' => 'stock_type_id']],
            [['purchase_invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseInvoice::className(), 'targetAttribute' => ['purchase_invoice_id' => 'purchase_invoice_id']],
            [['manufacture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacture::className(), 'targetAttribute' => ['manufacture_id' => 'manufacture_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stock_id' => 'Stock ID',
            'branch_id' => 'Branch Name',
            'stock_type_id' => 'Stock Type Name',
            'purchase_invoice_id' => 'Purchase Invoice ID',
            'manufacture_id' => 'Manufacture ID',
            'barcode' => 'Barcode',
            'name' => 'Name',
            'expiry_date' => 'Expiry Date',
            'purchase_price' => 'Purchase Price',
            'selling_price' => 'Selling Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleInvoiceStockDetails()
    {
        return $this->hasMany(SaleInvoiceStockDetail::className(), ['stock_id' => 'stock_id']);
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
    public function getPurchaseInvoice()
    {
        return $this->hasOne(PurchaseInvoice::className(), ['purchase_invoice_id' => 'purchase_invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacture()
    {
        return $this->hasOne(Manufacture::className(), ['manufacture_id' => 'manufacture_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockIssues()
    {
        return $this->hasMany(StockIssue::className(), ['stock_id' => 'stock_id']);
    }
}
