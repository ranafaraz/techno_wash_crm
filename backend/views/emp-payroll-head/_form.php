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
            <?= $form->field($model, 'over_time_pay')->textInput(['id'=>'overTimePay',"onkeypress"=>"return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57"]) ?>
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'bonus')->textInput(['id'=>'bonus',"onkeypress"=>"return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57"]) ?> 
        </div>
    </div>
    <div class="row">
         <div class="col-md-4">
          <?= $form->field($model, 'relaxation')->textInput(['id'=>'relaxation',"onkeypress"=>"return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57"]) ?>  
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'tax_deduction')->textInput(['id'=>'tax_deduction',"onkeypress"=>"return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57"]) ?> 
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'net_total')->textInput(['id'=>'netTotal', 'readonly'=>true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'previous_paid')->textInput(['id'=>'previous_paid', 'value'=>0, 'readonly'=>true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'payable')->textInput(['id'=>'payable', 'value'=>0, 'readonly'=>true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'paid_amount')->textInput(['id'=>'paid_amount' ,"onkeypress"=>"return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57"]) ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'remaining')->textInput(['id'=>'remaining', 'value'=>0, 'readonly'=>true]) ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'status')->textInput(['id'=>'status', 'readonly'=>true]) ?>
            <input type="hidden" name="previous_status" id="previous_status">
        </div>
      </div>
    <div class="row">
       <div class="col-md-12">
            <div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;text-align: center" id="alert">
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
<?php
//$url = \yii\helpers\Url::to("time-table-head/fetch-subjects");

$script = <<< JS
$('#pay_month').on('change',function(){
    var pay_month = $('#pay_month').val();
    var emp_id = $('#emp_id').val();

    $.get('./emp-payroll-head/calculate-pay',{pay_month : pay_month, emp_id : emp_id},function(data){
        
        var data =  $.parseJSON(data);
        console.log(data);
        var status = data[2];
        if(status == 'Paid')
        {
          $("#insert").attr("disabled", true);
          $('#alert').css("display","block");
          $('#alert').html("&ensp;Payroll already Created");

          $('#total_calculated_pay').val(data[0]);
          $('#netTotal').val(data[0]);
          $('#paid_amount').val(data[1]);
          $('#status').val(data[2]);

          $("#paid_amount").attr("disabled", true);
          $("#overTimePay").attr("disabled", true);
          $("#bonus").attr("disabled", true);
          $("#tax_deduction").attr("disabled", true);
          $("#relaxation").attr("disabled", true);
          $("#overTime").attr("disabled", true);
        }
        else if(status == 'Partially Paid' || status == 'Advance')
        {
          $('#total_calculated_pay').val(data[0]);
          $('#previous_paid').val(data[1]);
          var nt = data[3]-data[1];
          $('#payable').val(nt);
           $('#netTotal').val(data[3]);
          $('#status').val(data[2]);

          $("#overTimePay").attr("disabled", true);
          $("#bonus").attr("disabled", true);
          $("#tax_deduction").attr("disabled", true);
          $("#relaxation").attr("disabled", true);
          $("#overTime").attr("disabled", true);
        }
        else
        {
          $('#total_calculated_pay').val(data[0]);
          $('#netTotal').val(data[0]);
          $('#status').val('Unpaid');
        }
    var checkStatus = $('#status').val();
    $('#previous_status').val(checkStatus);
    });   
});
$('#overTimePay,#bonus,#relaxation,#tax_deduction').on('input',function(){
    var caluclate_pay = parseInt($('#total_calculated_pay').val());
var overTime = $('#overTimePay').val();
var bonus  = $('#bonus').val();
var tax_deduction  = $('#tax_deduction').val();
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
if(tax_deduction=="" || tax_deduction==null){
    tax_deduction=0;
}

bonus = parseInt(bonus);
relaxation = parseInt(relaxation);
overTime = parseInt(overTime);
tax_deduction = parseInt(tax_deduction);

net_pay = caluclate_pay +overTime + bonus+ relaxation - tax_deduction;

$('#netTotal').val(net_pay);
if(net_pay<0){
      $("#insert").attr("disabled", true);
      $('#alert').css("display","block");
      $('#alert').html("&ensp;Tax deduction can not be greater than Net Total");

}
else{
    $("#insert").attr("disabled", false);
      $('#alert').css("display","none");
      
}
    });
    
$('#paid_amount').on("input",function(){
    var paidAmount = $('#paid_amount').val();
    var netTotal = parseInt($('#netTotal').val());
    if(paidAmount == "" || paidAmount == null)
    {
      $("#remaining").val("0");
      var preStatus = $('#previous_status').val();
      $('#status').val(preStatus)
    }else{
    var paidAmount = parseInt(paidAmount);
    var payAble = parseInt($("#payable").val());
    if(payAble == "" || payAble == null)
    {
      payAble=0;
      
    }
    if(payAble==0){
    var remaining = netTotal-paidAmount;
    $('#remaining').val(remaining);
    }
    else{
    payAble=parseInt(payAble);
    var remaining = payAble-paidAmount;
    $('#remaining').val(remaining);
    }
    
    if (remaining == 0) {
        $('#status').val('Paid');
    }

    if (remaining == netTotal && paidAmount == 0) {
        $('#status').val('Unpaid');
    } 

    if (paidAmount > 0 && remaining > 0) {
        $('#status').val('Partially Paid');
    }
    if(paidAmount > netTotal){
      $("#insert").attr("disabled", true);
      $('#alert').css("display","block");
      $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
    }
    if (remaining < 0) {
      //$('#insert').hide();
      $("#insert").attr("disabled", true);
      $('#alert').css("display","block");
      $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
    }else{
      $('#alert').css("display","none");
      $("#insert").removeAttr("disabled");
    } 
    }
});
    
JS;
$this->registerJs($script);
?>
</script> 