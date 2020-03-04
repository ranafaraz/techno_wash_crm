<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\StockType;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Manufacture */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Manufacture</h2>
        </div>
</div>
<div class="manufacture-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-md-6">
             <?= $form->field($model, 'stock_type_id')->dropDownList(
                ArrayHelper::map(StockType::find()->all(),'stock_type_id','name'),
                ['prompt'=>'Select Stock Type']
                )?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'id' => 'manufacture_name']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'description')->textArea(['rows' => 3,'id' => 'manufacture_description']) ?>
        </div>
    </div>

   <!-- products dynamic form -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="glyphicon glyphicon-envelope"></i> 
                        Product Details 
                </h4>
            </div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                //'limit' => 1000, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelProducts[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'product_name', 
                    'description',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelProducts as $e => $product): ?>
                <div class="item panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Product Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                 <?= $form->field($product, "[{$e}]product_name")->textInput(['id' => 'product_name','class' => 'form-control prodclass'])?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($product, "[{$e}]description")->textInput(['rows'=>5,'id' => 'product_description','class' => 'form-control proddescription']) ?>
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
        document.getElementById("product_description").addEventListener("keypress", forceKeyPressUppercase, false);
</script>
<?php 
$script = <<< JS
$(function () {
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
         $( ".prodclass" ).each(function() {
             $( ".prodclass" ).keyup(function() {
            $(this).val($(this).val().toUpperCase());
            });
            $('.prodclass').keypress(function(e){
              var keyCode = e.keyCode || e.which;
            if ((keyCode >= 33 && keyCode <=44) || (keyCode >= 46 && keyCode <=47) || (keyCode >= 58 && keyCode <=64) || (keyCode >= 91 && keyCode <=96) || (keyCode >= 123 && keyCode <= 126)) { 
              return false;
            }
            });
        });
        $( ".proddescription" ).each(function() {
             $( ".proddescription" ).keyup(function() {
            $(this).val($(this).val().toUpperCase());
            });
            $('.proddescription').keypress(function(e){
              var keyCode = e.keyCode || e.which;
            if ((keyCode >= 33 && keyCode <=44) || (keyCode >= 46 && keyCode <=47) || (keyCode >= 58 && keyCode <=64) || (keyCode >= 91 && keyCode <=96) || (keyCode >= 123 && keyCode <= 126)) { 
              return false;
            }
            });
        });
    });
});
JS;
$this->registerJS($script);
 ?>
