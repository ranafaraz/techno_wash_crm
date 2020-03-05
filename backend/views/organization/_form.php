<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Organization */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Organization</h2>
        </div>
</div>
<div class="organization-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'org_name')->textInput(['maxlength' => true,'id' => 'org_name']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_address')->textInput(['maxlength' => true,'id' => 'org_address']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_owner')->textInput(['maxlength' => true,'id' => 'org_owner']) ?>
        </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'org_contact')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_head_office')->textInput(['maxlength' => true,'id' => 'org_head_office']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_owner_cnic')->widget(yii\widgets\MaskedInput::class, ['mask' => '99999-9999999-9']) ?>
        </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'business_ntn')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_logo')->fileInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            
        </div>
    </div>
    <!-- row 3 close -->

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
    $('#org_name').bind('keypress', testInput);
    $("#org_name").bind('keyup', function (e) {
        $("#org_name").val(($("#org_name").val()).toUpperCase());
    });
    $('#org_address').bind('keypress', testInput);
    $("#org_address").bind('keyup', function (e) {
        $("#org_address").val(($("#org_address").val()).toUpperCase());
    });
    $('#org_owner').bind('keypress', testInput);
    $("#org_owner").bind('keyup', function (e) {
        $("#org_owner").val(($("#org_owner").val()).toUpperCase());
    });
    $('#org_head_office').bind('keypress', testInput);
    $("#org_head_office").bind('keyup', function (e) {
        $("#org_head_office").val(($("#org_head_office").val()).toUpperCase());
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
