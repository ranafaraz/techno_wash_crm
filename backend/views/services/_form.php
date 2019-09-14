<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

    <?=$form->field($model, 'branch_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Branches::find()->all(), 'branch_id', 'branch_name'),
    'language' => 'en',
    'options' => ['placeholder' => '<--- Select Branch --->'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
    ]);?>

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
