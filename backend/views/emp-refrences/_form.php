<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpRefrences */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-refrences-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emp_id')->textInput() ?>

    <?= $form->field($model, 'ref_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref_occupation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref_contact')->textInput(['maxlength' => true]) ?>

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
