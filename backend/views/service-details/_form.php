<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Branches;
use common\models\VehicleType;
use common\models\Services;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Service Details</h2>
        </div>
</div>
<div class="services-details-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'branch_id')->dropDownList(
                ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name'),
                ['prompt' => 'Select Branch']
    )?>
        </div>
        <div class="col-md-4">
             <?= $form->field($model, 'vehicle_type_id')->dropDownList(
                ArrayHelper::map(VehicleType::find()->all(),'vehical_type_id','name'),
                ['prompt' => 'Select vehicle type']
    )?>
        </div>
        <div class="col-md-4">
             <?= $form->field($model, 'service_id')->dropDownList(
                ArrayHelper::map(Services::find()->all(),'service_id','service_name'),
                ['prompt' => 'Select Service']
    )?>
        </div>
    </div>
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-md-8">
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
