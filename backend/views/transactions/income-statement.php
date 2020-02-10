<?PHP
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\AccountTitle;

$this->title = 'Income Statement Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<?PHP
if(isset($_POST['date']) && isset($_POST['title']))
{
	echo $_POST['date'];
	echo $_POST['title'];
}
?>
<div class="row">
	<div class="col-md-4" id="type">
		<label>Select Report Type</label>
		<select id="select" class="form-control" required="required">
			<option value="0">...SELECT REPORT TYPE...</option>
			<option value="Half">6 Months Report</option>
			<option value="Yearly">Yearly Report</option>
		</select>
	</div>
	<div class="col-md-4" id="half_year">
		<label>Select End Date</label>
		<input type="month" id="half_date" class="form-control" required="required" name="">
	</div>
	<div class="col-md-4" id="year">
		<label>Select Year</label>
		<input type="number" id="year_date" class="form-control" required="required" min="1900" max="2099" step="1" value="2016" />
	</div>
	<div class="col-md-2" style="margin-top: 25px">
    	<button type="button" id="btn_search" class="btn btn-primary btn-block btn-md btn-flat"><i class="fa fa-search"></i> Search Report</button>
    </div>
    <div class="col-md-1" style="margin-top: 25px">
    	<tr id="printrow"><td colspan="4" ><button style="float: right;" onclick="printContent('printrecord')" class="btn btn-warning" id="btn"><i class="glyphicon glyphicon-print"></i> Print
								</button></td></tr>
    </div>
	<div class="col-md-12">
		<span class="errorlength"></span>
	</div>
</div>

<div class="row" id="printrecord">
	<div class="col-md-12" id="show">
	</div>
</div>

<?PHP

$script = <<< JS
	
	$(document).ready(function()
	{
		$('#half_year').css('display','none');
		$('#year').css('display','none');

		$('#select').on('change',function()
		{
			var val = $(this).val();
			if(val == 0)
			{
				$(this).css('border','1px solid red');

				$('#half_year').css('display','none');
				$('#year').css('display','none');
				return false;
			}
			else
			{
				$('#btn_search').css('display','block');
				$(this).css('border','1px solid green');
				if(val == 'Half')
				{
					$('#half_year').css('display','block');
				}
				else
				{
					$('#half_year').css('display','none');
				}
				
				if(val == 'Yearly')
				{
					$('#year').css('display','block');
				}
				else
				{
					$('#year').css('display','none');
				}
				return true;
			}
		})

		$('#btn_search').on('click',function(e)
		{
				e.preventDefault();
				var select = $('#select').val();
				if(select == 'Half')
				{
					var half = $('#half_date').val();
					if(half == ''){
						$('#half_date').css('border','1px solid red');
						$('#half_date').focus();
						return false;
					}else{
						$('#half_date').css('border','1px solid green');
						// ajax request
						$.ajax({
							url : "income-statement-data",
							method:"POST",
							data:{end_date:half},
							success:function(data)
							{
								console.log(data);
								$('#show').html(data);
							}		
						})	
					}
				}
				if(select == 'Yearly')
				{
					var year = $('#year_date').val();
					if(year == ''){
						$('#year_date').css('border','1px solid red');
						return false;
					}else{
						$('#year_date').css('border','1px solid green');
					} 
					// ajax request
						$.ajax({
							url : "income-statement-data",
							method:"POST",
							data:{year:year},
							success:function(data)
							{
								console.log(data);
								$('#show').html(data);
							}
							
						})	
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