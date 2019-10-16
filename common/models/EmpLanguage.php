<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_language".
 *
 * @property int $emp_lang_id
 * @property int $emp_id
 * @property string $emp_language
 * @property string $lang_read
 * @property string $lang_wirte
 * @property string $lang_speak
 * @property string $lang_remarks
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class EmpLanguage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_lang_id', 'emp_id', 'emp_language', 'lang_read', 'lang_wirte', 'lang_speak', 'lang_remarks', 'created_by', 'updated_by'], 'required'],
            [['emp_lang_id', 'emp_id', 'created_by', 'updated_by'], 'integer'],
            [['lang_read', 'lang_wirte', 'lang_speak'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['emp_language'], 'string', 'max' => 200],
            [['lang_remarks'], 'string', 'max' => 255],
            [['emp_lang_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_lang_id' => 'Emp Lang ID',
            'emp_id' => 'Emp ID',
            'emp_language' => 'Emp Language',
            'lang_read' => 'Lang Read',
            'lang_wirte' => 'Lang Wirte',
            'lang_speak' => 'Lang Speak',
            'lang_remarks' => 'Lang Remarks',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
