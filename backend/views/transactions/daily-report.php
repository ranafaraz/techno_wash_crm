<?PHP
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;

$this->title = 'Daily Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-md-4">
		<?php $form=ActiveForm::begin(); ?>
		<?= $form->field($model, 'start_date')->widget(
		    DatePicker::className(), [
		        // inline too, not bad
		         'inline' => false, 
		         // modify template for custom rendering

		        'clientOptions' => [
		            'autoclose' => true,
		            'format' => 'yyyy-mm-dd',
		            'todayHighlight' => true,
		        ]
		]);?>
	</div>
	<div class="col-md-2" style="margin-top: 25px">
    	<button type="button" id="btn_search" class="btn btn-primary btn-block btn-md btn-flat"><i class="fa fa-search"></i> Search Report</button>
    </div>
	<div class="col-md-12">
		<span class="errorlength"></span>
	</div>
	<?php $form = ActiveForm::end();?>
</div>

<div class="container-fluid" id="show-record">
	
</div>

<?PHP

$script = <<< JS
	
	$(document).ready(function()
	{
		$('#btn_search').on('click',function(e)
		{
				e.preventDefault();
				var date = $('#routevoucherhead-start_date').val();
				if(date == ''){
					$('.errorlength').html(
					'<span style="color:red;">SELECT DATE TO SEARCH!</span>'
					);
					$('#routevoucherhead-start_date').focus();
					return false;
				}else{
					$('.errorlength').html("");
				} 
				$.ajax({
					url : "load-data",
					method:"POST",
					data:{date:date},
					success:function(data)
					{

						$('#show-record').html(data);
					}
					
				})	
		})
	})


JS;
$this->registerJs($script);

?>