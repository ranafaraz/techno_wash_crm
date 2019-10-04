<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Branches;
use common\models\VehicleType;
/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
           <?= $form->field($model, 'branch_id')->dropDownList(
                ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name')
                )?> 
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'vehicle_type_id')->dropDownList(
                ArrayHelper::map(VehicleType::find()->all(),'vehical_type_id','name'),
                ['prompt' => 'Select Vehicle Type']
                )?> 
        </div>
    </div>
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-4">
           <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <!-- row 2 close -->

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
