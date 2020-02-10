<?php 

if (isset($_GET['purchaseinvoiceID']) && isset($_GET['vendorID'])) {
$purchaseinvoiceID = $_GET['purchaseinvoiceID'];
$vendorID = $_GET['vendorID'];

$paidinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice 
    WHERE vendor_id = '$vendorID' 
    AND  purchase_invoice_id = '$purchaseinvoiceID'
    AND (status = 'Paid' OR status = 'paid')
    ")->queryAll();
    date_default_timezone_set("Asia/Karachi");
    $date = date('d-M-y');
    $time = date('h:i A');

	$vendorId 		= $paidinvoiceData[0]['vendor_id'];
	$remainAmount 	= $paidinvoiceData[0]['remaining_amount'];

    $vendorData  = Yii::$app->db->createCommand("
    SELECT name
    FROM vendor
    WHERE vendor_id = '$vendorId'
    ")->queryAll();
    $vendor_name = $vendorData[0]['name'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Purchase Invoice Transaction</title>
	<style type="text/css" media="print">
		footer{
			display: none;
		}
		body{
			font-size:18px;
		}
		#footer1{
			color: white;
		}
	</style>
</head>
<body onload="window.print();"  onafterprint="returnBack();">
	<div class="container-fluid">
		<!-- <div class="row">
			<div class="col-md-2">
				<a href="./purchase-invoice-view?vendor_id=<?php //echo $vendorID; ?>" class="btn btn-danger btn-flat" style="width: 70%;"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
			</div>
			<div class="col-md-8"></div>
			<div class="col-md-2">
				<button type="button" onclick="printContent('div1')" class="btn btn-warning btn-flat" id="print_button"><i class="glyphicon glyphicon-print"></i> Print Invoice</button>
			</div>
		</div> -->
		<div id="div1" style="font-size:20px;font-family:arial;">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h3  style="text-align: center;font-weight: bolder;">
						TECHNO WASH
					</h3>
					<p style="text-align: center;">
						Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur<br>Contact #: +92 (300) 060 0106<br>http://www.technowashbwp.pk
					</p>
					<h3 style="text-align: center;background-color:#000000 !important;color:white !important;padding:10px;">Transactions</h3>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered">
								
								<thead>
									<tr>
										<th style="vertical-align: top;">Name:</th>			
										<td style="text-align: center;"><?php echo $vendor_name; ?></td>

										<th>Date</th>										
										<td style="text-align: center;"><?php echo $date; ?></td>
									</tr>
									<tr>
										<th><b>INV #</b></th>
										<td style="text-align: center;"><?php echo $purchaseinvoiceID; ?></td>

										<th>Time</th>
										<td style="text-align: center;"><?php echo $time; ?></td>
									</tr>
									<tr>
										<th><b>Total Amount:</b></th>
										<td style="text-align: center;"><?php echo $paidinvoiceData[0]['total_amount']; ?></td>

										<th>Discount:</th>
										<td style="text-align: center;"><?php echo $paidinvoiceData[0]['discount']; ?></td>
									</tr>
									<tr>
										<th><b>Net Amount:</b></th>
										<td style="text-align: center;"><?php echo $paidinvoiceData[0]['net_total']; ?></td>

										<th>Paid Amount:</th>
										<td style="text-align: center;"><?php echo $paidinvoiceData[0]['paid_amount']; ?></td>
									</tr>
								</thead>
							</table>	
						</div>
					</div>

					<?php 
						$purchaseInvoiceDetailData = Yii::$app->db->createCommand("
						SELECT *
						FROM purchase_invoice_amount_detail
						WHERE purchase_invoice_id = '$purchaseinvoiceID'
						")->queryAll();
    					$countpurchaseInvoiceDetailData = count($purchaseInvoiceDetailData);

					 ?>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="background-color:lightgray !important;text-align: center;">Sr #</th>
								<th style="background-color:lightgray !important;text-align: center;">Transaction Date</th>
								<th style="background-color:lightgray !important;text-align: center;">Paid Amount</th>
						</thead>
						<tbody>
							<?php for ($i = 0; $i < $countpurchaseInvoiceDetailData; $i++) {
								
							 ?>
							<tr>
								<td style="vertical-align: middle;text-align: center;"><?php echo $i+1; ?></td>
								<td style="vertical-align: middle;text-align: center;"><?php 
								$transDate = date('d-M-Y',strtotime($purchaseInvoiceDetailData[$i]['transaction_date']));
								echo $transDate;	
								?></td>
								<td style="vertical-align: middle;text-align: center;"><?php echo $purchaseInvoiceDetailData[$i]['paid_amount']; ?></td>
								
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-6 col-md-offset-3">
					<table class="table table-bordered" >
						<thead>
							<tr>
								<th  style="text-align: center;background-color: lightgray !important;">Total Transactions: </th>
								<th style="background-color: white;text-align:center;"><?php echo $countpurchaseInvoiceDetailData; ?></th>
								<th  style="text-align: center;background-color: lightgray !important;">Total Paid: </th>
								<th style="background-color: white;text-align:center;"><?php echo $paidinvoiceData[0]['paid_amount']; ?></th>
							</tr>
							<tr>
								<th colspan="3" style="text-align: center;">Remaining Amount</th>
								<th style="background-color: white;text-align:center;"><?php echo $remainAmount; ?></th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-sm-6 col-md-offset-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td style="font-weight: bold;background-color: #f1f1f1 !important;">
									Salesman:
								</td>
								<td style="text-align: center;">
									<?php 

										echo Yii::$app->user->identity->username;
									?>
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-sm-6 col-md-offset-3">
					<tr style="border:none;" class="footer">
						<td colspan="2" style="border:0px !important;" class="footer">
							<h4 style="text-align: center;background-color:#000000!important;padding:10px;color: white !important;">Thanks For Visting Us!</h4>
							<p style="text-align: center;">
								<i>Powered By:</i>&nbsp;<b>Dexterous Developers</b><br>Contact #: +92 (306) 377 2106<br><b>Website: </b><i>www.dexdevs.com</i>
							</p>
						</td>
					</tr>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php } ?>
<!DOCTYPE html>
<html>
<head>
<script>
// function printContent(el){
// 	var restorepage = document.body.innerHTML;
// 	var printcontent = document.getElementById(el).innerHTML;
// 	document.body.innerHTML = printcontent;
// 	window.print();
// 	document.body.innerHTML = restorepage;
// }
function returnBack() {
  window.location='purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>';
}
</script>
