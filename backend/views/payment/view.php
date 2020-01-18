<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Payment */
?>
<div class="payment-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'receiver_payer_id',
            'transaction_id',
            'type',
            'narration:ntext',
            'debit_account',
            'debit_amount',
            'credit_account',
            'credit_amount',
            'transactions_date',
            'ref_no',
            'created_by',
        ],
    ]) ?>

</div>
