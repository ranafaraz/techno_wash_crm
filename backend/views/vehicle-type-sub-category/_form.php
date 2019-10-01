<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\VehicleType;

/* @var $this yii\web\View */
/* @var $model common\models\VehicleTypeSubCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Vehicle Sub Type</h2>
        </div>
</div>
<div class="vehicle-type-sub-category-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    
	<?= $form->field($model, 'vehicle_type_id')->dropDownList(
                ArrayHelper::map(VehicleType::find()->all(),'vehical_type_id','name'),
                ['prompt'=>'Select Vehicle Type ']
    )?>
      <?= $form->field($model, 'manufacture')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

  

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
