<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AccountPayable */
?>
<div class="account-payable-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'amount',
            'accountPayable.account_name',
            'due_date',
            'narration:ntext',
            'created_at',
            'updated_at',
            'updated_by',
            'status',
        ],
    ]) ?>

</div>
