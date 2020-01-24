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
$customerId = $model->customer_id;
$customerName = $model->customer_name;
?>
<div class="container-fluid">
    <div class="row customer-form" style="background-color:#d3d3d3;padding:20px;border-top:3px solid #367FA9;">
        <?php $form = ActiveForm::begin(
            ['options' => ['enctype' => 'multipart/form-data','id' => 'dynamic-form']]

        ); ?>
        <div class="row" style="border-bottom:1px solid #367FA9;margin-bottom:10px;">
            <div class="col-md-12">
                <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Customer (<b><?php echo $customerName; ?></b>)</h2>
            </div>
        </div>
        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-3" style="background-color:#f5f5f5;padding:10px;">
                <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true,'id' => 'customerName']) ?>
                <?= $form->field($model, 'customer_father_name')->textInput(['maxlength' => true,'id'=>'fatherName']) ?>
                <?= $form->field($model, 'customer_gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => 'Select Gender']) ?>
                <?= $form->field($model, 'customer_cnic')->widget(yii\widgets\MaskedInput::class, ['mask' => '99999-9999999-9']) ?>
            </div>
            <div class="col-md-3" style="background-color:#f5f5f5;padding:10px;">
                <?= $form->field($model, 'customer_contact_no')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
                <?= $form->field($model, 'customer_age')->textInput() ?>
                <?= $form->field($model, 'customer_email')->widget(yii\widgets\MaskedInput::class, [
                    'name' => 'input-36',
                    'clientOptions' => [
                        'alias' =>  'email'
                    ],
                ]) ?>
                <?= $form->field($model, 'customer_address')->textInput(['maxlength' => true,'id'=>'customer_address']) ?> 
            </div>
            <div class="col-md-3" style="background-color:#f5f5f5;padding:10px;height:316px;">
                <?= $form->field($model, 'customer_occupation')->textInput(['maxlength' => true,'id'=>'customer_occupation']) ?>
                <?= $form->field($model, 'customer_whatsapp')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
                <?= $form->field($model, 'customer_social_media')->textInput(['maxlength' => true]) ?>
                <label>Registration Date</label>
                    <?= DateTimePicker::widget([
                        'model' => $model,
                        'attribute' => 'customer_registration_date',
                        'language' => 'en',
                        'size' => 'ms',
                        'clientOptions' => [
                            'autoclose' => true,
                            'convertFormat' => false,                    
                            'format' => 'yyyy-mm-dd  hh:ii:ss',
                            'todayBtn' => true
                        ]
                    ]);?>
            </div>
            <div class="col-md-3" style="text-align: center;margin-top:25px;">
                <img src="<?php echo $model->customer_image; ?>" class="img-thumbnail" style="width:160px; height:150px;border:1px solid #ffffff;"/>
                    <?= $form->field($model, 'customer_image')->fileInput(['maxlength' => true,'style' => 'margin-left:auto','margin-right:auto']) ?>
            </div>
        </div>
        <div class="row" style="background-color:;border-top:1px solid #ecf0f5 ;padding-top:15px;">
            <div class="col-md-12">
                <?php if (!Yii::$app->request->isAjax){ ?>
                    <div class="form-group" style="float: right;">            
                        <a href="./sale-invoice-view?customer_id=<?php echo $customerId;?>&regno=<?=$regno?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="glyphicon glyphicon-open"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-xs' : 'btn btn-primary btn-xs']) ?>
                    </div>
                <?php } ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
</div>
</div>
<script>
   function testInput(event) {
   var value = String.fromCharCode(event.which);
   var pattern = new RegExp(/[a-zåäö ]/i);
   return pattern.test(value);
}

$('#customerName').bind('keypress', testInput);
$('#fatherName').bind('keypress', testInput);

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
</script>
<?php 
$script = <<< JS
  $( "#customerName" ).keyup(function() {
    $(this).val($(this).val().toUpperCase());
    });
    $( "#fatherName" ).keyup(function() {
    $(this).val($(this).val().toUpperCase());
    });
    $( "#customer_address" ).keyup(function() {
    $(this).val($(this).val().toUpperCase());
    });
JS;
$this->registerJS($script);
 ?>