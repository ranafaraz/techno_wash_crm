<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\AccountHead;
use common\models\AccountNature;
use common\models\AccountPayable;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Payment */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Payment';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-2" style="display: none">
            <?= $form->field($model, 'transaction_id')->textInput(['readonly'=> true]) ?>

        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'type')->dropDownList([ 'Cash Payment' => 'Cash Payment', 'Bank Payment' => 'Bank Payment', ], ['prompt' => 'Select payment Type']) ?>
        </div>
        <div class="col-md-3">
            <?PHP
            $accountpayable->due_date = date('Y-m-d');?>
            <?= $form->field($accountpayable,'due_date')->widget(
                    DatePicker::className(), [
                    // inline too, not bad
                     'inline' => false, 
                     // modify template for custom rendering
                    // 'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-3">
            <?php
                $natureex=AccountNature::findOne(['name'=>'Expense']);
                $nature_idex=$natureex->id;
                $data1=ArrayHelper::map(AccountHead::find()->where(['nature_id'=>$nature_idex])->andwhere(['!=' , 'account_name' , 'Salaries'])->all(),'id', 'account_name');
            ?>
            <?= $form->field($model, 'debit_account',['options'=>['id'=>'debit_id']])->widget(Select2::classname(), [
                'data' =>$data1,
                'language' => 'en',
                'options' => ['placeholder' => 'Select a state ...'],

                'pluginOptions' => [
                'allowClear' => true
            ],
            ])->label('Paying To');
        ?>
        </div>
        <div class="col-md-3">
             <?PHP
            $model->transactions_date = date('Y-m-d');?>
            <?= $form->field($model,'transactions_date')->widget(
                    DatePicker::className(), [
                    // inline too, not bad
                     'inline' => false, 
                     // modify template for custom rendering
                    // 'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>
        </div>
    </div>
    <div class="row" style="margin: 20px 0px;">
        <div class="col-12 my-auto" style="border-top:2px dashed skyblue;border-bottom:2px dashed skyblue;">
        </div>
    </div>
    <div class="row">
                <div class="col-md-3">
            <?php
                $natureca=AccountNature::findOne(['name'=>'Asset']);
                $nature_idca=$natureca->id;
            ?>

            <?= $form->field($model, 'credit_account')->widget(Select2::classname(), [
                'data' =>ArrayHelper::map(AccountHead::find()->where(['nature_id'=>$nature_idca])->andwhere(['!=' , 'account_name','Account Recievable'])->andwhere(['!=' , 'account_name','Services And Stock'])->all(),'id', 'account_name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select a state ...'],

                'pluginOptions' => [
                'allowClear' => true
            ],
            ])->label('Paying From');
        ?>
        </div>
        
        <div class="col-md-3">
            <?= $form->field($model, 'prev_remaning')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-3">

            <?= $form->field($model, 'debit_amount')->textInput()->label("Total amount") ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'credit_amount')->textInput()->label("Paid amount") ?>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <div id="debitnoamaountmsg" class="text-danger font-weight-bold mx-auto text-center"></div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'narration')->textarea(['rows' => 2])->label('Transaction Narration'); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'payable_narration')->textarea(['rows' => 2])->label('Account Payable Narration') ?>
        </div>
    </div>

    <div class="row" style="display: none">
        <?= $form->field($model, 'updateid')->textInput(['readOnly' => true]) ?>
    </div>    
    
<!--     <?= $form->field($model, 'checkstate')->textInput()?> -->

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success glyphicon glyphicon-plus' : 'btn btn-primary']) ?>
            <a href="./payment" class="btn btn-danger" style="color:white !important" title=""> <i class="glyphicon glyphicon-arrow-left"></i> Back</a>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script=<<<JS
var rec_id;
var deb_id;
$('#payment-receiver_payer_id').change(function(){
    $('#payment-debit_account').change(function(){
        rec_id=$('#payment-receiver_payer_id').val();
        deb_id= $('#payment-debit_account').val();
        $.get('index.php?r=account-payable/get-receiver-id',{rec_id:rec_id,deb_id:deb_id},function(heads){
                var heads = $.parseJSON(heads);
                if(heads.value=="empty"){
                    $("#debitnoamaountmsg").html("Do not have any <b>PAYABLE</b> record againt this account , Make new transaction");
                    $('#payment-updateid').attr('value',"0");
                    
                }else{
                $("#payment-debit_amount").attr('value',heads.amount);
                $('#payment-updateid').attr('value',heads.id);
                }
        });
    });
});
$('#payment-debit_account').change(function(){
    $('#payment-receiver_payer_id').change(function(){
    rec_id=$('#payment-receiver_payer_id').val();
    deb_id= $('#payment-debit_account').val();
    $.get('index.php?r=account-payable/get-receiver-id',{rec_id:rec_id,deb_id:deb_id},function(heads){
    var heads = $.parseJSON(heads);
    if(heads.value=="empty"){
        $("#debitnoamaountmsg").html("Do not have any <b>PAYABLE</b> record againt this account , Make new transaction");
        $('#payment-updateid').attr('value',"0"); 
    }else{ 
        $("#payment-debit_amount").attr('value',heads.amount);
        $('#payment-updateid').attr('value',heads.id);
    }
   });
 });
});
$('#checkamount'). click(function(){
    if($(this). prop("checked") == true){
       var debit_value=$("#payment-debit_amount").val();
       $("#payment-credit_amount").attr("value",debit_value);
        $('#payable_info').css("display","block");
        $('#payment-checkstate').attr('value',"1");
    }else if($(this). prop("checked") == false){
        $('#payable_info').css("display","block");
        $('#payment-checkstate').attr('value',"0");
    }
});

$('#payment-debit_account').on('change',function()
{ 
    var id = $(this).val();
    $.get("./account-payable/get-previous",{id:id},function(data)
    {
        if(data == "empty")
        {
            $('#payment-prev_remaning').attr('value','0');
        }
        else
        {
            data = JSON.parse(data);
            $('#payment-prev_remaning').attr('value',data.sum);
            $('#payment-updateid').attr('value',data.id);
        }
    })
})
// $('#payment-debit_amount').on('input',function()
// {
//     var remaning = $('#payment-remaning').val();
//     var paid = $('#payment-debit_amount').val();
//     var sum = parseInt(remaning) + parseInt(paid);
//     $('#payment-credit_amount').val(sum);
//     })

 $('#payment-account_title_id').on('change',function()
    {
        $('#payment-debit_account').on('change',function()
        {
            var title_id = $('#payment-account_title_id').val();
            var debit = $('#payment-debit_account').val();
            $.get('./payment/get-payment',{title_id:title_id,debit_account:debit},function(data)
            {
                var data = JSON.parse(data);
                $('#payment-prev_remaning').val(data.amount);
            })

        })
    })
JS;
$this->registerJs($script);
?>
