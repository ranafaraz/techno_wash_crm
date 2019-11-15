<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Employee;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\EmpPayrollHead */
/* @var $form yii\widgets\ActiveForm */
?>
<?php  
    $branch_id = Yii::$app->user->identity->branch_id;
?>
<div class="emp-payroll-head-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
           <?= $form->field($model, 'emp_id')->dropDownList(
                ArrayHelper::map(Employee::find()->where(['branch_id' => $branch_id ])->all(),'emp_id','emp_name'),
                ['prompt'=>'Select employee', 'id'=> 'emp_id']
    )?> 
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'payment_month')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'Starting Date'), 'id' => 'pay_month'],
                    'attribute2'=>'to_date',
                    //'type' => DatePicker::TYPE_RANGE,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startView'=>'year',
                        'minViewMode'=>'months',
                        'format' => 'mm-yyyy'
                    ]
                ])  ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'total_calculated_pay')->textInput(['id'=>'total_calculated_pay', 'readonly'=>true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'over_time')->textInput(['id'=>'overTime']) ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'over_time_pay')->textInput(['id'=>'overTimePay']) ?>
        </div>
         <div class="col-md-4">
           <?= $form->field($model, 'bonus')->textInput(['id'=>'bonus']) ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
           <?= $form->field($model, 'tax_deduction')->textInput(['id'=>'tax_deduction']) ?> 
        </div>
         <div class="col-md-4">
          <?= $form->field($model, 'relaxation')->textInput(['id'=>'relaxation']) ?>  
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'net_total')->textInput(['id'=>'netTotal', 'readonly'=>true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'paid_amount')->textInput(['id'=>'paid_amount']) ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'remaining')->textInput(['id'=>'remaining', 'readonly'=>true]) ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'status')->textInput(['id'=>'status', 'readonly'=>true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="hidden" id="temp">
        </div>
    </div>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php
//$url = \yii\helpers\Url::to("time-table-head/fetch-subjects");

$script = <<< JS
$('#pay_month').on('change',function(){
    var pay_month = $('#pay_month').val();
    var emp_id = $('#emp_id').val();
   
    $.get('./emp-payroll-head/calculate-pay',{pay_month : pay_month, emp_id : emp_id},function(data){
        
        var data =  $.parseJSON(data);
        $('#total_calculated_pay').val(data);
        $('#temp').val(data);
        $('#netTotal').val(data);
        $('#status').val('Unpaid');
   
    });   
});
$('#overTimePay').on('input',function(){
    var caluclate_pay = parseInt($('#total_calculated_pay').val());
var overTime = $('#overTimePay').val();
var bonus  = $('#bonus').val();
var   relaxation  = $('#relaxation').val();
if(bonus=="" || bonus==null){
    bonus=0;
}
if(relaxation=="" || relaxation==null){
    relaxation=0;
}
if(overTime=="" || overTime==null){
    overTime=0;
}

bonus = parseInt(bonus);
relaxation = parseInt(relaxation);
overTime = parseInt(overTime);

net_pay = caluclate_pay +overTime + bonus+ relaxation;

$('#netTotal').val(net_pay);
    });
    $('#bonus').on('input',function(){
    var caluclate_pay = parseInt($('#total_calculated_pay').val());
var overTime = $('#overTimePay').val();
var bonus  = $('#bonus').val();
var   relaxation  = $('#relaxation').val();
if(bonus=="" || bonus==null){
    bonus=0;
}
if(relaxation=="" || relaxation==null){
    relaxation=0;
}
if(overTime=="" || overTime==null){
    overTime=0;
}

bonus = parseInt(bonus);
relaxation = parseInt(relaxation);
overTime = parseInt(overTime);

net_pay = caluclate_pay +overTime + bonus+ relaxation;

$('#netTotal').val(net_pay);
    });
        $('#relaxation').on('input',function(){
    var caluclate_pay = parseInt($('#total_calculated_pay').val());
var overTime = $('#overTimePay').val();
var bonus  = $('#bonus').val();
var   relaxation  = $('#relaxation').val();
if(bonus=="" || bonus==null){
    bonus=0;
}
if(relaxation=="" || relaxation==null){
    relaxation=0;
}
if(overTime=="" || overTime==null){
    overTime=0;
}

bonus = parseInt(bonus);
relaxation = parseInt(relaxation);
overTime = parseInt(overTime);

net_pay = caluclate_pay +overTime + bonus+ relaxation;

$('#netTotal').val(net_pay);
    });
    $('#paid_amount').on('input',function(){
    var paid_amount = $('#paid_amount').val();
    var netTotal = $('#netTotal').val();
    
    var remaining = netTotal - paid_amount;

    $('#remaining').val(remaining);

    if (remaining == 0) {
        $('#status').val('Paid');
    }

    if (remaining == netTotal && paid_amount == 0) {
        $('#status').val('Unpaid');
    } 

    if (paid_amount > 0 && remaining > 0) {
        $('#status').val('Partially Paid');
    }

    // if (remaining < 0) {
    //   //$('#insert').hide();
    //   $("#insert").attr("disabled", true);
    //   $('#alert').css("display","block");
    //   $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
    // }else{
    //   $('#alert').css("display","none");
    //   $("#insert").removeAttr("disabled");
    // }
    
     
});
    


JS;
$this->registerJs($script);
?>
</script> 
<script>
    
</script>