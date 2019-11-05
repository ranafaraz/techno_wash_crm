<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpAttendance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-attendance-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

    <h1 class="well well-sm bg-navy" align="center" style="color:#001F3F; font-family: serif;">Employee Attendance</h1>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_cnic')->widget(yii\widgets\MaskedInput::class, ['options' => ['id' => 'empCnic','autofocus'=> true], 'mask' => '99999-9999999-9']); ?>
        </div>
    </div>
  
    <?php ActiveForm::end(); ?>

</div>
