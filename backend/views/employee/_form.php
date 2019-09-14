<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use common\models\Salary;
use common\models\EmployeeTypes;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'salary_id')->dropDownList(
                ArrayHelper::map(Salary::find()->all(),'salary_id','salary_id'),
                ['prompt'=>'Select Salary',]
                )?>
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
    <!-- row 1 close -->

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
    <!-- row 2 close -->

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
    <!-- row 3 close -->

    <div class="row">
        <div class="col-md-4">
    <?= $form->field($model, 'emp_qualification')->textInput(['maxlength' => true]) ?>


    </div>
        <div class="col-md-4">
    <?= $form->field($model, 'emp_reference')->textInput(['maxlength' => true]) ?>

    </div>
        <div class="col-md-4">
    
    <?php  
    echo '<label>Employee Joining Date</label>';
    echo DatePicker::widget([
    'model' => $model, 
    'attribute' => 'joining_date',
    'options' => ['placeholder' => 'Select Joining date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
    ]);
    ?>

     </div>
    </div>
    <!-- row 4 close -->

    <div class="row">
        <div class="col-md-4">
    
    <?php  
    echo '<label>Employee Learning Date</label>';
    echo DatePicker::widget([
    'model' => $model, 
    'attribute' => 'learning_date',
    'options' => ['placeholder' => 'Select Learning date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
    ]);
    ?>
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
