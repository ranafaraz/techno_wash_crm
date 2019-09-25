<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseInvoice */
?>
<div class="purchase-invoice-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'purchase_invoice_id',
            'vendor_id',
            'bilty_no',
            'purchase_date',
            'dispatch_date',
            'receiving_date',
            'total_amount',
            'discount',
            'net_total',
            'paid_amount',
            'remaining_amount',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
