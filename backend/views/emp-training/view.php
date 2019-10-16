<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpTraining */
?>
<div class="emp-training-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_trainind_id',
            'emp_id',
            'train_from_date',
            'train_to_date',
            'training_course',
            'training_institute',
            'training_certificate',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
