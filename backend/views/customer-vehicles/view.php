<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerVehicles */
?>
<div class="customer-vehicles-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'customer_vehicle_id',
            'customer_id',
            'vehicle_typ_sub_id',
            'registration_no',
            'color',
            'image',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
