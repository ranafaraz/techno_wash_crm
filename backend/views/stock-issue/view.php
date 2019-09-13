<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StockIssue */
?>
<div class="stock-issue-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'stock_issue_id',
            'emp_id',
            'stock_id',
            'stock_issue_date',
            'description',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
