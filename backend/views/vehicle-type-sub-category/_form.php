<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\VehicleType;
use common\models\CarManufacture;


/* @var $this yii\web\View */
/* @var $model common\models\VehicleTypeSubCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Model</h2>
    </div>
</div>
<div class="vehicle-type-sub-category-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
    if(isset($_GET['carmanu'])){
          $carmanu = $_GET['carmanu'];
          $vehtyp = $_GET['vehtyp'];
          $custVehid = $_GET['custVehid']; 
        ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($modelVTSCH, 'vehicle_type_id')->dropDownList(
                ArrayHelper::map(VehicleType::find()->all(),'vehical_type_id','name'),
                    ['prompt'=>'Select Vehicle Type', 'value' => $vehtyp]
            )?>
            </div>
            <div class="col-md-3">
                <?= $form->field($modelVTSCH, 'manufacture')->dropDownList(
                ArrayHelper::map(CarManufacture::find()->all(),'car_manufacture_id','manufacturer'),
                    ['prompt'=>'Select Manufacturer', 'value' => $carmanu]
            )?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-1 invisible" style="text-align: right;">
                <?= $form->field($model, 'custVehid')->textInput(['value' => $custVehid])?>
            </div>
        </div>
    <?php } ?>
    
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
