<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpAttendanceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-attendance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'att_id') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'emp_id') ?>

    <?= $form->field($model, 'att_date') ?>

    <?= $form->field($model, 'check_in') ?>

    <?php // echo $form->field($model, 'check_out') ?>

    <?php // echo $form->field($model, 'attendance') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
