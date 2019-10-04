<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Services */
?>
<div class="services-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'services_id',
            'branch_id',
            'vehicle_type_id',
            'name',
            'price',
            'description',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
