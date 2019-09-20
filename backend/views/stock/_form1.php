<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Branches;
use common\models\Manufacture;
use common\models\StockType;
use common\models\PurchaseInvoice;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
$stockName = $model->name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Stock (<b><?php echo $stockName; ?></b>)</h2>
    </div>
</div>
<div class="stock-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'branch_id')->dropDownList(
                ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name'),
                ['prompt'=>'Select Branch',]
                )?>

        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'stock_type_id')->dropDownList(
                ArrayHelper::map(StockType::find()->all(),'stock_type_id','name'),
                ['prompt'=>'Select Stock',]
                )?> 

        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'purchase_invoice_id')->dropDownList(
                ArrayHelper::map(PurchaseInvoice::find()->all(),'purchase_invoice_id','purchase_invoice_id'),
                ['prompt'=>'Select Purchase Invoice',]
                )?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'manufacture_id')->dropDownList(
                ArrayHelper::map(Manufacture::find()->all(),'manufacture_id','name'),
                ['prompt'=>'Select Manufacture',]
                )?>

        </div>
        <div class="col-md-4">
           
           <label>Expiry Date</label>
            <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'expiry_date',
                'language' => 'en',
                'size' => 'ms',
                'clientOptions' => [
                    'autoclose' => true,
                    'convertFormat' => false,                    
                    'format' => 'yyyy-mm-dd  hh:ii:ss',
                    'todayBtn' => true
                ]
            ]);
            ?> 

        </div>
        <div class="col-md-4">

           <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'purchase_price')->textInput() ?>

        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'selling_price')->textInput() ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'status')->dropDownList([ 'In-stock' => 'In-stock', 'Sold' => 'Sold', 'Expired' => 'Expired', 'Returned' => 'Returned', 'Damaged' => 'Damaged', ], ['prompt' => '']) ?>

        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
