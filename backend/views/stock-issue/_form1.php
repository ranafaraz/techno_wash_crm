<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Stock;
use common\models\Employee;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\StockIssue */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">Update Stock Issue</h2>
        </div>
</div>
<div class="stock-issue-form" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'emp_id')->dropDownList(
                ArrayHelper::map(Employee::find()->all(),'emp_id','emp_name'),
                ['prompt'=>'Select Employee',]
                )?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'stock_id')->dropDownList(
                ArrayHelper::map(Stock::find()->all(),'stock_id','name'),
                ['prompt'=>'Select Stock',]
                )?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <label>Stock Issue Date</label>
            <?= DateTimePicker::widget([
                'model' => $model,
                'attribute' => 'stock_issue_date',
                'language' => 'en',
                'size' => 'ms',
                'clientOptions' => [
                    'autoclose' => true,
                    'convertFormat' => false,                    
                    'format' => 'dd-mm-yyyy  HH:ii P',
                    'todayBtn' => true
                ]
            ]);
            ?> 

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
