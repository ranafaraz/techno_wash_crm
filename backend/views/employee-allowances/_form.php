<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Employee;
use common\models\AllowanceType;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\EmployeeAllowances */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-allowances-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_id')->dropDownList(
                ArrayHelper::map(Employee::find()->all(),'emp_id','emp_name'),
                ['prompt'=>'Select Employee',]
                )?>

        <?= $form->field($model, 'allowance_type_id')->dropDownList(
                ArrayHelper::map(AllowanceType::find()->all(),'allowance_type_id','allowance_name'),
                ['prompt'=>'Select Allowance',]
                )?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
