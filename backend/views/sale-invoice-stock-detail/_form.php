<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SaleInvoiceStockDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-invoice-stock-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sale_inv_head_id')->textInput() ?>

    <?= $form->field($model, 'stock_id')->textInput() ?>

    <?= $form->field($model, 'discount_per_item')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
