<?php 

if (isset($_GET['piID']) && isset($_GET['vendorID'])) {
	$purchaseInvID = $_GET['piID'];
	$vendorID = $_GET['vendorID'];
	$vendorData = Yii::$app->db->createCommand("
	    SELECT *
	    FROM vendor
	    WHERE vendor_id = $vendorID
	    ")->queryAll();

	$updateinvoiceData = Yii::$app->db->createCommand("
	    SELECT *
	    FROM purchase_invoice
	    WHERE purchase_invoice_id = '$purchaseInvID' 
	    AND vendor_id = '$vendorID'
	    ")->queryAll();
    $countupdateinvoiceData = count($updateinvoiceData);
    $statusCheck = $updateinvoiceData[0]['status'];

    $purchaseInvAmount = Yii::$app->db->createCommand("
    SELECT *
    FROM  purchase_invoice_amount_detail
    WHERE purchase_invoice_id = '$purchaseInvID'
    ")->queryAll();
	$countPurchaseInvAmount = count($purchaseInvAmount);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<form method="POST" accept-charset="utf-8">
			<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
			<div class="col-md-8">
				<div class="box box-warning">
					<div class="box-header">
						<h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#367FA9;">Update Vendor (<b><?php echo $vendorData[0]['name']; ?></b>) <?php if ($statusCheck == "Paid"){
					    	echo 'Paid';
					    }else {
					    	echo "Credit";
					    } ?> Invoice</h3>
					    <div class="row" style="padding:16px;">
					    	<div class="col-md-4" style="border-top:2px solid #D2D6DE;padding:10px;border-right:2px solid #D2D6DE;">
					    		<div class="form-group">
									<label>Purchase Date</label>
									<?php $date = date('Y-m-d',strtotime($updateinvoiceData[0]['purchase_date']));?>
									<input type="date" name="purchase_date" id="purchase_date" class="form-control" value="<?php echo $date;?>" onchange="inputchange()">
									<input type="hidden" name="update_discount" id="update_disc" value="<?php echo $updateinvoiceData[0]['discount'];?>">
									<input type="hidden" name="piID" value="<?php echo $purchaseInvID; ?>">
									<input type="hidden" name="vendorID" value="<?php echo $vendorID; ?>">
								</div>
								<div class="form-group">
									<label>Bill No:</label>							
									<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||  event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="bilty_no" class="form-control"name="bill_no" id="bill_no" class="form-control" value="<?=$updateinvoiceData[0]['bill_no']?>" oninput="inputchange()">
								</div>
									<label>Invoice Status: </label>
									<?php if ($statusCheck == "Paid"){ ?>
										<div class="well" style="text-align: center;border:2px solid #008D4C;">
											<i class="glyphicon glyphicon-ok-circle" style="font-size:30px;color:#008D4C;"></i>
											<br>
											<b>Paid</b>
										</div>
								   	<?php } ?>
								   	<?php if ($statusCheck == "Unpaid"){ ?>
								   		<div class="well" style="text-align: center;border:2px solid #D73925;">
								   			<i class="glyphicon glyphicon-remove-circle" style="font-size:30px;color:#D73925;"></i>
									    	<br>
											<b>Unpaid</b>
								   		</div>
								   	<?php } ?>
								   	<?php if ($statusCheck == "Partially"){ ?>
								   		<div class="well" style="text-align: center;border:2px solid #F39C12;">
								   			<i class="glyphicon glyphicon-thumbs-up" style="font-size:30px;color:#F39C12;"></i>
									    	<br>
											<b>Partially Paid</b>
								   		</div>
								   	<?php } ?>
					    	</div>
					    	<div class="col-md-8" style="border-top:2px solid #D2D6DE;">
					    		<h3 style="color:#000000;margin-bottom:5px;margin-top:6px;text-align: center;background-color:lightgray;padding:5px;">Transaction Details</h3>
					    		<?php  
								for ($amount=0; $amount <$countPurchaseInvAmount ; $amount++) {
									$transDate = date('Y-m-d',strtotime($purchaseInvAmount[$amount]['transaction_date']));
									$paidAmount = $purchaseInvAmount[$amount]['paid_amount']; 
									$transid = $purchaseInvAmount[$amount]['transaction_id'];	
								?>
								<div class="row" style="padding:0px;">
									<div class="col-md-6">
										<div class="form-group" style="">
											<label>Transaction Date</label>
											<input type="date" name="transaction_date[]"class="form-control" value="<?php echo $transDate;?>" style="background-color:#D2D6DE;">
										</div>
										<input type="hidden" name="purchaseInvAmountID[]" value="<?php echo $purchaseInvAmount[$amount]['p_inv_amount_detail'];?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
										<input type="text" style="display: none !Important;" name="transaction_id[]" value="<?= $transid;?>">
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Paid Amount</label>
											<input type="text" name="detail_paid_amount[]" class="form-control" value="<?php echo $paidAmount;?>" oninput="cal_paid_amount(<?php echo $amount; ?>, <?php echo $countPurchaseInvAmount; ?>)" id="d_p_a_<?php echo $amount; ?>">
										</div>
									</div>
								</div>
								<?php } ?>
					    	</div>
					    </div>
						<div class="row">
							<div class="col-md-12">
								<div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;text-align: center;" id="alert">
	            				</div>								
							</div>							
						</div><br>
						<div class="row">
					    	<div class="col-md-6"></div>
							<div class="col-md-3">
								<a href="./purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>" class="btn btn-danger btn-xs btn-block" style=""><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
							</div>
							<div class="col-md-3">
								<button type="submit" name="update_invoice" id="update" class="btn btn-success btn-xs  btn-block"  style=""><i class="glyphicon glyphicon-open"></i> Update Invoice</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-warning">
					<div class="box-header">
						<h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#367FA9;">
							Bill
						</h3>
						<table class="table">
							<thead>
								<tr>
									<td style="line-height:2.8;">
										<label>Total Amount</label>
									</td>
									<td>
										<div class="form-group">
											<input type="number" name="total_amount" id="tp" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['total_amount'];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td style="line-height:2.8;">
										<label>Discount</label>
									</td>
									<td>
										<div class="form-group">
											 <input type="radio" name="discountType" id="amount"   checked  onclick="discEmpty()">Amount
												&emsp;
											  <input type="radio" name="discountType" id="percentage" onclick="discEmpty()">Percentage
											<input type="text" name="discount" oninput="discountFun()" class="form-control" id="disc" value="<?php echo $updateinvoiceData[0]['discount'];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td style="line-height:2.8;">
										<label>Net Total</label>
									</td>
									<td>
										<div class="form-group">
											<input type="text" name="net_total" id="nt" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['net_total'];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td style="line-height:2.8;">
										<label>Paid Amount</label>
									</td>
									<td>
										<div class="form-group">
											<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||  event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" name="paid_amount" id="paid_amount" class="form-control" value="<?php echo $updateinvoiceData[0]['paid_amount'];?>" oninput="cal_remaining()" readonly="">

										</div>
									</td>
								</tr>
								<tr>
									<td style="line-height:2.8;">
										<label>Remaining</label>
									</td>
									<td>
										<div class="form-group">
											<input type="number" name="remaining_amount" id="remaining" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['remaining_amount'];?>">
										</div>
									</td>
								</tr>
								<tr class="invisible">
									<td style="line-height:2.8;">
										<label>Status</label>
									</td>
									<td>
										<div class="form-group">
											<?php $status = $updateinvoiceData[0]['status'];?>
											<input type="text" name="status" id="status" class="form-control" readonly="" value="<?=$status ?>">
										</div>
									</td>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>

 <?php } 
if(isset($_POST['update_invoice']))
{
  $piID                  = $_POST['piID'];
  $vendorID              = $_POST['vendorID'];
  //$bilty_no              = $_POST['bilty_no'];
  $bill_no               = $_POST['bill_no'];
  $purchase_date         = $_POST['purchase_date'];
  //$dispatch_date         = $_POST['dispatch_date'];
  //$receiving_date        = $_POST['receiving_date'];
  $updateDiscount        = $_POST['update_discount'];
  $updatepaidAmount      = $_POST['paid_amount'];
  $updatetotalamount     = $_POST['total_amount'];
  $updatenetTotal        = $_POST['net_total'];
  $updateremainingAmount = $_POST['remaining_amount'];
  $updatestatus          = $_POST['status'];
  $transactionDateArray    = $_POST['transaction_date'];
  $paidAmountArray         = $_POST['detail_paid_amount'];
  $purchaseInvAmountIDArray    = $_POST['purchaseInvAmountID'];
  $transaction_update_id  = $_POST['transaction_id'];

  $id   =Yii::$app->user->identity->id;

  // starting of transaction handling
  $transaction = \Yii::$app->db->beginTransaction();
  try {
    $insert_purchase_invoice = Yii::$app->db->createCommand()->update('purchase_invoice',[
     //'bilty_no' => $bilty_no,
     'bill_no' => $bill_no,
     'purchase_date' => $purchase_date,
     //'dispatch_date' => $dispatch_date,
     //'receiving_date' => $receiving_date,
     'total_amount' => $updatetotalamount,
     'discount' => $updateDiscount,
     'net_total' => $updatenetTotal,
     'paid_amount' => $updatepaidAmount,
     'remaining_amount' => $updateremainingAmount,
     'status' => $updatestatus,
    ],
       ['vendor_id' => $vendorID ,'purchase_invoice_id' => $piID]
    )->execute();

    $countpaidAmountArray = count($paidAmountArray);
    $counttransid = count($transaction_update_id);
    
    for($i=0; $i<$countpaidAmountArray; $i++){
      	$p_inv_amount_detail = Yii::$app->db->createCommand()->update('purchase_invoice_amount_detail',[
        
	      'transaction_date' => $transactionDateArray[$i],
	      'paid_amount' => $paidAmountArray[$i],
	      ],
         ['purchase_invoice_id' => $piID , 'p_inv_amount_detail' => $purchaseInvAmountIDArray[$i]]

      	)->execute();

      	$tran = Yii::$app->db->createCommand()->update('transactions',
        [
          'transactions_date' => $transactionDateArray[$i],
          'amount' => $paidAmountArray[$i],
          'narration' => 'After Updation paid '.$paidAmountArray[$i].' out of total ' .$updatetotalamount,
        ],['ref_no' => $purchaseInvAmountIDArray[$i], 'ref_name' => "Purchase"]
      	)->execute();
    }
     // transaction commit
      $transaction->commit();
      \Yii::$app->response->redirect(['./purchase-invoice-view', 'vendor_id' => $vendorID]);    
  } // closing of try block 
  catch (Exception $e) {
    // transaction rollback
    $transaction->rollback();
  } // closing of catch block
  // closing of transaction handling
}
 ?>
 <script>
 	function inputchange(){
 		$('#alert').css("display","none");
      	$("#update").removeAttr("disabled");
 	}
	function discEmpty(){
		if(document.getElementById('percentage').checked){
          	$('#disc').val("");
          	$('#paid_amount').val("");
          	$('#disc').focus();
        }else if(document.getElementById('amount').checked){
        	$('#disc').val("");
        	$('#paid_amount').val("");
        	$('#disc').focus();
        }
	}
	function discountFun(){
        // Getting the value from the original price
        originalPrice = parseInt(document.getElementById("tp").value);
        // alert(originalPrice);
        //discountType  = parseInt(document.getElementById("discountType").value);
        
        if(document.getElementById('percentage').checked) {	
            discount = parseInt(document.getElementById("disc").value);
            discountReceived = parseInt((originalPrice*discount)/100);
            purchasePrice = originalPrice-discountReceived;
            $('#nt').val(purchasePrice);
            $('#update_disc').val(discountReceived);
            //alert(purchasePrice);
        } else if(document.getElementById('amount').checked) {
            discount = parseInt(document.getElementById("disc").value);
            purchasePrice = originalPrice - discount;
            //alert(purchasePrice);
            //discountReceived = discount;
            $('#nt').val(purchasePrice);
            $('#update_disc').val(discount);

            //alert(originalPrice);
              
        } 
        cal_remaining();
    }
    function cal_paid_amount(i, count){
    	var paid=0;
      	for(var p=0; p<count; p++){
      		paid = paid+parseInt($('#d_p_a_'+p).val());
      	}
      	$('#paid_amount').val(paid);
      	cal_remaining();
    }    
 	function cal_remaining(){
      	var paid = $('#paid_amount').val();
      	var nt = $('#nt').val();
      	var remaining = nt - paid;
      	$('#remaining').val(remaining); 
      	if (remaining == 0) {
      		$('#status').val('Paid');
      	}
      	else if (remaining == nt && paid <= 0) {
      		$('#status').val('Unpaid');
      	}        
        else if (paid > 0) {
          $('#status').val('Partially');
        }
      	//$('#update').show();
      	$('#alert').css("display","none");
      	$("#update").removeAttr("disabled");

      	if(remaining < 0){
      		//$('#update').hide();
      		$("#update").attr("disabled", true);
      		$('#alert').css("display","block");
            $('#alert').html("&ensp;Please Enter A Valid Amount");
      	}
      	var eremaining = $('#remaining').val();
      	if(eremaining == '' || empty(eremaining)){
      		//$('#update').hide();
      		$("#update").attr("disabled", true);
      	}
    }     
 </script>