<?php 
 use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<div class="container-fluid">	<div class="row">
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
					<form method="post">
						<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
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
								
								<input type="hidden" name="custID" value="<?php echo $customerID; ?>">
								<input type="hidden" name="invID" value="<?php echo $sihID; ?>">
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Collect</label>
									<!-- <input type="number" name="collect" id="collect_amount" class="form-control" oninput="cal_remaining()"> -->
									<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||  event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" name="collect" id="collect_amount" class="form-control" oninput="cal_remaining()">

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
								<input type="hidden" name="custID" value="<?php echo $customerID; ?>">
								<input type="hidden" name="invID" value="<?php echo $sihID; ?>">	
								<!-- <input type="hidden" name="regno" value="<?php //echo $regNoID; ?>"> -->	
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
							<div class="col-md-1">
								
							</div>
							<div class="col-md-10">
								<div class="alert-danger glyphicon glyphicon-ban-circle" style="padding: 10px;" id="alert">
	            				</div>
	            				<hr>								
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<a href="./sale-invoice-view" class="btn btn-danger" style="width: 100%;"><i class="glyphicon glyphicon-backward"></i>&nbsp;Back</a>
							</div>
							<div class="col-md-6">
								<button type="submit" name="insert_collect" id="insert" class="btn btn-success" disabled style="width: 100%;"><i class="fa fa-money" aria-hidden="true"></i>&ensp;Collect Invoice</button>
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
<?php 
	if(isset($_POST['insert_collect']))
{
  $customerID  = $_POST['custID'];
  $invID       = $_POST['invID'];
  $netTotal    = $_POST['net_total'];
  $paid_amount = $_POST['paid_amount'];
  $remaining   = $_POST['remaining'];
  $collect     = $_POST['collect'];
  $status      = $_POST['status'];
  $narration   = $_POST['narration'];

  $id   =Yii::$app->user->identity->id;

  // starting of transaction handling
  $transaction = \Yii::$app->db->beginTransaction();
  try {
    $insert_invoice_head = Yii::$app->db->createCommand()->update('sale_invoice_head',[
       'net_total'        => $netTotal,
       'paid_amount'      => $paid_amount,
       'remaining_amount' => $remaining,
       'status'           => $status,
       'created_by'       => $id,
      ],
      ['customer_id' => $customerID,'sale_inv_head_id' => $invID ]
    )->execute();

    $insert_invoice_amount = Yii::$app->db->createCommand()->insert('sale_invoice_amount_detail',[
        'sale_inv_head_id' => $invID,
        'transaction_date' => new \yii\db\Expression('NOW()'),
        'paid_amount' => $collect,
        'created_by' => $id,

      ])->execute();
    if ($insert_invoice_amount) {
		$invoice_amount = Yii::$app->db->createCommand("
		    SELECT 	*
		    FROM sale_invoice_amount_detail
		    WHERE sale_inv_head_id	= '$invID'
		    ORDER BY s_inv_amount_detail DESC
		    ")->queryAll();
		$invoice_amount = $invoice_amount[0]['s_inv_amount_detail'];
	    
	    $acc_head_id = 5;
	    $transactions = Yii::$app->db->createCommand()->insert('transactions',
		    [
		      'branch_id' => Yii::$app->user->identity->branch_id,
		      'type' => 'Cash',
		      'narration' => $narration,
		      'account_head_id' => $acc_head_id,
		      'total_amount' => $netTotal,
		      'amount' => $paid_amount,
		      'remaining' => $remaining,
		      'transactions_date' => date('Y-m-d'),
		      'head_id' => $invID,
		      'ref_no' => $invoice_amount,
			  'ref_name' => "Sale",
		      'created_by' => \Yii::$app->user->identity->id,
		    ])->execute();
	}
     // transaction commit
     $transaction->commit();
     \Yii::$app->response->redirect(["./sale-invoice-view"]);
        
     } // closing of try block 
     catch (Exception $e) {
     	echo $e;
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
}


 ?>
<script>
	 $(document).ready(function(){
		$('#collect_amount').focus();
	});
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
            $('#alert').html("&ensp;Please Enter the Valid  amount");
      		//$('#insert').hide();
      	}
      	if (collect < 0) {
      		//$('#insert').hide();
      		$("#insert").attr("disabled", true);
      		$('#msg').css("display","block");
            $('#alert').html("&ensp;Please Enter the Valid Amount");
      	}
      	var emp_collect = $('#collect_amount').val();
      	if(emp_collect == '' || empty(emp_collect)){
      		var credit = $('#remain_amount').val();
      		var pamount = $('#pamount').val();
      		$('#remaining_amount').val(credit); 
      		$('#paid_amount').val(pamount);
      		//$('#insert').hide();
      		$("#insert").attr("disabled", true);
      	}
    }
   
</script>