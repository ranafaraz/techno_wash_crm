<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Vendor */
?>
<div class="vendor-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'vendor_id',
            'branch_id',
            'name',
            'ntn',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
