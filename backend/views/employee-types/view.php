<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmployeeTypes */
?>
<div class="employee-types-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'emp_type_id',
            'emp_type_name',
            'description',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
