<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_invoice_head".
 *
 * @property int $sale_inv_head_id
 * @property int $customer_id
 * @property string $date
 * @property int $total_amount
 * @property int $discount
 * @property int $net_total
 * @property int $paid_amount
 * @property int $remaining_amount
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Customer $customer
 * @property SaleInvoiceServicesDetail[] $saleInvoiceServicesDetails
 * @property SaleInvoiceStockDetail[] $saleInvoiceStockDetails
 */
class SaleInvoiceHead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_invoice_head';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'date', 'total_amount', 'discount', 'net_total', 'paid_amount', 'remaining_amount', 'created_by', 'updated_by'], 'required'],
            [['customer_id', 'total_amount', 'discount', 'net_total', 'paid_amount', 'remaining_amount', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sale_inv_head_id' => 'Sale Inv Head ID',
            'customer_id' => 'Customer ID',
            'date' => 'Date',
            'total_amount' => 'Total Amount',
            'discount' => 'Discount',
            'net_total' => 'Net Total',
            'paid_amount' => 'Paid Amount',
            'remaining_amount' => 'Remaining Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleInvoiceServicesDetails()
    {
        return $this->hasMany(SaleInvoiceServicesDetail::className(), ['sale_inv_head_id' => 'sale_inv_head_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleInvoiceStockDetails()
    {
        return $this->hasMany(SaleInvoiceStockDetail::className(), ['sale_inv_head_id' => 'sale_inv_head_id']);
    }
}
