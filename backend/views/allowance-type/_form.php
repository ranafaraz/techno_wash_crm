<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\AllowanceType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="allowance-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'branch_id')->widget(Select2::classname(), [
	'data' => ArrayHelper::map(Branches::find()->all(), 'branch_id', 'branch_name'),
	'language' => 'en',
	'options' => ['placeholder' => '<--- Select Branch --->'],
	'pluginOptions' => [
		'allowClear' => true,
	],
    ]);?>

    <?= $form->field($model, 'allowance_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
