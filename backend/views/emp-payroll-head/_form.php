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
            <?= $form->field($model, 'total_calculated_pay')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'over_time')->textInput() ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'over_time_pay')->textInput() ?>
        </div>
         <div class="col-md-4">
           <?= $form->field($model, 'bonus')->textInput() ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
           <?= $form->field($model, 'tax_deduction')->textInput() ?> 
        </div>
         <div class="col-md-4">
          <?= $form->field($model, 'relaxation')->textInput() ?>  
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'net_total')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'paid_amount')->textInput() ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'remaining')->textInput() ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([ 'Uapaid' => 'Uapaid', 'Paid' => 'Paid', 'Partially Paid' => 'Partially Paid', ], ['prompt' => '']) ?>
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
         console.log(data);
        // var data =  $.parseJSON(data);
        // var subjectName = data[0];
        // var subjectIds = data[1];
        
        // $('#subjectId').empty();
        // $('#subjectId').append("<option>"+"Select Subject"+"</option>");
        // var options = '';
        //     for(var i=0; i<subjectName.length; i++) {
        //         options += '<option value="'+subjectIds[i]+'">'+subjectName[i]+'</option>';
        //     }
        // // Append to the html
        // $('#subjectId').append(options);
    });   
});

JS;
$this->registerJs($script);
?>
</script> 