<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpTraining */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-training-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_trainind_id')->textInput() ?>

    <?= $form->field($model, 'emp_id')->textInput() ?>

    <?= $form->field($model, 'train_from_date')->textInput() ?>

    <?= $form->field($model, 'train_to_date')->textInput() ?>

    <?= $form->field($model, 'training_course')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'training_institute')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'training_certificate')->textInput(['maxlength' => true]) ?>

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
