<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Service</h2>
        </div>
</div>
<div class="services-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'service_name')->textInput(['maxlength' => true,'id' => 'service_name']) ?>
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
    $('#service_name').bind('keypress', testInput);
    $("#service_name").bind('keyup', function (e) {
        $("#service_name").val(($("#service_name").val()).toUpperCase());
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
