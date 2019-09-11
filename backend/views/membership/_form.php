<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Membership */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="membership-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'card_type_id')->textInput() ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'customer_vehicle_id')->textInput() ?>

    <?= $form->field($model, 'membership_start_date')->textInput() ?>

    <?= $form->field($model, 'membership_end_date')->textInput() ?>

    <?= $form->field($model, 'card_issued_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car_registration_no')->textInput(['maxlength' => true]) ?>

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
