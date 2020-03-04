<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\VehicleTypeSubCategory;



/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Customer</h2>
        </div>
</div>
<div class="customer-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data','id' => 'dynamic-form']]

    ); ?>

<!-- row 1 start -->
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true,'id' => 'customerName']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'customer_gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'customer_contact_no')->textInput(['id' => 'contact_no','maxlength' => 15,'minlength' => 15 ]) ?>
    </div>
    </div>  
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'customer_occupation')->textInput(['maxlength' => true,'id'=>'customer_occupation']) ?>
        </div>
        <div class="col-md-4" style="margin-top:5px;">
             <?= $form->field($model, 'customer_image')->fileInput(['maxlength' => true]) ?>
         </div>
    </div>
  <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Customer Vehicle</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelCustomerVehicles[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'vehicle_typ_sub_id',  
                    'registration_no',
                    'color',
                    // 'image',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelCustomerVehicles as $i => $value): ?>
                <div class="item panel panel-primary"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Customer Vehicle</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            
                        ?>
                        <div class="row">
                            <div class="col-sm-3">
                                 <?= $form->field($value, "[{$i}]vehicle_typ_sub_id")->dropDownList(
                                    ArrayHelper::map(VehicleTypeSubCategory::find()->all(),'vehicle_typ_sub_id','name'),
                                        ['prompt'=>'Select Vehicle Sub Type']
                                )?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]registration_no")->textInput(['class' => 'form-control regnoclass' , 'id' => "REGNO"]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]color")->textInput(['class' => 'form-control colorveh' , 'id' => 'COLOR']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?php //$form->field($value, "[{$i}]image")->fileInput() ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
            </div>
        </div>  
    </div>
    <!-- fuel consumption dynamic form close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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

$('#customerName').bind('keypress', testInput);
$('#fatherName').bind('keypress', testInput);
// $('#REGNO').bind('keypress', testInput);
$('#COLOR').bind('keypress', testInput);

// $("#REGNO").bind('keyup', function (e) {
//     // if (e.which >= 97 && e.which <= 122) {
//     //     var newKey = e.which - 32;
//     //     // I have tried setting those
//     //     e.keyCode = newKey;
//     //     e.charCode = newKey;
//     // }

//     $("#REGNO").val(($("#REGNO").val()).strtoupper());
// });
$("#COLOR").bind('keyup', function (e) {
    // if (e.which >= 97 && e.which <= 122) {
    //     var newKey = e.which - 32;
    //     // I have tried setting those
    //     e.keyCode = newKey;
    //     e.charCode = newKey;
    // }

    $("#COLOR").val(($("#COLOR").val()).toUpperCase());
});
$("#customerName").bind('keyup', function (e) {
    // if (e.which >= 97 && e.which <= 122) {
    //     var newKey = e.which - 32;
    //     // I have tried setting those
    //     e.keyCode = newKey;
    //     e.charCode = newKey;
    // }

    $("#customerName").val(($("#customerName").val()).toUpperCase());
});
$("#fatherName").bind('keyup', function (e) {
    // if (e.which >= 97 && e.which <= 122) {
    //     var newKey = e.which - 32;
    //     // I have tried setting those
    //     e.keyCode = newKey;
    //     e.charCode = newKey;
    // }

    $("#fatherName").val(($("#fatherName").val()).toUpperCase());
});
$("#customer_address").bind('keyup', function (e) {
    // if (e.which >= 97 && e.which <= 122) {
    //     var newKey = e.which - 32;
    //     // I have tried setting those
    //     e.keyCode = newKey;
    //     e.charCode = newKey;
    // }

    $("#customer_address").val(($("#customer_address").val()).toUpperCase());
});
$("#customer_occupation").bind('keyup', function (e) {
    // if (e.which >= 97 && e.which <= 122) {
    //     var newKey = e.which - 32;
    //     // I have tried setting those
    //     e.keyCode = newKey;
    //     e.charCode = newKey;
    // }

    $("#customer_occupation").val(($("#customer_occupation").val()).toUpperCase());

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

<?php 
$script = <<< JS
$(document).ready(function(){
  $("#contact_no").val("+92");
});
$("#contact_no").on("keypress", function(e){
  var input = $(this).val();
  if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {return false;}
  if(input==''){
    $(this).val('+92');
  }else{
    if(input.length == 3){
      $("#contact_no").val(input + '-');
    }
    if(input.length == 7){
      $("#contact_no").val(input + '-');
    }
    if(input.length <= 15){
      
    }
  }
});
$(function () {
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
         $( ".regnoclass" ).each(function() {
             $( ".regnoclass" ).keyup(function() {
            $(this).val($(this).val().toUpperCase());
            });
            $('.regnoclass').keypress(function(e){
              var keyCode = e.keyCode || e.which;
            if ((keyCode >= 33 && keyCode <=44) || (keyCode >= 46 && keyCode <=47) || (keyCode >= 58 && keyCode <=64) || (keyCode >= 91 && keyCode <=96) || (keyCode >= 123 && keyCode <= 126)) { 
              return false;
            }
            });
        });
        $( ".colorveh" ).each(function() {
            $(".colorveh").keyup(function(){
                $(this).val($(this).val().toUpperCase());
                });
                  $(".color_veh").keypress(function(e){
                    var keyCode = e.keyCode || e.which;
                if ((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 45)) { 
                  return true;
                }else{
                  return false;
                  }
                });
        });
    });
});
JS;
$this->registerJS($script);
 ?>