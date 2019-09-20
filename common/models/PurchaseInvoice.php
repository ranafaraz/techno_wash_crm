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
            [['vendor_id', 'bilty_no', 'purchase_date', 'dispatch_date', 'receiving_date'], 'required'],
            [['vendor_id', 'created_by', 'updated_by'], 'integer'],
            [['purchase_date', 'dispatch_date', 'receiving_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['bilty_no'], 'string', 'max' => 20],
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
            'vendor_id' => 'Vendor Name',
            'bilty_no' => 'Bilty No',
            'purchase_date' => 'Purchase Date',
            'dispatch_date' => 'Dispatch Date',
            'receiving_date' => 'Receiving Date',
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
