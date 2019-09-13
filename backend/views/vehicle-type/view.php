<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\VehicleType */
?>
<div class="vehicle-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'vehical_type_id',
            'name',
            'description:ntext',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
