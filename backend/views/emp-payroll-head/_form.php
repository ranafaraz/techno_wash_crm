<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpPayrollHead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-payroll-head-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'branch_id')->textInput() ?>

    <?= $form->field($model, 'emp_id')->textInput() ?>

    <?= $form->field($model, 'payment_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_calculated_pay')->textInput() ?>

    <?= $form->field($model, 'over_time')->textInput() ?>

    <?= $form->field($model, 'over_time_pay')->textInput() ?>

    <?= $form->field($model, 'bonus')->textInput() ?>

    <?= $form->field($model, 'tax_deduction')->textInput() ?>

    <?= $form->field($model, 'relaxation')->textInput() ?>

    <?= $form->field($model, 'net_total')->textInput() ?>

    <?= $form->field($model, 'paid_amount')->textInput() ?>

    <?= $form->field($model, 'remaining')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Uapaid' => 'Uapaid', 'Paid' => 'Paid', 'Partially Paid' => 'Partially Paid', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
