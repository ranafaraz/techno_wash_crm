<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
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
        <div class="col-md-4">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
    </div>
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true,'id' => 'description']) ?>
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
<script type="text/javascript">
     function testInput(event) {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/[a-zåäö ]/i);
        return pattern.test(value);
    }
    $('#description').bind('keypress', testInput);
    $("#description").bind('keyup', function (e) {
        $("#description").val(($("#description").val()).toUpperCase());
    });
  //   function forceKeyPressUppercase(e) {
  //       var charInput = e.keyCode;
  //       if((charInput >= 97) && (charInput <= 122)) { // lowercase
  //         if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
  //           var newChar = charInput - 32;
  //           var start = e.target.selectionStart;
  //           var end = e.target.selectionEnd;
  //           e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
  //           e.target.setSelectionRange(start+1, start+1);
  //           e.preventDefault();
  //         }
  //       }
  // }
  //       document.getElementById("category_name").addEventListener("keypress", forceKeyPressUppercase, false);
  //       document.getElementById("category_description").addEventListener("keypress", forceKeyPressUppercase, false);
</script>