<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_certification".
 *
 * @property int $emp_certificate_id
 * @property int $emp_id
 * @property string $certificate_from
 * @property string $certificate_to
 * @property string $certificate_course_detail
 * @property string $certificate_insititute
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $emp
 */
class EmpCertification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_certification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_certificate_id', 'emp_id', 'certificate_from', 'certificate_to', 'certificate_course_detail', 'certificate_insititute', 'created_by', 'updated_by'], 'required'],
            [['emp_certificate_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['certificate_from', 'certificate_to', 'created_at', 'updated_at'], 'safe'],
            [['certificate_course_detail', 'certificate_insititute'], 'string', 'max' => 255],
            [['emp_certificate_id'], 'unique'],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_certificate_id' => 'Emp Certificate ID',
            'emp_id' => 'Emp ID',
            'certificate_from' => 'Certificate From',
            'certificate_to' => 'Certificate To',
            'certificate_course_detail' => 'Certificate Course Detail',
            'certificate_insititute' => 'Certificate Insititute',
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
