<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Manufacture */
/* @var $form yii\widgets\ActiveForm */
$manufactureName = $model->name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Manufacture (<b><?php echo $manufactureName; ?></b>)</h2>
    </div>
</div>
<div class="manufacture-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
