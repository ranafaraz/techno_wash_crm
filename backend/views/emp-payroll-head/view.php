<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpPayrollHead */
?>
<div class="emp-payroll-head-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'payroll_head_id',
            'branch_id',
            'emp_id',
            'payment_month',
            'total_calculated_pay',
            'over_time:datetime',
            'over_time_pay',
            'bonus',
            'tax_deduction',
            'relaxation',
            'net_total',
            'paid_amount',
            'remaining',
            'status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
