<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\VehicleType;
use common\models\CarManufacture;
// use common\models\VehicleType;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\VehicleTypeSubCatHead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-type-sub-cat-head-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'vehicle_type_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(VehicleType::find()->where(['is_deleted' => 0])->all(),'vehical_type_id','name'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select','id'=>'stdent'],
                    'showToggleAll' => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                        // 'multiple' => true,
                        // 'maximumSelectionLength'=> 65,
                    ],
                ]);
            ?>
        </div>
         <div class="col-md-6">
            <?= $form->field($model, 'manufacture')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(CarManufacture::find()->all(),'car_manufacture_id','manufacturer'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select'],
                    'showToggleAll' => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                        // 'multiple' => true,
                        // 'maximumSelectionLength'=> 65,
                    ],
                ]);
            ?>
        </div>
    </div>
      <!-- products dynamic form -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="glyphicon glyphicon-envelope"></i> 
                        Model Details 
                </h4>
            </div>
            <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelCar[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'name',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelCar as $e => $product): ?>
                <div class="item panel panel-success"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Model Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                 <?= $form->field($product, "[{$e}]name")->textInput(['id' => 'product_name','class' => 'form-control prodclass'])?>
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

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
