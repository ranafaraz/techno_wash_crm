<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $services_id
 * @property int $branch_id
 * @property string $name
 * @property int $price
 * @property string $description
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SaleInvoiceServicesDetail[] $saleInvoiceServicesDetails
 * @property Branches $branch
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
            [['branch_id', 'name', 'price', 'description'], 'required'],
            [['branch_id', 'price', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'services_id' => 'Services ID',
            'branch_id' => 'Branch Name',
            'name' => 'Service Name',
            'price' => 'Price',
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
    public function getSaleInvoiceServicesDetails()
    {
        return $this->hasMany(SaleInvoiceServicesDetail::className(), ['services_id' => 'services_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::className(), ['branch_id' => 'branch_id']);
    }
}
