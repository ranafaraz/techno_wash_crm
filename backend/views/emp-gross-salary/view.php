<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpGrossSalary */
?>
<div class="emp-gross-salary-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_gro_sal_id',
            'emp_id',
            'gross_salary',
            'bonus',
            'car',
            'car_fuel',
            'car_maintenance',
            'retirement_benefits',
            'others',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
