<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\VehicleTypeSubCategory;



/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
$customerName = $model->customer_name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Customer (<b><?php echo $customerName; ?></b>)</h2>
    </div>
</div>
<div class="customer-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data','id' => 'dynamic-form']]

    ); ?>

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
                    'format' => 'yyyy-mm-dd  hh:ii:ss',
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


  <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Customer Vehicle</h4></div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 22, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelCustomerVehicles[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'vehicle_typ_sub_id',  
                    'registration_no',
                    'color',
                    'image',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelCustomerVehicles as $i => $value): ?>
                <div class="item panel panel-warning"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"> Customer Vehicle</h3>
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
                            <div class="col-sm-3">
                                 <?= $form->field($value, "[{$i}]vehicle_typ_sub_id")->dropDownList(
                                    ArrayHelper::map(VehicleTypeSubCategory::find()->all(),'vehicle_typ_sub_id','name'),
                                        ['prompt'=>'Select Vehicle Sub Type']
                                )?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($value, "[{$i}]registration_no")->textInput() ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($value, "[{$i}]color")->textInput() ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($value, "[{$i}]image")->fileInput() ?>
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
    <!-- fuel consumption dynamic form close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
