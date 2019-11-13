<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpLeave */
?>
<div class="emp-leave-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'app_id',
            // 'emp_id',
            'leave_type',
            'starting_date',
            'ending_date',
            'applying_date',
            'no_of_days',
            'leave_purpose',
            'status',
            'remarks',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
        ],
    ]) ?>

</div>
