<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_computer_course".
 *
 * @property int $emp_comp_id
 * @property int $emp_id
 * @property string $comp_course_from
 * @property string $comp_course_to
 * @property string $comp_course_detail
 * @property string $comp_institute
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $emp
 */
class EmpComputerCourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_computer_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'comp_course_from', 'comp_course_to', 'comp_course_detail', 'comp_institute', 'created_by', 'updated_by'], 'required'],
            [['emp_id', 'created_by', 'updated_by'], 'integer'],
            [['comp_course_from', 'comp_course_to', 'created_at', 'updated_at'], 'safe'],
            [['comp_course_detail', 'comp_institute'], 'string', 'max' => 255],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_comp_id' => 'Emp Comp ID',
            'emp_id' => 'Emp ID',
            'comp_course_from' => 'Comp Course From',
            'comp_course_to' => 'Comp Course To',
            'comp_course_detail' => 'Comp Course Detail',
            'comp_institute' => 'Comp Institute',
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
