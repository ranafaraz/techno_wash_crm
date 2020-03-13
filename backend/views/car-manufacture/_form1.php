<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\helpers\ArrayHelper;
// use wbraganca\dynamicform\DynamicFormWidget;
// use common\models\VehicleType;

/* @var $this yii\web\View */
/* @var $model common\models\CarManufacture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-manufacture-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'manufacturer')->textInput(['maxlength' => true,'id' => 'manufacture_name']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true,'id' => 'manufacture_description']) ?>
        </div>
    </div>
    <!-- row 1 close -->
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
    $('#manufacture_name').bind('keypress', testInput);
    $("#manufacture_name").bind('keyup', function (e) {
        $("#manufacture_name").val(($("#manufacture_name").val()).toUpperCase());
    });
    $('#manufacture_description').bind('keypress', testInput);
    $("#manufacture_description").bind('keyup', function (e) {
        $("#manufacture_description").val(($("#manufacture_description").val()).toUpperCase());
    });

    function forceKeyPressUppercase(e) {
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
        document.getElementById("product_name").addEventListener("keypress", forceKeyPressUppercase, false);
</script>
<?php 
$script = <<< JS
// $(function () {
//     $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
//          $( ".prodclass" ).each(function() {
//              $( ".prodclass" ).keyup(function() {
//             $(this).val($(this).val().toUpperCase());
//             });
//             $('.prodclass').keypress(function(e){
//               var keyCode = e.keyCode || e.which;
//             if ((keyCode >= 33 && keyCode <=44) || (keyCode >= 46 && keyCode <=47) || (keyCode >= 58 && keyCode <=64) || (keyCode >= 91 && keyCode <=96) || (keyCode >= 123 && keyCode <= 126)) { 
//               return false;
//             }
//             });
//         });
//     });
// });
JS;
$this->registerJS($script);
 ?>
