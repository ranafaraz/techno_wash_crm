<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_refrences".
 *
 * @property int $emp_ref_id
 * @property int $emp_id
 * @property string $ref_name
 * @property string $ref_address
 * @property string $ref_occupation
 * @property string $ref_contact
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $emp
 */
class EmpRefrences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_refrences';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'ref_name', 'ref_address', 'ref_occupation', 'ref_contact', 'created_by', 'updated_by'], 'required'],
            [['emp_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['ref_name'], 'string', 'max' => 200],
            [['ref_address'], 'string', 'max' => 255],
            [['ref_occupation'], 'string', 'max' => 100],
            [['ref_contact'], 'string', 'max' => 15],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_ref_id' => 'Emp Ref ID',
            'emp_id' => 'Emp ID',
            'ref_name' => 'Ref Name',
            'ref_address' => 'Ref Address',
            'ref_occupation' => 'Ref Occupation',
            'ref_contact' => 'Ref Contact',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Employee::className(), ['emp_id' => 'emp_id']);
    }
}
