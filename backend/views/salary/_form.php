<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Employee;
use common\models\EmployeeAllowances;
use common\models\WageType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Salary */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Create New Salary</h2>
        </div>
</div>
<div class="salary-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_id')->dropDownList(
                ArrayHelper::map(Employee::find()->all(),'emp_id','emp_name'),
                ['prompt'=>'Select Employee',]
                )?>

    <?= $form->field($model, 'emp_allowance_id')->dropDownList(
                ArrayHelper::map(EmployeeAllowances::find()->all(),'emp_allowance_id','emp_allowance_id'),
                ['prompt'=>'Select Emp Allowance',]
                )?>

        <?= $form->field($model, 'wage_type_id')->dropDownList(
                ArrayHelper::map(WageType::find()->all(),'wage_type_id','wage_name'),
                ['prompt'=>'Select Wage',]
                )?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
