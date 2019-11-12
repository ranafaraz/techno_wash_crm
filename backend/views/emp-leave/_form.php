<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker

/* @var $this yii\web\View */
/* @var $model common\models\EmpLeave */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-leave-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
           <?= $form->field($model, 'emp_id')->dropDownList(
                ArrayHelper::map(Employee::find()->all(),'emp_id','emp_name'),[]
                )?>
        </div>
        <div class="col-md-6">
           <?= $form->field($model, 'leave_type')->dropDownList([ 'Casual Leave' => 'Casual Leave', 'Medical Leave' => 'Medical Leave'], ['prompt' => 'Select Leave Type']) ?>
        </div>
        <div class="col-md-6">
         <?= $form->field($model, 'starting_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter start date', 'id'=>'startDate'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'autoclose'=>true,
                    'todayBtn'=>true
                ]
            ]); ?>
        </div>
    </div>
     <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ending_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter end date', 'id'=>'endDate'],
                'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                    'autoclose'=>true
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
             <?= $form->field($model, 'no_of_days')->textInput(['id' => 'noofdays', 'readonly'=>true]) ?>
        </div>
    </div>
     <div class="row">
        <div class="col-md-12">
             <?= $form->field($model, 'leave_purpose')->textArea(['maxlength' => true]) ?>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
           <?= $form->field($model, 'remarks')->textArea(['maxlength' => true]) ?>  
        </div>
    </div>   
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([ 'Pending' => 'Pending', 'Accepted' => 'Accepted', 'Rejected' => 'Rejected'], ['prompt' => 'Select Leave Status']) ?>
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
$url = \yii\helpers\Url::to("emp-leave/fetch-days-count");

$script = <<< JS

$('#endDate').on('change',function(){
   
    var endDate = $('#endDate').val();
    var startDate = $('#startDate').val();
   $.ajax({
        type:'post',
        data:{endDate:endDate,startDate:startDate},
        url: "$url",
        success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            var days = jsonResult[0];
          //console.log(days);
          $('#noofdays').val(days);
        }         
    }); 
});

JS;
$this->registerJs($script);
?>
</script> 
 