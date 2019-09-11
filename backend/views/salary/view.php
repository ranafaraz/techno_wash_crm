<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Salary */
?>
<div class="salary-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'salary_id',
            'emp_id',
            'emp_allowance_id',
            'wage_type_id',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
