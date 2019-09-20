<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Organization */
/* @var $form yii\widgets\ActiveForm */
$orgName = $model->org_name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Update Organization (<b><?php echo $orgName; ?></b>)</h2>
    </div>
</div>
<div class="organization-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'org_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_owner')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'org_contact')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_head_office')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_owner_cnic')->widget(yii\widgets\MaskedInput::class, ['mask' => '99999-9999999-9']) ?>
        </div>
    </div>
    <!-- row 2 close -->

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'business_ntn')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'org_logo')->fileInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            
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
