<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_invoice_detail".
 *
 * @property int $sale_inv_ser_detail_id
 * @property int $sale_inv_head_id
 * @property int $customer_vehicle_id
 * @property int $item_id
 * @property string $item_type
 * @property int $discount_per_service
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property SaleInvoiceHead $saleInvHead
 * @property CustomerVehicles $customerVehicle
 */
class SaleInvoiceDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_invoice_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_inv_head_id', 'customer_vehicle_id', 'item_id', 'item_type', 'discount_per_service', 'created_by', 'updated_by'], 'required'],
            [['sale_inv_head_id', 'customer_vehicle_id', 'item_id', 'discount_per_service', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['item_type'], 'string', 'max' => 20],
            [['sale_inv_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => SaleInvoiceHead::className(), 'targetAttribute' => ['sale_inv_head_id' => 'sale_inv_head_id']],
            [['customer_vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerVehicles::className(), 'targetAttribute' => ['customer_vehicle_id' => 'customer_vehicle_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sale_inv_ser_detail_id' => 'Sale Inv Ser Detail ID',
            'sale_inv_head_id' => 'Sale Inv Head ID',
            'customer_vehicle_id' => 'Customer Vehicle ID',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'discount_per_service' => 'Discount Per Service',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
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
    public function getCustomerVehicle()
    {
        return $this->hasOne(CustomerVehicles::className(), ['customer_vehicle_id' => 'customer_vehicle_id']);
    }
}
