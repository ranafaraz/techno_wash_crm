<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CarManufacture */
?>
<div class="car-manufacture-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'car_manufacture_id',
            'vehical_type_id',
            'manufacturer',
            'description',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
