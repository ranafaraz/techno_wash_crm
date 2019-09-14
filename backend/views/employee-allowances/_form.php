<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Employee;
use common\models\EmployeeAllowances;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model common\models\EmployeeAllowances */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-allowances-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'emp_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Employee::find()->all(), 'emp_id', 'emp_name'),
    'language' => 'en',
    'options' => ['placeholder' => '<--- Select Employee --->'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]);?>

    <?=$form->field($model, 'emp_allowance_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(EmployeeAllowances::find()->all(), 'emp_allowance_id', 'emp_allowance_id'),
    'language' => 'en',
    'options' => ['placeholder' => '<--- Select Emp Allowance --->'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]);?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
