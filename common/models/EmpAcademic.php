<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_academic".
 *
 * @property int $emp_academic_id
 * @property int $emp_id
 * @property string $from_date
 * @property string $to_date
 * @property string $institute
 * @property string $degree_diploma
 * @property string $division_grade
 * @property string $major_subjects
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $emp
 */
class EmpAcademic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_academic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_date', 'to_date', 'institute', 'degree_diploma', 'division_grade', 'major_subjects'], 'required'],
            [['emp_id', 'created_by', 'updated_by'], 'integer'],
            [['from_date', 'to_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['institute', 'major_subjects'], 'string', 'max' => 250],
            [['degree_diploma'], 'string', 'max' => 200],
            [['division_grade'], 'string', 'max' => 20],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_academic_id' => 'Emp Academic ID',
            'emp_id' => 'Emp ID',
            'from_date' => 'Start Date',
            'to_date' => 'End Date',
            'institute' => 'Institute',
            'degree_diploma' => 'Degree/Diploma',
            'division_grade' => 'Division/Grade',
            'major_subjects' => 'Major Subjects',
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
