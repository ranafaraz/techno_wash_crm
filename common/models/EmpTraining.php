<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_training".
 *
 * @property int $emp_trainind_id
 * @property int $emp_id
 * @property string $train_from_date
 * @property string $train_to_date
 * @property string $training_course
 * @property string $training_institute
 * @property string $training_certificate
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $emp
 */
class EmpTraining extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'train_from_date', 'train_to_date', 'training_course', 'training_institute', 'training_certificate', 'created_by', 'updated_by'], 'required'],
            [['emp_id', 'created_by', 'updated_by'], 'integer'],
            [['train_from_date', 'train_to_date', 'created_at', 'updated_at'], 'safe'],
            [['training_course', 'training_certificate'], 'string', 'max' => 200],
            [['training_institute'], 'string', 'max' => 250],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_trainind_id' => 'Emp Trainind ID',
            'emp_id' => 'Emp ID',
            'train_from_date' => 'Train From Date',
            'train_to_date' => 'Train To Date',
            'training_course' => 'Training Course',
            'training_institute' => 'Training Institute',
            'training_certificate' => 'Training Certificate',
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
