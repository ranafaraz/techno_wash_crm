<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_issue".
 *
 * @property int $stock_issue_id
 * @property int $emp_id
 * @property int $stock_id
 * @property string $stock_issue_date
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Employee $emp
 * @property Stock $stock
 */
class StockIssue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'stock_id', 'stock_issue_date', 'description'], 'required'],
            [['emp_id', 'stock_id', 'created_by', 'updated_by'], 'integer'],
            [['stock_issue_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['description'], 'string', 'max' => 200],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stock::className(), 'targetAttribute' => ['stock_id' => 'stock_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stock_issue_id' => 'Stock Issue ID',
            'emp_id' => 'Emp Name',
            'stock_id' => 'Stock Name',
            'stock_issue_date' => 'Stock Issue Date',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Employee::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['stock_id' => 'stock_id']);
    }
}
