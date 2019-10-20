<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Salary;
use common\models\EmployeeTypes;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use johnitvn\ajaxcrud\CrudAsset; 


/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Employee</h2><button class="btn btn-success" id="fbtn" style="float: right">Use Me</button>
        </div>
</div>
<div class="employee-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'dynamic-form']]); ?>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-6">
          <label>Employee Joining Date</label>
                <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'emp_joining_date',
                'options' => ['placeholder' => 'Select Joining date...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>

    </div>
        <div class="col-md-6">
         <label>Employee Learning Date</label>
                <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'emp_learning_date',
                'options' => ['placeholder' => 'Select Learning date...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
        </div>     
    </div>
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-4">
                <?= $form->field($model, 'emp_type_id')->dropDownList(
                ArrayHelper::map(EmployeeTypes::find()->all(),'emp_type_id','emp_type_name'),
                ['prompt'=>'Select Position...', 'id' => 'eti']
                )?>
       </div>
       <div class="col-md-4">                      
            <?= $form->field($model, 'emp_name')->textInput(['maxlength' => true, 'id' => 'ename']) ?> 
       </div>
       <div class="col-md-4">
            <?= $form->field($model, 'emp_father_name')->textInput(['maxlength' => true, 'id' => 'efname']) ?>
       </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_father_position')->textInput(['maxlength' => true, 'id' => 'efp']) ?>
        
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
            <?= $form->field($model, 'emp_emergency_contact_relation')->textInput(['maxlength' => true, 'id' => 'eemr']) ?>
      </div>
      <div class="col-md-4">
            <?= $form->field($model, 'emp_email')->textInput(['maxlength' => true , 'id' => 'eemail']) ?>   
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
            <?= $form->field($model, 'emp_birth_place')->textInput(['maxlength' => true, 'id' => 'ebp']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_religion')->textInput(['maxlength' => true, 'id' => 'er']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_blood_group')->dropDownList([ 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-', ], ['prompt' => 'Select Blood Group...']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_nationality')->textInput(['maxlength' => true, 'id' => 'en']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_passport_no')->textInput(['maxlength' => true, 'id' => 'epn']) ?>
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
            <?= $form->field($model, 'emp_present_address')->textInput(['maxlength' => true, 'id' => 'epa']) ?>
        </div>        
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'emp_permanent_address')->textInput(['maxlength' => true, 'id' => 'eper']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ]) ?>
        </div>      
    </div>

      <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-education"></i> Employee Academic Info:</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 22, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelEmpAcademy[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'from_date',  
                    'to_date',
                    'institute',
                    'degree_diploma',
                    'division_grade',
                    'major_subjects',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelEmpAcademy as $i => $value): ?>
                <div class="item panel panel-primary"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Academic Information:</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]from_date")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]to_date")->widget(\yii\jui\DatePicker::classname(), [
                                            'language' => 'en',
                                            'inline' => false,
                                            'dateFormat' => "yyyy-MM-dd",
                                            'options' => ['class' => 'form-control picker']
                                ]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]institute")->textInput() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]degree_diploma")->textInput() ?>
                            </div>
                        
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]division_grade")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($value, "[{$i}]major_subjects")->textInput() ?>
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
    <!-- Emp Academic dynamic form close -->
   
   
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php 
$script=<<<JS
$(function () {
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
         $( ".picker" ).each(function() {
            $( this ).datepicker({
            dateFormat : 'yy-mm-dd',
            language : 'en',
            changeMonth: true,
            changeYear: true
          });
        });
    });
});

$('#fbtn').on('click',function(){
    $("#eti").val("2");
    $("#ename").val("Dummay employee");
    $("#efname").val("Dummay father name");
    $("#efp").val("Dummay Data");
    $("#eemr").val("Dummay Data");
    $("#eemail").val("DummayData@gmail.com");
    $("#ebp").val("Dummay Data");
    $("#er").val("Dummay Data");
    $("#en").val("Dummay Data");
    $("#epn").val("Dummay Data");
    $("#epa").val("Dummay Data");
    $("#eper").val("Dummay Data");
    $("#employee-emp_cnic").val("12345-6789082-3");
    $("#employee-emp_contact").val("+23-456-7890987");
    $("#employee-emp_emergency_contact").val("+23-456-7890987");
    $("#employee-emp_joining_date").val("2019-10-10");
    $("#employee-emp_learning_date").val("2019-11-01");
    $("#employee-emp_dob").val("1990-12-12");
    $("#employee-passport_expiry_date").val("2019-12-12");
    $("#employee-emp_residence").val("Parents");
    $("#employee-emp_blood_group").val("A+");
    
    
    });
JS;
$this->registerJs($script);
?>