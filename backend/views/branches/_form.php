<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Organization;

/* @var $this yii\web\View */
/* @var $model common\models\Branches */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Branch</h2>
        </div>
</div>
<div class="branches-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'org_id')->dropDownList(
                ArrayHelper::map(Organization::find()->all(),'org_id','org_name'),
                ['prompt'=>'Select Organization',]
    )?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_code')->textInput(['maxlength' => true,'id' => 'branch_code']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true,'id' => 'branch_name']) ?>  
        </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'branch_type')->dropDownList([ 'Franchise' => 'Franchise', 'Group' => 'Group', ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_location')->textInput(['maxlength' => true,'id' => 'branch_location']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_contact_no')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'branch_email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_head_name')->textInput(['maxlength' => true,'id' => 'branch_head_name']) ?>
        </div>
    </div>
    <!-- row 3 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'branch_head_contact_no')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_head_email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            
        </div>
    </div>
    <!-- row 4 close -->

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
    $('#branch_code').bind('keypress', testInput);
    $("#branch_code").bind('keyup', function (e) {
        $("#branch_code").val(($("#branch_code").val()).toUpperCase());
    });
    $('#branch_name').bind('keypress', testInput);
    $("#branch_name").bind('keyup', function (e) {
        $("#branch_name").val(($("#branch_name").val()).toUpperCase());
    });
    $('#branch_location').bind('keypress', testInput);
    $("#branch_location").bind('keyup', function (e) {
        $("#branch_location").val(($("#branch_location").val()).toUpperCase());
    });
    $('#branch_head_name').bind('keypress', testInput);
    $("#branch_head_name").bind('keyup', function (e) {
        $("#branch_head_name").val(($("#branch_head_name").val()).toUpperCase());
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
