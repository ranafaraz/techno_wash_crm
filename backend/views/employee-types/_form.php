<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\EmployeeTypes */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Employee Type</h2>
    </div>
</div>
<div class="employee-types-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'emp_type_name')->textInput(['maxlength' => true,'id' => 'emp_type_name']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'working_hours')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'duty_time_start')->widget(TimePicker::classname(), []) ?> 
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'duty_time_end')->widget(TimePicker::classname(), []) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'monthly_salary')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true,'id' => 'description']) ?>
        </div>
    </div>

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
    $('#emp_type_name').bind('keypress', testInput);
    $("#emp_type_name").bind('keyup', function (e) {
        $("#emp_type_name").val(($("#emp_type_name").val()).toUpperCase());
    });
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
<?php
$script = <<< JS
$(document).ready(function(){
  $('#employeetypes-duty_time_start').val("Select Start Time..");
  $('#employeetypes-duty_time_end').val("Select End Time..");
  });
JS;
$this->registerJs($script);
?>