<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SaleInvoiceHead */
?>
<div class="sale-invoice-head-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'sale_inv_head_id',
            'customer_id',
            'date',
            'total_amount',
            'discount',
            'net_total',
            'paid_amount',
            'remaining_amount',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
