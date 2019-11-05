<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmpAttendance */

$this->title = 'Update Emp Attendance: ' . $model->att_id;
$this->params['breadcrumbs'][] = ['label' => 'Emp Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->att_id, 'url' => ['view', 'id' => $model->att_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="emp-attendance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
