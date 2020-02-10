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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" style="background-color:#d3d3d3;padding:20px;border-top:3px solid #367FA9;">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row" style="border-bottom:1px solid #367FA9;margin-bottom:10px; ">
                <div class="col-md-12">
                  <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Vendor (<b><?php echo $vendorName; ?></b>)</h2>  
                </div>
            </div>
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-12" style="background-color:#f5f5f5;padding:10px;border-radius:5px;">
                    <?= $form->field($model, 'name')->textInput(['value' => $vendorName]) ?>
                    <?= $form->field($model, 'ntn')->textInput() ?>
                </div>       
            </div>
            <div class="row" style="background-color:;border-top:1px solid #ecf0f5 ;padding-top:15px;">
                <div class="col-md-12">
                    <?php if (!Yii::$app->request->isAjax){ ?>
                        <div class="form-group" style="float: right;">
                            <a href="./purchase-invoice-view?vendor_id=<?php echo $vendorID;?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="glyphicon glyphicon-open"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-xs']) ?>
                        </div>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div> 
</div>

