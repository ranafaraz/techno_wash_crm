<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Payment */
?>
<div class="payment-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'transaction_id',
            'branch_id',
            'type',
            'narration:ntext',
            'account_head_id',
            'total_amount',
            'amount',
            'remaining',
            'transactions_date',
            'head_id',
            'ref_no',
            'ref_name',
            'created_by',
        ],
    ]) ?>

</div>
