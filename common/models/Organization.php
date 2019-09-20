<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $org_id
 * @property string $org_name
 * @property string $org_address
 * @property string $org_owner
 * @property string $org_contact
 * @property string $org_head_office
 * @property string $org_owner_cnic
 * @property string $business_ntn
 * @property string $org_logo
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['org_name'], 'required'],
            [['created_at', 'updated_at', 'org_logo', 'created_by', 'updated_by', 'org_address', 'org_owner', 'org_contact', 'org_head_office', 'org_owner_cnic', 'business_ntn'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['org_name', 'org_owner'], 'string', 'max' => 50],
            [['org_address', 'org_head_office'], 'string', 'max' => 100],
            [['org_contact', 'org_owner_cnic', 'business_ntn'], 'string', 'max' => 15],
            [['org_logo'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'org_id' => 'Org ID',
            'org_name' => 'Organization Name',
            'org_address' => 'Organization Address',
            'org_owner' => 'Organization Owner',
            'org_contact' => 'Organization Contact',
            'org_head_office' => 'Organization Head Office',
            'org_owner_cnic' => 'Organization Owner Cnic',
            'business_ntn' => 'Business Ntn',
            'org_logo' => 'Organization Logo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
