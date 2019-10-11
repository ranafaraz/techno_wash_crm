<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceDetails */
?>
<div class="service-details-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'service_detail_id',
            'branch_id',
            'vehicle_type_id',
            'service_id',
            'price',
            'description',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
