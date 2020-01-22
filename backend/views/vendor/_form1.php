<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Branches;

/* @var $this yii\web\View */
/* @var $model common\models\Vendor */
/* @var $form yii\widgets\ActiveForm */
$vendorID = $model->vendor_id;
$vendorName = $model->name;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Vendor (<b><?php echo $vendorName; ?></b>)</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
       <div class="vendor-form" style="background-color:lightgray;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['value' => $vendorName]) ?>
            <?= $form->field($model, 'ntn')->textInput() ?>
        </div>       
    </div>


    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <a href="./purchase-invoice-view?vendor_id=<?php echo $vendorID;?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="glyphicon glyphicon-open"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-xs']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div> 
    </div>
</div>

