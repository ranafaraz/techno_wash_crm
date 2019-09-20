<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Customer;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\SaleInvoiceHead */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Create New Sale Invoice Head</h2>
        </div>
</div>
<div class="sale-invoice-head-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
             <?= $form->field($model, 'customer_id')->dropDownList(
                ArrayHelper::map(Customer::find()->all(),'customer_id','customer_name'),
                ['prompt'=>'Select Customer',]
    )?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label>Date</label>
            <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'date',
                'language' => 'en',
                'size' => 'ms',
                'clientOptions' => [
                    'autoclose' => true,
                    'convertFormat' => false,                    
                    'format' => 'yyyy-mm-dd  HH:ii P',
                    'todayBtn' => true
                ]
            ]);
            ?>
        </div>
    </div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
