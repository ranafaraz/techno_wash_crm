<?php 

	use dosamigos\datepicker\DatePicker;
	use yii\widgets\ActiveForm;
	use johnitvn\ajaxcrud\CrudAsset; 

	$this->title = 'Date To Date Report';
	$this->params['breadcrumbs'][] = $this->title;

	CrudAsset::register($this);
?> 

<?php $form = ActiveForm::begin(); ?>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, "s_date")->widget(
                DatePicker::className(), [
	                // inline too, not bad
	                'inline' => false,
	                 // modify template for custom rendering
	                'clientOptions' => [
	                    'autoclose' => true,
	                    'format' => 'yyyy-mm-dd',
	                    'todayHighlight' => true,
	                ],                     
	        	]);
	        ?>
	        <span id="errstartdate"></span>
	    </div>
	    <div class="col-md-4">
	    	<?= $form->field($model, "e_date")->widget(
                DatePicker::className(), [
                    // inline too, not bad
                     'inline' => false,
                     // modify template for custom rendering
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                    ],                     
	            ]);
	        ?>
	        <span id="errenddate"></span>
	    </div>
	    <div class="col-md-2" style="margin-top: 25px">
	    	<button type="button" id="search" class="btn btn-primary btn-block btn-md btn-flat"><i class="fa fa-search"></i> Search Report</button>
	    </div>
	</div>
	
	<?php ActiveForm::end(); ?>
	<div class="row" >
		<div id="loaded_data" class="table-responsive"></div>
	</div>

<?php 
$script=<<< JS
$("#search").on("click",function(e){
	e.preventDefault();
	var startdate = $('#routevoucherhead-s_date').val();
	if(startdate == ''){
		$('#errstartdate').html(
		'<span style="color:red;">Select start date !</span>'
		);
		$('#routevoucherhead-s_date').focus();
		return false;
	}else{
		$('#errstartdate').html("");
	}	
	var enddate = $('#routevoucherhead-e_date').val();
	if(enddate == ''){
		$('#errenddate').html(
		'<span style="color:red;">Select End date !</span>'
		);
		$('#routevoucherhead-e_date').focus();
		return false;
	}else{
		$('#errenddate').html("");
	}	
	var action = "datetodate";
	$.ajax({
			url : "load-data",
			method:"POST",
			data:{ action:action,startdate:startdate, enddate:enddate },						
				success:function(data){
					$('#loaded_data').html(data);
						}
			});



});
JS;
$this->registerJs($script);
?>