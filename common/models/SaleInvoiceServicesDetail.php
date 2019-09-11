<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_invoice_services_detail".
 *
 * @property int $sale_inv_ser_detail_id
 * @property int $sale_inv_head_id
 * @property int $services_id
 * @property int $discount_per_service
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property SaleInvoiceHead $saleInvHead
 * @property Services $services
 */
class SaleInvoiceServicesDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_invoice_services_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_inv_head_id', 'services_id', 'discount_per_service', 'created_by', 'updated_by'], 'required'],
            [['sale_inv_head_id', 'services_id', 'discount_per_service', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['sale_inv_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => SaleInvoiceHead::className(), 'targetAttribute' => ['sale_inv_head_id' => 'sale_inv_head_id']],
            [['services_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['services_id' => 'services_id']],
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
            'services_id' => 'Services ID',
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
    public function getServices()
    {
        return $this->hasOne(Services::className(), ['services_id' => 'services_id']);
    }
}
