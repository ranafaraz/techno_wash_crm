<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmpAttendance */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Back', 'url' => ['./emp-atten']];
$this->params['breadcrumbs'][] = ['label' => 'Employee Attendance', 'url' => ['./emp-atten']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-attendance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
