<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\AccountNature;

/* @var $this yii\web\View */
/* @var $model common\models\AccountHead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-head-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        echo $form->field($model, 'nature_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AccountNature::find()->all(), 'id', 'name'),
            'language' => 'de',
            'options' => ['placeholder' => 'Select a state ...','id' => 'nature'],
    
            'pluginOptions' => [
            'allowClear' => true
        ],
]);
    ?>

    <?= $form->field($model, 'account_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account_no',['options'=>['id'=>'account_number']])->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php 
    $script = <<< js
    $('#nature').change(function()
{
    var nature_id=$(this).val();

        $.get('./account-nature/get-nature-id',{nature_id:nature_id},function(data){
        var data = $.parseJSON(data);
        var headid=data.id;
         $.get('./account-head/get-head-id',{headid:headid},function(heads){
        var heads = $.parseJSON(heads);

        if(heads.value=="empty"){
            var headaccount=data.account_no;
        }else{
            var headaccount=heads.account_no;
        }

        var str=data.account_no;
        var substrfixed=str.substring(0,2);
         var subStrtochange = headaccount.substring(headaccount.length-3, headaccount.length);
        
         var intstr=parseInt(subStrtochange);
         var incremented=intstr+1;
         if(incremented>=100){
            var topopulate=substrfixed+'-'+incremented;
         }else if(incremented>=10){
             var topopulate=substrfixed+'-'+'0'+incremented;
         }else{
             var topopulate=substrfixed+'-'+'00'+incremented;
         }
        $("#accounthead-account_no").attr('value',topopulate);
        
    });
    });
    });

js;
$this->registerJs($script);
?>