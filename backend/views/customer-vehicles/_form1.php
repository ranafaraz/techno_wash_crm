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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 customer-vehicles-form" style="background-color:#d3d3d3;padding:20px;border-top:3px solid #367FA9;">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="row" style="border-bottom:1px solid #367FA9;margin-bottom:10px; ">
                <div class="col-md-12">
                    <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Customer Vehicle</h2>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-6" style="background-color:#f5f5f5;padding:10px;border-radius:5px;">
                        <?= $form->field($model, 'customer_id')->dropDownList(
                        ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name'),["disabled"=>"disabled" ]
                        )?>
                        <?= $form->field($model, 'vehicle_typ_sub_id')->dropDownList(
                        ArrayHelper::map(VehicleTypeSubCategory::find()->all(),'vehicle_typ_sub_id','name'),
                        ['prompt'=>'Select Vehicle Sub Type',]
                        )?>
                        <?= $form->field($model, 'registration_no')->textInput(['maxlength' => true,'id' => 'reg_no']) ?>
                        <?= $form->field($model, 'color')->textInput(['maxlength' => true, 'id' => 'color_veh']) ?>
                    </div>
                    <div class="col-md-6" style="text-align: center;padding:10px;">
                        <img src="<?php echo $model->image; ?>" class="img-circle" style="width:160px; height:150px;border:1px solid #ffffff;"/>
                        <?= $form->field($model, 'image')->fileInput(['maxlength' => true,'style' => 'margin-left:auto','margin-right:auto']) ?>
                    </div>
            </div>
                 <!-- row 1 close -->
            <div class="row" style="background-color:;border-top:1px solid #ecf0f5 ;padding-top:15px;">
                <div class="col-md-12">
                   <?php if (!Yii::$app->request->isAjax){ ?>
                        <div class="form-group" style="float: right;">            
                            <a href="./sale-invoice-view?customer_id=<?php echo $customerId;?>&regno=<?=$regno?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="glyphicon glyphicon-open"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-xs' : 'btn btn-primary btn-xs']) ?>
                        </div>
                    <?php } ?>
                    <?php ActiveForm::end(); ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$script = <<< JS

  $("#reg_no").keyup(function(){
    $(this).val($(this).val().toUpperCase());
    });
      $("#reg_no").keypress(function(e){
        var keyCode = e.keyCode || e.which;
    if ((keyCode >= 33 && keyCode <=44) || (keyCode >= 46 && keyCode <=47) || (keyCode >= 58 && keyCode <=64) || (keyCode >= 91 && keyCode <=96) || (keyCode >= 123 && keyCode <= 126)) { 
      return false;
    }
    });

    $("#color_veh").keyup(function(){
    $(this).val($(this).val().toUpperCase());
    });
      $("#color_veh").keypress(function(e){
        var keyCode = e.keyCode || e.which;
    if ((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 45)) { 
      return true;
    }else{
      return false;
      }
    });
JS;
$this->registerJS($script);
 ?>