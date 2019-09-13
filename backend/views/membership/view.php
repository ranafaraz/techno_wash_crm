<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Membership */
?>
<div class="membership-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'membership_id',
            'card_type_id',
            'customer_id',
            'customer_vehicle_id',
            'membership_start_date',
            'membership_end_date',
            'card_issued_by',
            'car_registration_no',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
