<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpComputerCourse */
?>
<div class="emp-computer-course-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_comp_id',
            'emp_id',
            'comp_course_from',
            'comp_course_to',
            'comp_course_detail',
            'comp_institute',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
