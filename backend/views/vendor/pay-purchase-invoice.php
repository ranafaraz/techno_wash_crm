<?php 

  if (isset($_GET['piID']) && isset($_GET['vendorID'])) {
	$purchaseInvID = $_GET['piID'];
	$vendorID = $_GET['vendorID'];
  	

  	// getting customer name
  	$vendorData = Yii::$app->db->createCommand("
    SELECT *
    FROM vendor
    WHERE vendor_id = $vendorID
    ")->queryAll();

    $creditInvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice 
    WHERE vendor_id = '$vendorID' 
    AND  purchase_invoice_id = '$purchaseInvID'
    ")->queryAll();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
tr th{
  vertical-align:middle !important;
} 
tr td{
  vertical-align:middle !important;
}    
</style>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-default">
				<div class="box-body">
					<p style="color:#3C8DBC;font-size:25px;text-align: center;font-family:georgia;margin-bottom:-15px;">Pay Invoice</p>
					<hr style="border:1px solid #3C8DBC ;">
					<div class="row" style="margin-bottom:-20px;">
						<div class="col-md-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="background-color:#3C8DBC;color:white;">INV #:</th>
										<td><?php echo $purchaseInvID; ?></td>
									</tr>
									<tr>
										<th style="background-color:#3C8DBC;color:white;">Vendor:</th>
										<td><?php echo $vendorData[0]['name']; ?></td>
									</tr>
									<tr>
										<th style="background-color:#3C8DBC;color:white;">Bilty No#:</th>
										<td><?php echo $creditInvoiceData[0]['bilty_no'];?></td>
									</tr>
									<tr>
										<th style="background-color:#3C8DBC;color:white;">Bill No#:</th>
										<td><?php echo $creditInvoiceData[0]['bill_no'];?></td>
									</tr>
								</thead>
							</table>
						</div>
					</div><hr style="border:1px solid #3C8DBC ;">
					<form method="post" action="purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>">
						<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Net Total</label>
									<input type="text" name="net_total" id="nt" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['net_total'];?>">
								</div>
								<div class="form-group">
									<label>Paid</label>
									<input type="text" name="paid_amount" id="paid_amount" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['paid_amount'];?>">

									<input type="hidden" name="pamount" id="pamount" value="<?php echo $creditInvoiceData[0]['paid_amount'];?>">
								</div>
								<div class="form-group">
									<label>Remaining</label>
									<input type="text" name="remaining" id="remaining_amount" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['remaining_amount'];?>">

									<input type="hidden" name="ramount" id="ramount" value="<?php echo $creditInvoiceData[0]['remaining_amount'];?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Pay</label>
									<input type="number" name="pay" id="pay_amount" class="form-control" oninput="cal_remaining()">
								</div>
								<div class="form-group">
									<label>Status</label>
									<input type="text" name="status" id="status" class="form-control" readonly="">
								</div>
								<input type="hidden" name="vendorID" value="<?php echo $vendorID; ?>">
								<input type="hidden" name="piID" value="<?php echo $purchaseInvID; ?>">	
							</div>	
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<a href="./purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>" class="btn btn-danger" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i>&ensp;Back</a>
							</div>
							<div class="col-md-6">
								<button type="submit" name="insert_pay" id="insert" class="btn btn-success" style="display: none;width: 100%;"><i class="fa fa-money" aria-hidden="true"></i>&ensp;Pay Invoice</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>
	function cal_remaining(){

      	var paid = parseInt($('#paid_amount').val());
      	var pamount = parseInt($('#pamount').val());
      	var ramount = parseInt($('#ramount').val());
      	var nt = parseInt($('#nt').val());
      	var pay = parseInt($('#pay_amount').val());
      	var remaining = parseInt($('#remaining_amount').val());

      	var remainingAmount = ramount - pay;
      	var payedAmount = pay + pamount;
      	// alert(remainingAmount);
      	// alert(payedAmount);

      	$('#remaining_amount').val(remainingAmount); 
      	$('#paid_amount').val(payedAmount); 
      	if (remainingAmount == 0 && nt == payedAmount) {
      		$('#status').val('Paid');
      		$('#insert').show();
      	}
      	else if (remainingAmount > 0) {
      		$('#status').val('Partially');
      		$('#insert').show();
      	} else if (remainingAmount < 0) {
      		alert("Amount is Greated..!");
      		$('#pay_amount').val('');
      		$('#insert').hide();
      	}
      	if (pay < 0) {
      		$('#insert').hide();
      	}
    }
</script>

?>

<?php } ?>