<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
?>
<div class="stock-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'stock_id',
            'stock_type_id',
            'purchase_invoice_id',
            'manufacture_id',
            'barcode',
            'name',
            'expiry_date',
            'original_price',
            'purchase_price',
            'selling_price',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
