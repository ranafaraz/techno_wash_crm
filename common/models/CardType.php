<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "card_type".
 *
 * @property int $card_type_id
 * @property string $card_name
 * @property string $card_description
 * @property int $card_price
 * @property string $card_services
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Membership[] $memberships
 */
class CardType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_name', 'card_description', 'card_price', 'card_services', 'created_by', 'updated_by'], 'required'],
            [['card_description'], 'string'],
            [['card_price', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['card_name'], 'string', 'max' => 100],
            [['card_services'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'card_type_id' => 'Card Type ID',
            'card_name' => 'Card Name',
            'card_description' => 'Card Description',
            'card_price' => 'Card Price',
            'card_services' => 'Card Services',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberships()
    {
        return $this->hasMany(Membership::className(), ['card_type_id' => 'card_type_id']);
    }
}
