<?php 
use common\models\Branches;
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
use yii\helpers\Html;
use kartik\dialog\Dialog;

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
		<div class="col-md-6 col-md-offset-3">
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
									<!-- <tr>
										<th style="background-color:#3C8DBC;color:white;">Bilty No#:</th>
										<td><?php echo $creditInvoiceData[0]['bilty_no'];?></td>
									</tr> -->
									<tr>
										<th style="background-color:#3C8DBC;color:white;">Bill No#:</th>
										<td><?php echo $creditInvoiceData[0]['bill_no'];?></td>
									</tr>
								</thead>
							</table>
						</div>
					</div><hr style="border:1px solid #3C8DBC ;">
					<form method="post">
						<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
						<div class="row">
							<div class="col-md-12" style="margin-bottom: 5px !important;">
								<label>Transaction Date</label>
								<?PHP $transaction_date = date('Y-m-d');?>
								<input type="date" name="transaction_date" class="form-control" value="<?PHP echo $transaction_date;?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Net Total</label>
									<input type="text" name="net_total" id="nt" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['net_total'];?>">
								</div>
								<div class="form-group">
									<label>Credit</label>
									<input type="text" name="remain" id="remain_amount" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['remaining_amount'];?>">

									<input type="hidden" name="ramount" id="ramount" value="<?php echo $creditInvoiceData[0]['remaining_amount'];?>">
								</div>
								<div class="form-group">
									<label>Paid</label>
									<input type="text" name="paid_amount" id="paid_amount" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['paid_amount'];?>">

									<input type="hidden" name="pamount" id="pamount" value="<?php echo $creditInvoiceData[0]['paid_amount'];?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Pay</label>
									<input type="text" name="pay" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" name="pay" id="pay_amount" class="form-control" oninput="cal_remaining()">
								</div>
								<div class="form-group">
									<label>Status</label>
									<input type="text" name="status" id="status" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['status'];?>">
								</div>
								
								<div class="form-group">
									<label>Remaining</label>
									<input type="text" name="remaining" id="remaining_amount" class="form-control" readonly="" value="<?php echo $creditInvoiceData[0]['remaining_amount'];?>">

									<input type="hidden" name="ramount" id="ramount" value="<?php echo $creditInvoiceData[0]['remaining_amount'];?>">
								</div>
								<input type="hidden" name="vendorID" value="<?php echo $vendorID; ?>">
								<input type="hidden" name="piID" value="<?php echo $purchaseInvID; ?>">	
							</div>	
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Narration</label>
									<input type="text" name="narration" id="narration" class="form-control">
								</div>
							</div>
						</div>
						<div class="row" id="msg" style="display: none;">
							<div class="col-md-12">
								<div class="alert-danger glyphicon glyphicon-ban-circle" style="padding: 10px;" id="alert">
	            				</div>
	            				<hr>								
							</div>												
						</div>
						<div class="row">
							<div class="col-md-6">
								<a href="./purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>" class="btn btn-warning" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i>&ensp;Back</a>
							</div>
							<div class="col-md-6">
								<button type="submit" name="insert_pay" id="insert" class="btn btn-success" disabled style="width: 100%;"><i class="fa fa-money" aria-hidden="true"></i>&ensp;Pay Invoice</button>
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
<?php } ?>
<?php 
if(isset($_POST['insert_pay']))
{
    $piID        = $_POST['piID'];
    $vendorID    = $_POST['vendorID'];
    $netTotal    = $_POST['net_total'];
    $paid_amount = $_POST['paid_amount'];
    $remaining   = $_POST['remaining'];
    $pay         = $_POST['pay'];
    $status      = $_POST['status'];
    $narration   = $_POST['narration'];
    $transaction_date = $_POST['transaction_date'];
    $id   =Yii::$app->user->identity->id;

    // starting of transaction handling
    $transaction = \Yii::$app->db->beginTransaction();
    try {
     	$insert_purchase_invoice = Yii::$app->db->createCommand()->update('purchase_invoice',[

	     'net_total'        => $netTotal,
	     'paid_amount'      => $paid_amount,
	     'remaining_amount' => $remaining,
	     'status'           => $status,
	     'created_by'       => $id,
    	],
       ['vendor_id' => $vendorID ,'purchase_invoice_id' => $piID]
    	)->execute();

     	$purchase_invoice_amount = Yii::$app->db->createCommand()->insert('purchase_invoice_amount_detail',[
			    'purchase_invoice_id' => $piID,
			    'transaction_date'    => $transaction_date,
			    'paid_amount'       => $pay,
			    'created_by'      => $id,
			 ])->execute();

	    if ($purchase_invoice_amount) {
			$invoice_amount = Yii::$app->db->createCommand("
			    SELECT 	*
			    FROM purchase_invoice_amount_detail
			    WHERE purchase_invoice_id	= '$piID'
			    ORDER BY p_inv_amount_detail DESC
			    ")->queryAll();
				$invoice_amount = $invoice_amount[0]['p_inv_amount_detail'];
	
	    	// getting current asset from Account Nature and cash debit account from account head;
		    $head = AccountHead::find()->where(['account_name' => 'Cash'])->One();
		    $cred = AccountHead::find()->where(['account_name' => 'Account Payable'])->One();

		    $transactions = Yii::$app->db->createCommand()->insert('transactions',
		    [
		      'branch_id' => Yii::$app->user->identity->branch_id,
		      'type' => 'Cash Payment',
		      'narration' => $narration,
		      // 'credit_account' => $head->id,
		      'account_head_id' => 6,
		      'amount' => $pay,
		      'ref_no' => $invoice_amount,
			  'ref_name' => "Purchase",
		      'transactions_date' => $transaction_date,
		      'created_by' => $id,
		    ])->execute();
	
		}
	    
	    // transaction commit
	    $transaction->commit();
	    Yii::$app->response->redirect(['./purchase-invoice-view', 'vendor_id' => $vendorID]);
    } // closing of try block 
    catch (Exception $e) {
    	echo $e;
        $transaction->rollback();
    } // closing of catch block
}
 ?>
<script>
	 $(document).ready(function(){
		$('#pay_amount').focus();
	});
	 
	function cal_remaining(){
      	var paid = parseInt($('#paid_amount').val());
      	var pamount = parseInt($('#pamount').val());
      	var ramount = parseInt($('#ramount').val());
      	var nt = parseInt($('#nt').val());
      	var pay = parseInt($('#pay_amount').val());
      	var remaining = parseInt($('#remaining_amount').val());

      	var remainingAmount = ramount - pay;
      	var collectedAmount = pay + pamount;
      	// alert(remainingAmount);
      	// alert(collectedAmount);

      	$('#remaining_amount').val(remainingAmount); 
      	$('#paid_amount').val(collectedAmount); 
      	if (remainingAmount == 0 && nt == collectedAmount) {
      		$('#status').val('Paid');
      		//$('#insert').show();
      		$('#msg').css("display","none");
      		$("#insert").removeAttr("disabled");
      	}
      	else if (remainingAmount > 0) {
      		$('#status').val('Partially');
      		//$('#insert').show();
      		$('#msg').css("display","none");
      		$("#insert").removeAttr("disabled");
      	} else if (remainingAmount < 0) {
      		//alert("Amount is Greated..!");
      		$("#insert").attr("disabled", true);
      		$('#msg').css("display","block");
            $('#alert').html("&ensp;Pay Amount Cannot Be Lesser And Greater Than Reamaining Amount");
      		//$('#insert').hide();
      	}
      	if (pay < 0) {
      		//$('#insert').hide();
      		$("#insert").attr("disabled", true);
      		$('#msg').css("display","block");
            $('#alert').html("&ensp;Pay Amount Cannot Be Negative");
      	}
      	var emp_pay = $('#pay_amount').val();
      	if(emp_pay == '' || empty(emp_pay)){
      		var credit = $('#remain_amount').val();
      		var pamount = $('#pamount').val();
      		$('#remaining_amount').val(credit); 
      		$('#paid_amount').val(pamount);
      		//$('#insert').hide();
      		$("#insert").attr("disabled", true);
      	}
    }

</script>