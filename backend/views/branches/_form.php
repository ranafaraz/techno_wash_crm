<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Organization;

/* @var $this yii\web\View */
/* @var $model common\models\Branches */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Branch</h2>
        </div>
</div>
<div class="branches-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'org_id')->dropDownList(
                ArrayHelper::map(Organization::find()->all(),'org_id','org_name'),
                ['prompt'=>'Select Organization',]
    )?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>  
        </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'branch_type')->dropDownList([ 'Franchise' => 'Franchise', 'Group' => 'Group', ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_location')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_contact_no')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'branch_email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_head_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <!-- row 3 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'branch_head_contact_no')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'branch_head_email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            
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
