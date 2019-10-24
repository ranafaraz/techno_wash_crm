<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SaleInvoiceDetail */
?>
<div class="sale-invoice-detail-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sale_inv_ser_detail_id',
            'sale_inv_head_id',
            'customer_vehicle_id',
            'item_id',
            'item_type',
            'discount_per_service',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
