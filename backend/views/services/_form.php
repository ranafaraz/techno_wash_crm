<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Create New Service</h2>
        </div>
</div>
<div class="services-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'branch_id')->dropDownList(
                ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name'),
                ['prompt'=>'Select Branch',]
                )?>

    </div>
        <div class="col-md-6">

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <!-- row 1 close -->

    <div class="row">
        <div class="col-md-6">

    <?= $form->field($model, 'price')->textInput() ?>

    </div>
        <div class="col-md-6">

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

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
