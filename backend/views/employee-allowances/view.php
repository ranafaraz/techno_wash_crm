<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmployeeAllowances */
?>
<div class="employee-allowances-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_allowance_id',
            'emp_id',
            'allowance_type_id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
