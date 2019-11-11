<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpPayrollDetail */
?>
<div class="emp-payroll-detail-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'payroll_detail_id',
            'payroll_head_id',
            'transaction_date',
            'paid_amount',
            'status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
