<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use common\models\Salary;
use common\models\EmployeeTypes;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
$empName = $model->emp_name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Update Employee (<b><?php echo $empName; ?></b>)</h2>
    </div>
</div>
<div class="employee-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-4">

    <label>Employee Joining Date</label>
                <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'joining_date',
                'language' => 'en',
                'size' => 'ms',
                'clientOptions' => [
                    'autoclose' => true,
                    'convertFormat' => false,                    
                    'format' => 'dd-mm-yyyy  HH:ii P',
                    'todayBtn' => true
                ]
            ]);?>

     </div>
     <div class="col-md-4">

     <label>Employee Learning Date</label>
                <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'learning_date',
                'language' => 'en',
                'size' => 'ms',
                'clientOptions' => [
                    'autoclose' => true,
                    'convertFormat' => false,                    
                    'format' => 'dd-mm-yyyy  HH:ii P',
                    'todayBtn' => true
                ]
            ]);?>
    </div>
        <div class="col-md-4">   

    <?= $form->field($model, 'salary_id')->dropDownList(
                ArrayHelper::map(Salary::find()->all(),'salary_id','salary_id'),
                ['prompt'=>'Select Salary',]
                )?>
    </div>
    </div>
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-4">

    <?= $form->field($model, 'branch_id')->dropDownList(
                ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name'),
                ['prompt'=>'Select Branch',]
                )?>

    </div>
        <div class="col-md-4">
    <?= $form->field($model, 'emp_type_id')->dropDownList(
                ArrayHelper::map(EmployeeTypes::find()->all(),'emp_type_id','emp_type_name'),
                ['prompt'=>'Select Emp Type',]
                )?>
    </div>
        <div class="col-md-4">                    

    <?= $form->field($model, 'emp_name')->textInput(['maxlength' => true]) ?> 
    </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
    
    <?= $form->field($model, 'emp_father_name')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'emp_email')->textInput(['maxlength' => true]) ?>
    

    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'emp_image')->fileInput(['maxlength' => true]) ?>

    </div>
        <div class="col-md-4">
    
    <?= $form->field($model, 'emp_gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>

    </div>
    </div>
    <!-- row 4 close -->

    <div class="row">
        <div class="col-md-4">

    <?= $form->field($model, 'emp_qualification')->textInput(['maxlength' => true]) ?>

    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'emp_reference')->textInput(['maxlength' => true]) ?>

    </div>
        
        <div class="col-md-4">

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>
        </div>
    </div>
    <!-- row 5 close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
