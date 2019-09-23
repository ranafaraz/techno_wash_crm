<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VehicleTypeSubCategory;
use yii\helpers\ArrayHelper;
use common\models\Customer;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerVehicles */
/* @var $form yii\widgets\ActiveForm */
$customerId = $model->customer_id;
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Customer Vehicle</h2>
        </div>
</div>
<div class="customer-vehicles-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'customer_id')->dropDownList(
                ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name'),["disabled"=>"disabled" ]
                )?>
            </div>
            <div class="col-md-6">

                <?= $form->field($model, 'vehicle_typ_sub_id')->dropDownList(
                ArrayHelper::map(VehicleTypeSubCategory::find()->all(),'vehicle_typ_sub_id','name'),
                ['prompt'=>'Select Vehicle Sub Type',]
                )?>

            </div>
        </div>

         <!-- row 1 close -->

        <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'registration_no')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-6">

                <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
         <!-- row 2 close -->

        <div class="row">    
            <div class="col-md-6">

                <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

             </div>
        </div>

        <!-- row 3 close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">            
            <a href="./customer-detail-view?id=<?php echo $customerId;?>" class="btn btn-danger"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="glyphicon glyphicon-open"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
