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
// $this->title = 'Cash Book';
// $this->params['breadcrumbs'][] = $this->title;
// $id = null;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		/*#tb1 tr th{
			border:2px solid;
		}*/
		#tb2 tr th{
			border:1px solid;
		}
	</style>
</head>
<body>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<div class="box box-primary">
				<div class="box-header">
					<h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#367FA9;">
                                Cash Book
                    </h3>
                    <div class="row" style="margin-top:10px;">
						<div class="col-md-4">
							<label>Select Starting Date</label>
			            	<input type="date" id="start_date" name="date" class="form form-control">
						</div>
						<div class="col-md-4">
							<label>Select Ending Date</label>
			            	<input type="date" id="end_date" name="date" class="form form-control">
						</div>
						<div class="col-md-2">
							<button class="btn btn-success" id="button" style="margin-top:24px;color:white;padding: 7px;">Get Report</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<th id="mydata"></th>
	<div class="row" id="mydata" style="display: none;padding:10px;">
		<h3 style="text-align: center;margin-bottom:20px;">CASH BOOK</h3>
        <div class="col-md-6">
          <table class="table table-bordered" id="tb2" style="height:290px;">
            <thead>
            	<tr>
            		<th style="background-color:lightgray;" colspan="5">
            			Debit (Receipts)
            		</th>
            	</tr>
              <th>Date</th>
              <th>Particluars </th>
              <th style="text-align: center;">R.N</th>
              <th style="text-align: center;">L.F</th>
              <th style="text-align: center;">Amount Rs.</th>
            </thead>
            <tbody id="showDataRecipts">
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-bordered" id="tb2" style="height:290px;">
            <thead>
            	<tr>
            		<th style="background-color:lightgray;" colspan="5">
            			Credit (Payments)
            		</th>
            	</tr>
              <th>Date</th>
              <th>Particluars </th>
              <th style="text-align: center;">V.N</th>
              <th style="text-align: center;">L.F</th>
              <th style="text-align: center;">Amount Rs.</th>
            </thead>
            <tbody id="showDataPayments">
            </tbody>
          </table>
        </div>
    </div>
</div>
</body>
</html>
<?php
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
				url : "daily-cashbook-data",
				method:"POST",
				data:{sdate:starting_date,edate:end_date},
				success:function(result)
				{
					var jsonResult = JSON.parse(result);
					var transactionDetail = jsonResult[0];
					var transactionHead = jsonResult[1];
					// console.log(transactionDetail);
					// console.log(transactionHead);

					var recipttotal = 0;
					var paymentstotal = 0;
					for(var r=0; r<transactionDetail.length; r++)
					{
						if(transactionDetail[r]['ref_name'] == "Sale")
						{
								recipttotal+=parseInt(transactionDetail[r]['amount']);

						}
						else 
						{

							paymentstotal+=parseInt(transactionDetail[r]['amount']);
							
						}
					}

					$("#mydata").show();
					
					var rec = '';
					var paymnts = '';
					for(var r=0; r<transactionDetail.length; r++)
					{
						if(transactionDetail[r]['ref_name'] == "Sale")
						{
							rec += '<tr><td style="border:1px solid;">'+transactionDetail[r]['transactions_date']+'</td><td style="border:1px solid;">'+transactionHead[r]+'</td><td style="text-align:center;border:1px solid;">'+transactionDetail[r]['ref_no']+'</td><td style="text-align:center;border:1px solid;">---</td><td style="text-align:center;border:1px solid;">'+transactionDetail[r]['amount']+'</td></tr>';
						}
						else 
						{
							if(transactionDetail[r]['ref_name'] == "Payments"){
								paymnts += '<tr><td style="border:1px solid;">'+transactionDetail[r]['transactions_date']+'</td><td style="border:1px solid;">'+transactionHead[r]+'</td><td style="text-align:center;border:1px solid;">'+transactionDetail[r]['transaction_id']+'</td><td style="text-align:center;border:1px solid;">---</td><td style="text-align:center;border:1px solid;">'+transactionDetail[r]['amount']+'</td></tr>';
							}
							else{
								paymnts += '<tr><td style="border:1px solid;">'+transactionDetail[r]['transactions_date']+'</td><td style="border:1px solid;">'+transactionHead[r]+'</td><td style="text-align:center;border:1px solid;">'+transactionDetail[r]['ref_no']+'</td><td style="text-align:center;border:1px solid;">---</td><td style="text-align:center;border:1px solid;">'+transactionDetail[r]['amount']+'</td></tr>';
							}	
						}
					}
					var balanceCd = recipttotal-paymentstotal;
					rec += '<tr><td colspan="4" style="border:1px solid;"></td><td style="font-weight:bold;text-align:center;border:1px solid;">'+recipttotal+'</td></tr>';
					rec += '<tr><td style="border:1px solid;"></td><td colspan="3" style="font-weight:bold;border:1px solid;">To Balance b/d</td><td style="text-align:center;border:1px solid;">'+balanceCd+'</td></tr>';
					paymnts += '<tr><td style="border:1px solid;"></td><td colspan="3" style="font-weight:bold;border:1px solid;">By Balance c/d</td><td style="text-align:center;border:1px solid;">'+balanceCd+'</td></tr>';
					paymnts += '<tr><td colspan="4" style="border:1px solid;"></td><td style="font-weight:bold;text-align:center;border:1px solid;">'+recipttotal+'</td></tr>';
					$('#showDataRecipts').append(rec);
					$('#showDataPayments').append(paymnts);	
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