<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transactions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transactions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transaction_id')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'Cash Payment' => 'Cash Payment', 'Bank Payment' => 'Bank Payment', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'narration')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'debit_account')->textInput() ?>

    <?= $form->field($model, 'debit_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit_account')->textInput() ?>

    <?= $form->field($model, 'credit_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'transactions_date')->textInput() ?>

    <?= $form->field($model, 'ref_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
