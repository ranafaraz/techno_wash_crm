<?php 
$this->title = "Income / Expense Report";
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Income / Expense Report</title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<form action="" method="POST">
		<div class="col-md-3" style="">
			<label>Start Date</label>
      		<?php $date = date("m/d/Y"); ?>
     		<input type="date" name="start_date"  class="form-control" value="<?php echo date('Y-m-d'); ?>" style="margin-top: -6px;">      
    	</div>
		<div class="col-md-3" style="">
			<label>End Date</label>
      		<?php $date = date("m/d/Y"); ?>
     		<input type="date" name="end_date"  class="form-control" value="<?php echo date('Y-m-d'); ?>" style="margin-top: -6px;">      
    	</div>
		<div class="col-md-3" style="margin-top: 26px;">	
			<button type="submit" name="submit" class="btn btn-success btn-flat btn-block" style="margin-top: -6px;">
				<i class="glyphicon glyphicon-save"></i> Submit 
			</button>     
    	</div>
    	<div class="col-md-3" style="margin-top: 20px;">
     		<button onclick="printContent('print-report')" class="btn btn-warning btn-block btn-flat">
     			 <i class="glyphicon glyphicon-print"></i> Print Report
			</button>
		</div>
    	</form>
	</div><br>
<?php 
if(isset($_POST['submit'])){
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];

	$todayExpenseDetails = Yii::$app->db->createCommand("SELECT * FROM transactions WHERE transactions_date >= '$start_date' AND transactions_date <= '$end_date' AND account_head_id = 2 ORDER BY transactions_date DESC")->queryAll();
	$count = count($todayExpenseDetails);
?>
<div class="container-fluid" id="print-report">
	<div class="row container-fluid" style="border: 2px solid; border-radius: 10px;">
		<div class="col-md-12">
			<img src="images/technowash_logo.png" width="" style="margin-left: 34%;">
		</div>
		<div class="col-md-12">
			<p style="text-align: center;">
				Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur <br>	
				Contact #: +92 (300) 0600106<br>https://www.technowashbwp.pk
			</p>
		</div>
	</div>
	<br>	
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-condensed table-hover">
				<thead>
					<tr>
						<th colspan="6" style="background-color: black !important;">
							<h4 style="font-family: georgia;">
								<span>
									<b style="color: white !important;">
										Expense Report
									</b>
								</span>
								<span class="pull-right" style="color: white !important;">From 
									<b style="color: white !important;"><?php echo date('d-M-Y',strtotime($start_date))."</b> To <b style='color: white !important;'>".date('d-M-Y',strtotime($end_date)); ?>
									</b>
								</span>
							</h4>
						</th>
					</tr>
					<tr>
						<th class="text-center">Sr.#</th>
						<th>Expense Head</th>
						<th>Narration</th>
						<th width="150px">Transaction Date</th>
						<th width="120px">Payment Type</th>
						<th class="text-center">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php 
		               	$netTotal = 0;
		              	for ($c=0; $c <$count ; $c++) {
		              	$expenseHeadId = $todayExpenseDetails[$c]['head_id'];
		              	$expenseHeads = Yii::$app->db->createCommand("
						  SELECT account_name FROM account_head WHERE id = '$expenseHeadId'
						")->queryAll();
						$expenseHeadName = $expenseHeads[0]['account_name'];
					?>      
					<tr>
						<th class="text-center"><?php echo $c+1; ?></th>
						<td>
							<?php echo $expenseHeadName; ?>
						</td>
						<td>
							<?php echo $todayExpenseDetails[$c]['narration']; ?>
						</td>
						<td class="text-center">
							<?php echo date('d-M-Y',strtotime($todayExpenseDetails[$c]['transactions_date'])); ?>
						</td>
						<td class="text-center">
							<?php echo $todayExpenseDetails[$c]['type']; ?>
						</td>
						<td class="text-center">
							<?php echo $todayExpenseDetails[$c]['amount']; ?>
						</td>
					</tr>
					<?php $netTotal += $todayExpenseDetails[$c]['amount']; } ?>
					 <tr>
						<td colspan="5" style="text-align: center;background-color: black !important; color: white !important; font-weight: bolder;">Net Total</td>
						<td class="text-center" style="background-color: black !important; color: white !important; font-weight: bolder;">
							<?php echo $netTotal; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</body>
</html>
<?php } ?>
<script>
function printContent(el){
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script>