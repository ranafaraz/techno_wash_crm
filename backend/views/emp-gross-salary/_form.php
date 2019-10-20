<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpGrossSalary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-gross-salary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_id')->textInput() ?>

    <?= $form->field($model, 'gross_salary')->textInput() ?>

    <?= $form->field($model, 'bonus')->textInput() ?>

    <?= $form->field($model, 'car')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car_fuel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car_maintenance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'retirement_benefits')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'others')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
