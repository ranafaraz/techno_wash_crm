<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\VehicleTypeSubCategory */
?>
<div class="vehicle-type-sub-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'vehicle_typ_sub_id',
            'vehicle_type_id',
            'name',
            'manufacture',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
