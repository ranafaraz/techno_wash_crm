<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SaleInvoiceStockDetail */
?>
<div class="sale-invoice-stock-detail-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'sale_inv_stock_detail_id',
            'sale_inv_head_id',
            'stock_id',
            'discount_per_item',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
