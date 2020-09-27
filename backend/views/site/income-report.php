<?php 
	$currentDate = date('Y-m-d');
	// $countCustomer  = Yii::$app->db->createCommand("
	//   SELECT sih.*
	//   FROM sale_invoice_head as sih
	//   WHERE CAST(sih.date as DATE) = '$currentDate'
	// ")->queryAll();
	// $countcustomer = count($countCustomer);
$this->title = "Sales Report";
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
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
	$saleInvoiceHead = Yii::$app->db->createCommand("SELECT * FROM sale_invoice_head WHERE CAST(date as DATE) >= '$start_date' AND CAST(date as DATE) <= '$end_date' AND net_total !=0 ORDER BY date DESC
	")->queryAll();

	// var_dump($saleInvoiceHead);
	// die();
	$countHead = count($saleInvoiceHead);
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
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="8" style="background-color: black !important;">
							<h4 style="font-family: georgia;">
								<span><b style="color: white !important;">Income Report</b></span> <span class="pull-right" style="color: white !important;">From <b style="color: white !important;"><?php echo date('d-M-Y',strtotime($start_date))." To ".date('d-M-Y',strtotime($end_date)); ?></b>
								</span>
							</h4>
						</th>
					</tr>
					<tr>
						<th class="text-center">Sr.#</th>
						<th>Customer Name</th>
						<th>Registration No.</th>
						<th class="text-center" width="100px">Date</th>
						<th class="text-center">Status</th>
						<th class="text-center">Total</th>
						<th class="text-center" width="50px;">Remaining</th>
						<th class="text-center">Paid</th>
					</tr>
				</thead>
				<tbody>
					<?php 
		               $netTotal = $paidAmount = $remainingAmount = 0;
		              for ($c=0; $c <$countHead ; $c++) {
		              	$sale_inv_head_id = $saleInvoiceHead[$c]['sale_inv_head_id'];

		              	$saledetails  = Yii::$app->db->createCommand("
						  SELECT sid.*
						  FROM sale_invoice_detail as sid
						  WHERE sid.sale_inv_head_id = '$sale_inv_head_id'
						")->queryAll();
		              	//var_dump($saledetails);

		              	$customerID = $saleInvoiceHead[$c]['customer_id'];

						//$custVehicleID = $saledetails[0]['customer_vehicle_id'];
			              $customerInfo  = Yii::$app->db->createCommand("
				          SELECT customer.customer_name,customer_vehicles.registration_no, vtsc.name
				          FROM customer
				          INNER JOIN customer_vehicles
				          ON customer.customer_id = customer_vehicles.customer_id 
				      		INNER JOIN vehicle_type_sub_category as vtsc
				     		ON customer_vehicles.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id
				          WHERE customer.customer_id = '$customerID'
				          ")->queryAll();
				          $status = $saleInvoiceHead[$c]['status'];
				          if($status == 'Paid'){
				          	$trClass = 'success';
				          } else if($status == 'Partially'){
				          	$trClass = 'warning';
				          } else if ($status == 'Unpaid'){
				          	$trClass = 'danger';
				          }
		              ?>          
					<tr class="<?php echo $trClass; ?>">
						<th class="text-center"><?php echo $c+1; ?></th>
						<td>
							<?php echo $customerInfo[0]['customer_name']; ?>
						</td>
						<td>
							<?php 
								echo $customerInfo[0]['name']." - ".$customerInfo[0]['registration_no'];
							 ?>
						</td>
						<td class="text-center">
							<?php echo date('d-m-Y',strtotime($saleInvoiceHead[$c]['date'])); ?>
						</td>
						<td class="text-center">
							<?php echo $saleInvoiceHead[$c]['status']; ?>
						</td>
						<td class="text-center">
							<?php echo $saleInvoiceHead[$c]['net_total']; ?>
						</td>
						<td class="text-center">
							<?php echo $saleInvoiceHead[$c]['remaining_amount']; ?>
						</td>
						<td class="text-center">
							<?php echo $saleInvoiceHead[$c]['paid_amount']; ?>
						</td>
					</tr>
					<?php 
						$netTotal += $saleInvoiceHead[$c]['net_total'];
						$paidAmount += $saleInvoiceHead[$c]['paid_amount'];
						$remainingAmount += $saleInvoiceHead[$c]['remaining_amount'];
					} ?>
					 <tr>
						<td colspan="5" style="text-align: center;background-color: black !important; color: white !important;font-weight: bolder;">Total</td>
						<td class="text-center" style="background-color: black !important; color: white !important; font-weight: bolder;">
							<?php echo $netTotal; ?>
						</td>
						<td class="text-center" style="background-color: black !important; color: white !important; font-weight: bolder;">
							<?php echo $remainingAmount; ?>
						</td>
						<td class="text-center" style="background-color: black !important; color: white !important; font-weight: bolder;">
							<?php echo $paidAmount; ?>
						</td>
					</tr>
				</tbody>
			</table>
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