<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Branches;

/* @var $this yii\web\View */
/* @var $model common\models\WageType */
/* @var $form yii\widgets\ActiveForm */
$wageName = $model->wage_name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Wagetype (<b><?php echo $wageName; ?></b>)</h2>
    </div>
</div>
<div class="wage-type-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

 	<?= $form->field($model, 'branch_id')->dropDownList(
                ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name'),
                ['prompt'=>'Select Branch',]
    )?>

    <?= $form->field($model, 'wage_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_pay')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
