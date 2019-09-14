<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Customer;
use common\models\CustomerVehicles;
use common\models\CardType;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Membership */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Create New Membership</h2>
        </div>
</div>
<div class="membership-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

    <?= $form->field($model, 'card_type_id')->dropDownList(
                ArrayHelper::map(CardType::find()->all(),'card_type_id','card_name'),
                ['prompt'=>'Select Card Type',]
                )?>

    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'customer_id')->dropDownList(
                ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name'),
                ['prompt'=>'Select Customer',]
                )?>

    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'customer_vehicle_id')->dropDownList(
                ArrayHelper::map(CustomerVehicles::find()->all(),'customer_vehicle_id','customer_vehicle_id'),
                ['prompt'=>'Select Customer Vehicle',]
                )?>

    </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-4">

    <label>Membership Start Date</label>
            <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'membership_start_date',
                'language' => 'en',
                'size' => 'ms',
                'clientOptions' => [
                    'autoclose' => true,
                    'convertFormat' => false,                    
                    'format' => 'dd-mm-yyyy  HH:ii P',
                    'todayBtn' => true
                ]
            ]);
            ?>
    </div>
        <div class="col-md-4">

    <label>Membership End Date</label>
            <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'membership_end_date',
                'language' => 'en',
                'size' => 'ms',
                'clientOptions' => [
                    'autoclose' => true,
                    'convertFormat' => false,                    
                    'format' => 'dd-mm-yyyy  HH:ii P',
                    'todayBtn' => true
                ]
            ]);
            ?>
    </div>
        <div class="col-md-4">

    <?= $form->field($model, 'card_issued_by')->textInput(['maxlength' => true]) ?>

    </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
    <?= $form->field($model, 'car_registration_no')->textInput(['maxlength' => true]) ?>
    </div>
        
</div>
  <!-- row 3 close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
