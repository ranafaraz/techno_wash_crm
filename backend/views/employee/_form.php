<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Salary;
use common\models\EmployeeTypes;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Employee</h2>
        </div>
</div>
<div class="employee-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-6">
          <label>Employee Joining Date</label>
                <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'emp_joining_date',
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
        <div class="col-md-6">
         <label>Employee Learning Date</label>
                <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'emp_learning_date',
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
    </div>
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-4">
                <?= $form->field($model, 'emp_type_id')->dropDownList(
                ArrayHelper::map(EmployeeTypes::find()->all(),'emp_type_id','emp_type_name'),
                ['prompt'=>'Select Position...',]
                )?>
       </div>
       <div class="col-md-4">                      
            <?= $form->field($model, 'emp_name')->textInput(['maxlength' => true]) ?> 
       </div>
       <div class="col-md-4">
            <?= $form->field($model, 'emp_father_name')->textInput(['maxlength' => true]) ?>
       </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_father_position')->textInput(['maxlength' => true]) ?>
        
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_cnic')->widget(yii\widgets\MaskedInput::class, ['mask' => '99999-9999999-9']) ?>
        
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_contact')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        </div>
    </div>
    <!-- row 3 close -->

    <div class="row">
      <div class="col-md-4">
            <?= $form->field($model, 'emp_emergency_contact')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
      </div>
      <div class="col-md-4">
            <?= $form->field($model, 'emp_emergency_contact_relation')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-4">
            <?= $form->field($model, 'emp_email')->textInput(['maxlength' => true]) ?>   
      </div>
    </div>
    <!-- row 4 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_image')->fileInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ]) ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'emp_marital_status')->dropDownList([ 'Single' => 'Single', 'Married' => 'Married', ]) ?>
        </div>
    </div>
    <!-- row 5 close -->
    <div class="row">
        <div class="col-md-4">
            <?= '<label>Date of Birth</label>';
                echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'emp_dob',
                'options' => ['placeholder' => 'Select Date of Birth...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_birth_place')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_religion')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_blood_group')->dropDownList([ 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-', ], ['prompt' => 'Select Blood Group...']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_nationality')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_passport_no')->textInput(['maxlength' => true]) ?>
        </div>        
    </div>
    <div class="row">
        <div class="col-md-4">
             <?= '<label>Passport Expiry Date</label>';
                echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'passport_expiry_date',
                'options' => ['placeholder' => 'Select Expiry date...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_residence')->dropDownList([ 'Owned' => 'Owned', 'Rented' => 'Rented', 'Parents' => 'Parents', 'relatives' => 'Relatives', 'others' => 'Others', ], ['prompt' => 'Select Residence...']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_present_address')->textInput(['maxlength' => true]) ?>
        </div>        
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_permanent_address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ]) ?>
        </div>      
    </div>
   
   
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
