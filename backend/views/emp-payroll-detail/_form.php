<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpPayrollDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-payroll-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payroll_head_id')->textInput() ?>

    <?= $form->field($model, 'transaction_date')->textInput() ?>

    <?= $form->field($model, 'paid_amount')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Unpaid' => 'Unpaid', 'Paid' => 'Paid', 'Partially Paid' => 'Partially Paid', 'Advance' => 'Advance', ], ['prompt' => '']) ?>

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
