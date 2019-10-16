<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpCertification */
?>
<div class="emp-certification-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_certificate_id',
            'emp_id',
            'certificate_from',
            'certificate_to',
            'certificate_course_detail',
            'certificate_insititute',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
