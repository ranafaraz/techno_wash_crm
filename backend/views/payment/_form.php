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
// $this->title = 'Payment';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="containe-fluid">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#367FA9;">
                        Payments
                    </h3>
                    <div class="row" style="padding:16px;">
                        <div class="col-md-4" style="border-top:2px solid #D2D6DE;padding:10px;">
                            <?PHP
                                $model->transactions_date = date('Y-m-d');?>
                                <?= $form->field($model,'transactions_date')->widget(
                                    DatePicker::className(), [
                                     'inline' => false, 
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]);
                            ?>
                            <?= $form->field($model, 'type')->dropDownList([ 'Cash' => 'Cash', 'Bank' => 'Bank', ]) ?>
                            <?php
                                $natureca=AccountNature::findOne(['name'=>'Expense']);
                                $nature_idca=$natureca->id;
                            ?>
                            <?= $form->field($model, 'account_head_id')->widget(Select2::classname(), [
                                'data' =>ArrayHelper::map(AccountHead::find()->where(['nature_id'=>$nature_idca])->andwhere(['!=' , 'account_name' , 'Salaries'])->all(),'id', 'account_name'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select...'],

                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Paying For');
                            ?>
                        </div>
                        <div class="col-md-4" style="border-top:2px solid #D2D6DE;border-right:2px solid #D2D6DE;padding:10px;">
                            
                            <?= $form->field($model, 'prev_remaning')->textInput(['readonly' => true]) ?>
                            <?php
                            $accountpayable->due_date = date('Y-m-d');?>
                            <?= $form->field($accountpayable,'due_date')->widget(
                                    DatePicker::className(), [
                                     'inline' => false, 
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4" style="padding:10px;background-color:#F5F5F5;">
                            <?= $form->field($model, 'debit_amount')->textInput(['value'=>0])->label("Total amount") ?>
                             <?= $form->field($model, 'credit_amount')->textInput(['value'=>0])->label("Paid amount") ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="debitnoamaountmsg" class="text-danger font-weight-bold mx-auto text-center"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                           <?php if (!Yii::$app->request->isAjax){ ?>
                                <div class="form-group" style="float: right;">
                                    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success glyphicon glyphicon-plus' : 'btn btn-primary']) ?>
                                    <!-- <a href="./payment" class="btn btn-danger" style="color:white !important" title=""> <i class="glyphicon glyphicon-arrow-left"></i> Back</a> -->
                                </div>
                            <?php } ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header">
                    <h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#00A65A;">
                                Narrations
                    </h3><br>
                    <?= $form->field($model, 'narration')->textarea(['rows' => 2])->label('Transaction Narration'); ?>
                    <?= $form->field($model, 'payable_narration')->textarea(['rows' => 2])->label('Account Payable Narration') ?>
                    <span style="display: none;">
                        
                        <?= $form->field($model, 'updateid')->textInput(['readOnly' => true]) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>   
<!--     <?= $form->field($model, 'checkstate')->textInput()?> -->
<?php
$script=<<<JS
var rec_id;
var deb_id;
// $('#payment-receiver_payer_id').change(function(){
//     $('#payment-debit_account').change(function(){
//         rec_id=$('#payment-receiver_payer_id').val();
//         deb_id= $('#payment-debit_account').val();
//         $.get('./account-payable/get-receiver-id',{rec_id:rec_id,deb_id:deb_id},function(heads){
//                 var heads = $.parseJSON(heads);
//                 if(heads.value=="empty"){
//                     $("#debitnoamaountmsg").html("Do not have any <b>PAYABLE</b> record againt this account , Make new transaction");
//                     $('#payment-updateid').attr('value',"0");
                    
//                 }else{
//                 $("#payment-debit_amount").attr('value',heads.amount);
//                 $('#payment-updateid').attr('value',heads.id);
//                 }
//         });
//     });
// });
// $('#payment-debit_account').change(function(){
//     $('#payment-receiver_payer_id').change(function(){
//     rec_id=$('#payment-receiver_payer_id').val();
//     deb_id= $('#payment-debit_account').val();
//     $.get('./account-payable/get-receiver-id',{rec_id:rec_id,deb_id:deb_id},function(heads){
//     var heads = $.parseJSON(heads);
//     if(heads.value=="empty"){
//         $("#debitnoamaountmsg").html("Do not have any <b>PAYABLE</b> record againt this account , Make new transaction");
//         $('#payment-updateid').attr('value',"0"); 
//     }else{ 
//         $("#payment-debit_amount").attr('value',heads.amount);
//         $('#payment-updateid').attr('value',heads.id);
//     }
//    });
//  });
// });
// $('#checkamount'). click(function(){
//     if($(this). prop("checked") == true){
//        var debit_value=$("#payment-debit_amount").val();
//        $("#payment-credit_amount").attr("value",debit_value);
//         $('#payable_info').css("display","block");
//         $('#payment-checkstate').attr('value',"1");
//     }else if($(this). prop("checked") == false){
//         $('#payable_info').css("display","block");
//         $('#payment-checkstate').attr('value',"0");
//     }
// });

$('#payment-account_head_id').on('change',function()
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

$('#payment-debit_amount').on('focus',function()
{
    $('#payment-debit_amount').val("");   
})

$('#payment-debit_amount').on('input',function()
{
    var remaning = $('#payment-prev_remaning').val();
    var paid = $('#payment-debit_amount').val();
    var sum = parseInt(remaning)+parseInt(paid);
    $('#payment-credit_amount').val(sum);
    })

 // $('#payment-account_title_id').on('change',function()
 //    {
 //        $('#payment-account_head_id').on('change',function()
 //        {
 //            var title_id = $('#payment-account_title_id').val();
 //            var debit = $('#payment-account_head_id').val();
 //            $.get('./payment/get-payment',{title_id:title_id,debit_account:debit},function(data)
 //            {
 //                var data = JSON.parse(data);
 //                $('#payment-prev_remaning').val(data.amount);
 //            })

 //        })
 //    })
JS;
$this->registerJs($script);
?>
