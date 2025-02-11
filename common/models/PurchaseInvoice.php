<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_invoice".
 *
 * @property int $purchase_invoice_id
 * @property int $vendor_id
 * @property string $bilty_no
 * @property string $purchase_date
 * @property string $dispatch_date
 * @property string $receiving_date
 * @property int $total_amount
 * @property int $discount
 * @property int $net_total
 * @property int $paid_amount
 * @property int $remaining_amount
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Vendor $vendor
 * @property Stock[] $stocks
 */
class PurchaseInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vendor_id', 'bilty_no', 'purchase_date', 'dispatch_date', 'receiving_date', 'total_amount', 'discount', 'net_total', 'paid_amount', 'remaining_amount', 'status', 'created_by', 'updated_by'], 'required'],
            [['vendor_id', 'total_amount', 'discount', 'net_total', 'paid_amount', 'remaining_amount', 'created_by', 'updated_by'], 'integer'],
            [['purchase_date', 'dispatch_date', 'receiving_date', 'created_at', 'updated_at'], 'safe'],
            [['bilty_no', 'status'], 'string', 'max' => 20],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'vendor_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'purchase_invoice_id' => 'Purchase Invoice ID',
            'vendor_id' => 'Vendor ID',
            'bilty_no' => 'Bilty No',
            'purchase_date' => 'Purchase Date',
            'dispatch_date' => 'Dispatch Date',
            'receiving_date' => 'Receiving Date',
            'total_amount' => 'Total Amount',
            'discount' => 'Discount',
            'net_total' => 'Net Total',
            'paid_amount' => 'Paid Amount',
            'remaining_amount' => 'Remaining Amount',
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
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['purchase_invoice_id' => 'purchase_invoice_id']);
    }
}
