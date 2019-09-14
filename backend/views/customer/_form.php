<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">

            <label>Customter Registration Date</label>
                <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'customer_registration_date',
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
        <div class="col-md-6">
    <?= $form->field($model, 'branch_id')->dropDownList(
                ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name'),
                ['prompt'=>'Select Branch',]
                )?>

    </div>
</div>
<!-- row 1 close -->
<div class="row">
        <div class="col-md-4">
    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    </div>
        <div class="col-md-4">
    <?= $form->field($model, 'customer_gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>
    
    </div>
        <div class="col-md-4">
    <?= $form->field($model, 'customer_cnic')->widget(yii\widgets\MaskedInput::class, ['mask' => '99999-9999999-9']) ?>
    
    </div>
    </div>
    <!-- row 2 close -->
    <div class="row">
        <div class="col-md-4">
    <?= $form->field($model, 'customer_contact_no')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>      
    
    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'customer_age')->textInput() ?>
    
    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>
    </div>
    </div>
    <!-- row 3 close -->

    <div class="row">
        <div class="col-md-4">

    <?= $form->field($model, 'customer_address')->textInput(['maxlength' => true]) ?>  

    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'customer_image')->fileInput(['maxlength' => true]) ?>
    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'customer_occupation')->textInput(['maxlength' => true]) ?>
    </div>
</div>
  <!-- row 4 close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
