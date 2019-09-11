<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_type_id')->textInput() ?>

    <?= $form->field($model, 'branch_id')->textInput() ?>

    <?= $form->field($model, 'salary_id')->textInput() ?>

    <?= $form->field($model, 'emp_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_cnic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_father_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_contact')->textInput() ?>

    <?= $form->field($model, 'emp_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'emp_qualification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'joining_date')->textInput() ?>

    <?= $form->field($model, 'learning_date')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>

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
