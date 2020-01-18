<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Transactions */
?>
<div class="transactions-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'transaction_id',
            'type',
            'narration:ntext',
            'debit_account',
            'debit_type',
            'credit_account',
            'credit_type',
            'amount',
            'transactions_date',
            'ref_no',
            'created_by',
        ],
    ]) ?>

</div>
