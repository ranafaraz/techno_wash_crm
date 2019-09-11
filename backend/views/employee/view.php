<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
?>
<div class="employee-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_id',
            'emp_type_id',
            'branch_id',
            'salary_id',
            'emp_name',
            'emp_cnic',
            'emp_father_name',
            'emp_contact',
            'emp_email:email',
            'emp_image',
            'emp_gender',
            'emp_qualification',
            'emp_reference',
            'joining_date',
            'learning_date',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
