<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\VehicleTypeSubCatHead */
?>
<div class="vehicle-type-sub-cat-head-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sub_cat_head_id',
            'vehicle_type_id',
            'manufacture',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
