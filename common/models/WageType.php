<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wage_type".
 *
 * @property int $wage_type_id
 * @property int $branch_id
 * @property string $wage_name
 * @property int $basic_pay
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Salary[] $salaries
 * @property Branches $branch
 */
class WageType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wage_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['branch_id', 'wage_name', 'basic_pay'], 'required'],
            [['branch_id', 'basic_pay', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['wage_name'], 'string', 'max' => 50],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wage_type_id' => 'Wage Type ID',
            'branch_id' => 'Branch Name',
            'wage_name' => 'Wage Name',
            'basic_pay' => 'Basic Pay',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaries()
    {
        return $this->hasMany(Salary::className(), ['wage_type_id' => 'wage_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::className(), ['branch_id' => 'branch_id']);
    }
}
