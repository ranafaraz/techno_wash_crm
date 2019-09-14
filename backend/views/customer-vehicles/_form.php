<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VehicleTypeSubCategory;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerVehicles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-vehicles-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">

    <?=$form->field($model, 'vehicle_typ_sub_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(VehicleTypeSubCategory::find()->all(), 'vehicle_typ_sub_id', 'name'),
    'language' => 'en',
    'options' => ['placeholder' => '<--- Select vehicle sub type --->'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]);?>

    </div>
        <div class="col-md-6">

    <?= $form->field($model, 'registration_no')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-6">

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    </div>
        <div class="col-md-6">

    <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

     </div>
    </div>
    <!-- row 2 close -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
