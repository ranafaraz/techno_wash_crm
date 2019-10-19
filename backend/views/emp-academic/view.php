<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpAcademic */
?>
<div class="emp-academic-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_academic_id',
            'emp_id',
            'from_date',
            'to_date',
            'institute',
            'degree_diploma',
            'division_grade',
            'major_subjects',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
