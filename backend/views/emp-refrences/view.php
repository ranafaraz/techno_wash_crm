<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpRefrences */
?>
<div class="emp-refrences-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_ref_id',
            'emp_id',
            'ref_name',
            'ref_address',
            'ref_occupation',
            'ref_contact',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
