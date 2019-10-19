<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpWorkHistory */
?>
<div class="emp-work-history-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_w_h_id',
            'emp_id',
            'work_from',
            'work_to',
            'name_of_employeer',
            'position_held',
            'monthly_gross_salary',
            'reason_for_leaving',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
