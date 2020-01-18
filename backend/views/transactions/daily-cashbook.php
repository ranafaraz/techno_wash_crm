<?PHP

use dosamigos\datepicker\DatePicker;
use backend\models\AccountHead;
use backend\models\Transactions;
use yii\helpers\Json;
use backend\models\AccountPayable;
use backend\models\AccountRecievable;
use backend\models\Customer;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\AccountTitle;
$this->title = 'Cash Book';
$this->params['breadcrumbs'][] = $this->title;
$id = null;
?>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-3">
				<label>Select Starting Date</label>
            	<input type="date" id="start_date" name="date" class="form form-control">
			</div>
			<div class="col-md-3">
				<label>Select Ending Date</label>
            	<input type="date" id="end_date" name="date" class="form form-control">
			</div>
			<div class="col-md-2">
				<button class="btn" id="button" style="margin-top:24px;color:white;padding: 7px !important; border-radius: 2px !important;background-color: #7C9494;">Search Report</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#Receipts">Receipts</a></li>
		  <li><a data-toggle="tab" href="#Payments">Payments</a></li>
		</ul>
		<div class="tab-content">
		  <div id="Receipts" class="tab-pane fade in active">
		  </div>
		  <div id="Payments" class="tab-pane fade">
		  </div>
		</div>
	</div>
</div>

<?PHP
$script =<<< JS
		$('#button').on('click',function()
		{
			var starting_date = $('#start_date').val();
			var end_date = $('#end_date').val(); 
			//var title = $('#w0').val();
			if(starting_date == '')
			{
				$('#start_date').css('border','1px solid red');
				return false;
			}else
			if(end_date == '')
			{
				$('#end_date').css('border','1px solid red');
				return false;
			}
			else
			{
				$('#start_date').css('border','1px solid green');
				$('#end_date').css('border','1px solid green');
			}
			$.ajax({
				url : "daily-cashbook-data-receipt",
				method:"POST",
				data:{sdate:starting_date,edate:end_date},
				success:function(data)
				{
					$('#Receipts').html(data);
					$('#s_date').html(starting_date);
					$('#e_date').html(end_date);
				}
			})
			$.ajax({
				url : "daily-cashbook-data",
				method:"POST",
				data:{sdate:starting_date,edate:end_date},
				success:function(data)
				{
					$('#Payments').html(data);
					$('#si_date').html(starting_date);
					$('#ei_date').html(end_date);
				}
			})
		})
	JS;
	$this->registerJs($script);

?>
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
	window.location.reload();
}
</script>