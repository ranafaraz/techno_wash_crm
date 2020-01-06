<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VehicleTypeSubCategory;
use yii\helpers\ArrayHelper;
use common\models\Customer;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerVehicles */
/* @var $form yii\widgets\ActiveForm */

$customerId = $_GET['id'];  
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Customer Vehicle</h2>
        </div>
</div>
<div class="customer-vehicles-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'customer_id')->dropDownList(
                ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name'),["disabled"=>"disabled" ]
                )?>
            </div>
            <div class="col-md-6">

                <?= $form->field($model, 'vehicle_typ_sub_id')->dropDownList(
                ArrayHelper::map(VehicleTypeSubCategory::find()->all(),'vehicle_typ_sub_id','name'),
                ['prompt'=>'Select Vehicle Sub Type',]
                )?>

            </div>
        </div>

         <!-- row 1 close -->

        <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'registration_no')->textInput(['maxlength' => true,'id' => 'REGNO']) ?>

            </div>
            <div class="col-md-6">

                <?= $form->field($model, 'color')->textInput(['id' => 'color']) ?>

            </div>
        </div>
         <!-- row 2 close -->

        <div class="row">    
            <div class="col-md-6">

                <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

             </div>
        </div>

        <!-- row 3 close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
            <a href="./sale-invoice-view?customer_id=<?php echo $customerId;?>&regno=<?=$regno?>" class="btn btn-danger"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
	        <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-save"></i> Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script>
   function testInput(event) {
       var value = String.fromCharCode(event.which);
       var pattern = new RegExp(/[a-zåäö ]/i);
       return pattern.test(value);
    }

$('#COLOR').bind('keypress', testInput);

$("#COLOR").bind('keyup', function (e) {
    $("#COLOR").val(($("#COLOR").val()).toUpperCase());
});

  function forceKeyPressUppercase(e)
  {
    var charInput = e.keyCode;
    if((charInput >= 97) && (charInput <= 122)) { // lowercase
      if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
        var newChar = charInput - 32;
        var start = e.target.selectionStart;
        var end = e.target.selectionEnd;
        e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
        e.target.setSelectionRange(start+1, start+1);
        e.preventDefault();
      }
    }
  }

  document.getElementById("REGNO").addEventListener("keypress", forceKeyPressUppercase, false);
  
</script>
