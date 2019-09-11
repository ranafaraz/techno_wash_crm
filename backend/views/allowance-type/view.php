<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AllowanceType */
?>
<div class="allowance-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'allowance_type_id',
            'branch_id',
            'allowance_name',
            'amount',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
