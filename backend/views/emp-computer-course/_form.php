<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpComputerCourse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-computer-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_comp_id')->textInput() ?>

    <?= $form->field($model, 'emp_id')->textInput() ?>

    <?= $form->field($model, 'comp_course_from')->textInput() ?>

    <?= $form->field($model, 'comp_course_to')->textInput() ?>

    <?= $form->field($model, 'comp_course_detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comp_institute')->textInput(['maxlength' => true]) ?>

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
