<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CardType */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Card</h2>
        </div>
</div>
<div class="card-type-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'card_name')->textInput(['maxlength' => true]) ?>
            
        </div>
        <div class="col-md-4">

           <?= $form->field($model, 'card_price')->textInput() ?> 

        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'card_services')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <?= $form->field($model, 'card_description')->textarea(['rows' => 6]) ?>

        </div>
        
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
