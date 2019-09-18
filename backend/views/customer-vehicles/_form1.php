<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VehicleTypeSubCategory;
use yii\helpers\ArrayHelper;
use common\models\Customer;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerVehicles */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Update Customer Vehicle</h2>
    </div>
</div>
<div class="customer-vehicles-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'customer_id')->dropDownList(
                ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name'),
                ['prompt'=>'Select Customer',]
                )?>

    <div class="row">
        <div class="col-md-6">

        <?= $form->field($model, 'vehicle_typ_sub_id')->dropDownList(
                ArrayHelper::map(VehicleTypeSubCategory::find()->all(),'vehicle_typ_sub_id','name'),
                ['prompt'=>'Select Vehicle Sub Type',]
                )?>

    </div>
        <div class="col-md-6">

    <?= $form->field($model, 'registration_no')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-6">

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    </div>
        <div class="col-md-6">

    <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

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
