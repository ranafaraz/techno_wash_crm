<?php 

	$customerID = $_GET['customerID'];
	$sihID 		= $_GET['sihID'];
  	

  	// getting customer name
  	$customerData = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = $customerID
    ")->queryAll();

    // getting customer credit invoice data 
  	$creditInvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE customer_id = $customerID
    AND sale_inv_head_id = $sihID
    ")->queryAll();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-default">
				<div class="box-body">
					<p style="color:#3C8DBC;font-size:25px;text-align: center;font-family:georgia;margin-bottom:-15px;">Collect Invoice</p>
					<hr style="border:1px solid #3C8DBC ;">
					<div class="row" style="margin-bottom:-20px;">
						<div class="col-md-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="background-color:#3C8DBC;color:white;">INV #:</th>
										<td><?php echo $sihID; ?></td>
									</tr>
									<tr>
										<th style="background-color:#3C8DBC;color:white;">Customer:</th>
										<td><?php echo $customerData[0]['customer_name']; ?></td>
									</tr>
								</thead>
							</table>
						</div>
					</div><hr style="border:1px solid #3C8DBC ;">
					<form method="post" action="sale-invoice-view?customer_id=<?php echo $customerID; ?>">
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
								<input type="hidden" name="custID" value="<?php echo $customerID; ?>">
								<input type="hidden" name="invID" value="<?php echo $sihID; ?>">
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Collect</label>
									<input type="number" name="collect" id="collect_amount" class="form-control" oninput="cal_remaining()">
								</div>
								<div class="form-group">
									<label>Status</label>
									<input type="text" name="status" id="status" class="form-control" readonly="">
								</div>
								<input type="hidden" name="custID" value="<?php echo $customerID; ?>">
								<input type="hidden" name="invID" value="<?php echo $sihID; ?>">	
							</div>	
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<a href="./sale-invoice-view?customer_id=<?php echo $customerID; ?>" class="btn btn-danger" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i>&ensp;Back</a>
							</div>
							<div class="col-md-6">
								<button type="submit" name="insert_collect" id="insert" class="btn btn-success" style="display: none;width: 100%;"><i class="fa fa-money" aria-hidden="true"></i>&ensp;Collect Invoice</button>
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
      	var collect = parseInt($('#collect_amount').val());
      	var remaining = parseInt($('#remaining_amount').val());

      	var remainingAmount = ramount - collect;
      	var collectedAmount = collect + pamount;
      	// alert(remainingAmount);
      	// alert(collectedAmount);

      	$('#remaining_amount').val(remainingAmount); 
      	$('#paid_amount').val(collectedAmount); 
      	if (remainingAmount == 0 && nt == collectedAmount) {
      		$('#status').val('Paid');
      		$('#insert').show();
      	}
      	else if (remainingAmount > 0) {
      		$('#status').val('Partially');
      		$('#insert').show();
      	} else if (remainingAmount < 0) {
      		alert("Amount is Greated..!");
      		$('#collect_amount').val('');
      		$('#insert').hide();
      	}
      	if (collect < 0) {
      		$('#insert').hide();
      	}
    }
</script>