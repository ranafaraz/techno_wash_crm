<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\AccountHead;
use common\models\AccountNature;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\AccountPayable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-payable-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?php
                $natureex=AccountNature::findOne(['name'=>'Expense']);
                $nature_idex=$natureex->id;
                $data1=ArrayHelper::map(AccountHead::find()->where(['nature_id'=>$nature_idex])->andwhere(['!=' , 'account_name' , 'Salaries'])->all(),'id', 'account_name');
            ?>
            <?= $form->field($model, 'account_payable')->widget(Select2::classname(), [
                'data' =>$data1,
                'language' => 'en',
                'options' => ['placeholder' => 'Select a state ...'],

                'pluginOptions' => [
                'allowClear' => true
            ],
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'due_date')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'narration')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '--SELECT STATUS--']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
