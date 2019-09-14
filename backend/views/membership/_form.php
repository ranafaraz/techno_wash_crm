<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Customer;
use common\models\CustomerVehicles;
use common\models\CardType;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Membership */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="membership-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

    <?=$form->field($model, 'card_type_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(CardType::find()->all(), 'card_type_id', 'card_name'),
    'language' => 'en',
    'options' => ['placeholder' => '<--- Select Card --->'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]);?>

    </div>
        <div class="col-md-4">

    <?=$form->field($model, 'customer_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Customer::find()->all(), 'customer_id', 'customer_name'),
    'language' => 'en',
    'options' => ['placeholder' => '<--- Select Card --->'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]);?>

    </div>
        <div class="col-md-4">

    <?=$form->field($model, 'customer_vehicle_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(CustomerVehicles::find()->all(), 'customer_vehicle_id', 'customer_vehicle_id'),
    'language' => 'en',
    'options' => ['placeholder' => '<--- Select Card --->'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]);?>

    </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-4">
    <?php 
    echo '<label>Membership Start Date</label>'; 
    echo DatePicker::widget([
    'model' => $model, 
    'attribute' => 'membership_start_date',
    'options' => ['placeholder' => 'Select date ...'],
    'pluginOptions' => [
        'format' => '20yy-m-d',
        'autoclose'=>true
    ]
    ]);

    ?>
    </div>
        <div class="col-md-4">

    <?php 
    echo '<label>Membership End Date</label>'; 
    echo DatePicker::widget([
    'model' => $model, 
    'attribute' => 'membership_end_date',
    'options' => ['placeholder' => 'Select date ...'],
    'pluginOptions' => [
        'format' => '20yy-m-d',
        'autoclose'=>true
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
