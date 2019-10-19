<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpWorkHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-work-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_w_h_id')->textInput() ?>

    <?= $form->field($model, 'emp_id')->textInput() ?>

    <?= $form->field($model, 'work_from')->textInput() ?>

    <?= $form->field($model, 'work_to')->textInput() ?>

    <?= $form->field($model, 'name_of_employeer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_held')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monthly_gross_salary')->textInput() ?>

    <?= $form->field($model, 'reason_for_leaving')->textInput(['maxlength' => true]) ?>

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
