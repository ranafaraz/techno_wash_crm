<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
?>
<div class="customer-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'customer_id',
            'branch_id',
            'customer_name',
            'customer_gender',
            'customer_cnic',
            'customer_address',
            'customer_contact_no',
            'customer_registration_date',
            'customer_age',
            'customer_email:email',
            'customer_image',
            'customer_occupation',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
