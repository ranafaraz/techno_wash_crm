<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Organization */
?>
<div class="organization-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'org_id',
            'org_name',
            'org_address',
            'org_owner',
            'org_contact',
            'org_head_office',
            'org_owner_cnic',
            'business_ntn',
            'org_logo',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
