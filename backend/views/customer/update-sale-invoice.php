<?php 
	if (isset($_GET['saleinvheadID']) && isset($_GET['customerid']) && isset($_GET['regno'])) {
	$saleinvHeadID = $_GET['saleinvheadID'];
	$customerid = $_GET['customerid'];
	$regNoID = $_GET['regno'];

	$updateinvoiceData = Yii::$app->db->createCommand("
	    SELECT *
	    FROM sale_invoice_head
	    WHERE sale_inv_head_id = '$saleinvHeadID'
	    ")->queryAll();
	    $countupdateinvoiceData = count($updateinvoiceData);

	$customerData = Yii::$app->db->createCommand("
	    SELECT *
	    FROM customer
	    WHERE customer_id = $customerid
	    ")->queryAll();
	$saleInvoiceAmount = Yii::$app->db->createCommand("
	    SELECT *
	    FROM sale_invoice_amount_detail
	    WHERE sale_inv_head_id = '$saleinvHeadID'
	    ")->queryAll();
	$countSaleInvAmount = count($saleInvoiceAmount);
	//echo $countSaleInvAmount;

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container">
		
		<form method="POST" accept-charset="utf-8">
		<div class="row">
			<div class="col-md-2">
				
			</div>
			<div class="col-md-8">
				<div class="row">		
					<div class="col-md-10">
					    <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update (<b><?php echo $customerData[0]['customer_name']; ?></b>) Paid Invoice</h2>
					</div>
				</div>
				<div class="row" style="background-color:white;padding:10px;border-top:2px solid #367FA9;">
					<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
					<div class="col-md-6">
						<div class="form-group">
							<label>Date</label>
							<?php $date = date('Y-m-d',strtotime($updateinvoiceData[0]['date']));?>
							<input type="date" name="date" id="date" class="form-control" value="<?php echo $date;?>" onchange="datechange()">
						</div>
						<div class="form-group">
							<label>Discount</label> &emsp;
							 <input type="radio" name="discountType" id="amount"   checked  onclick="discEmpty()">Amount
								&emsp;
							  <input type="radio" name="discountType" id="percentage" onclick="discEmpty()">Percent
							<input type="text" name="discount" oninput="discountFun()" class="form-control" id="disc" value="<?php echo $updateinvoiceData[0]['discount'];?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
						</div>
						<div class="form-group">
							<label>Remaining</label>
							<input type="number" name="remaining_amount" id="remaining" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['remaining_amount'];?>">
						</div>
								
							<input type="hidden" name="custID" value="<?php echo $customerid; ?>">
							<input type="hidden" name="invID" value="<?php echo $saleinvHeadID; ?>"
							>
							<input type="hidden" name="regno" value="<?php echo $regNoID; ?>">	
							<input type="hidden" name="update_discount" id="update_disc" value="<?php echo $updateinvoiceData[0]['discount'];?>">
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Total Amount</label>
							<input type="number" name="total_amount" id="tp" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['total_amount'];?>">
						</div>
						<div class="form-group">
							<label>Net Total</label>
							<input type="text" name="net_total" id="nt" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['net_total'];?>">
						</div>
						<div class="form-group">
							<label>Paid Amount</label>
							<input type="number" name="paid_amount" id="paid_amount" class="form-control" value="<?php echo $updateinvoiceData[0]['paid_amount'];?>" readonly="">
						</div>
					</div>
				</div>
				<div class="row">		
					<div class="col-md-12" style="background-color: white;">
					    <div class="form-group">
							<label>Status</label>
							<?php $status = $updateinvoiceData[0]['status'];?>
							<input type="text" name="status" id="status" class="form-control" readonly="" value="<?=$status?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3 style="color:#367FA9;margin-bottom:20px;">Transaction Details</h3>
					</div>
				</div>
				<?php 
				for ($amount=0; $amount <$countSaleInvAmount ; $amount++) { 
					$transDate = date('Y-m-d',strtotime($saleInvoiceAmount[$amount]['transaction_date']));
					$paidAmount = $saleInvoiceAmount[$amount]['paid_amount'];
					$transid = $saleInvoiceAmount[$amount]['transaction_id'];

				?>
				<div class="row">
					<div class="col-md-4" style="padding:5px;background-color:lightgray;">
						<div class="form-group">
							<label>Transaction Date</label>
							<input type="date" name="transaction_date[]"class="form-control" value="<?php echo $transDate;?>">
							<input type="text" style="display: none !Important;" name="transaction_id[]" value="<?= $transid;?>">
						</div>
					</div>
					<div class="col-md-4" style="padding:5px;background-color:lightgray;">
						<div class="form-group">
							<label>Paid Amount</label>
							<input type="text" name="detail_paid_amount[]" class="form-control" value="<?php echo $paidAmount;?>" oninput="cal_paid_amount(<?php echo $amount; ?>, <?php echo $countSaleInvAmount; ?>)" id="d_p_a_<?php echo $amount; ?>">
							<input type="hidden" name="saleInvAmountID[]" value="<?php echo $saleInvoiceAmount[$amount]['s_inv_amount_detail'];?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;text-align: center;" id="alert">
	    				</div>								
					</div>							
				</div>
				<br />
				<div class="row">
					<div class="col-md-2">
						<a href="./sale-invoice-view?customer_id=<?php echo $customerid; ?>&regno=<?=$regNoID?>" class="btn btn-danger" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
					</div>
					<div class="col-md-3">
						<button type="submit" name="update_invoice" id="update" class="btn btn-success" disabled style="width: 100%;"><i class="glyphicon glyphicon-open"></i> Update Invoice</button>								
					</div>
				</div>
			</div>
			<div class="col-md-2">
				
			</div>
		</div>
		<form>
	</div>
</body>
</html>
<?php } ?>
<?php 

 if(isset($_POST['update_invoice']))
 {
   $customerID              = $_POST['custID'];
   $invID                   = $_POST['invID'];
   $regNoID                 = $_POST['regno'];
  // $net_total               = $_POST['net_total'];
   $updateDate              = $_POST['date'];
   $updateDiscount          = $_POST['update_discount'];
   $updatetotalamount       = $_POST['total_amount'];
   $updatedpaidAmount       = $_POST['paid_amount'];
   $updatenetTotal          = $_POST['net_total'];
   $updateremainingAmount   = $_POST['remaining_amount'];
   $updatestatus            = $_POST['status'];

   $transactionDateArray    = $_POST['transaction_date'];
   $paidAmountArray         = $_POST['detail_paid_amount'];
   $saleInvAmountIDArray    = $_POST['saleInvAmountID'];
   $transaction_update_id  = $_POST['transaction_id'];
   
   $id   =Yii::$app->user->identity->id;

     // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $insert_invoice_head = Yii::$app->db->createCommand()->update('sale_invoice_head',[

     'date' => $updateDate,
     'total_amount' => $updatetotalamount,
     'discount' => $updateDiscount,
     'net_total' => $updatenetTotal,
     'paid_amount' => $updatedpaidAmount,
     'remaining_amount' => $updateremainingAmount,
     'status' => $updatestatus,
    ],
       ['customer_id' => $customerID,'sale_inv_head_id' => $invID ]

    )->execute();

    $countpaidAmountArray = count($paidAmountArray);

    $counttransid = count($transaction_update_id);

    for($i=0; $i<$countpaidAmountArray; $i++){
      $s_inv_amount_detail = Yii::$app->db->createCommand()->update('sale_invoice_amount_detail',[
      'transaction_date' => $transactionDateArray[$i],
      'paid_amount' => $paidAmountArray[$i],
      ],
         ['sale_inv_head_id' => $invID , 's_inv_amount_detail' => $saleInvAmountIDArray[$i]]

      )->execute();

      $tran = Yii::$app->db->createCommand()->update('transactions',
        [
          'transactions_date' => $transactionDateArray[$i],
          'amount' => $paidAmountArray[$i],
          'narration' => 'After Updation paid '.$paidAmountArray[$i].' out of total ' .$updatetotalamount,
        ],['ref_no' => $saleInvAmountIDArray[$i], 'ref_name' => "Sale"]
      )->execute();

    }
     // transaction commit
     $transaction->commit();
      \Yii::$app->response->redirect(["./sale-invoice-view?customer_id=$customerID&regno=$regNoID"]);
     
        
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
 	function datechange(){
 		$('#alert').css("display","none");
      	$("#update").removeAttr("disabled");
 	}
	function discEmpty(){
		if(document.getElementById('percentage').checked)
              {
              	$('#disc').val("");
              	$('#paid_amount').val("");
              	$('#disc').focus();
              }
              else if(document.getElementById('amount').checked)
            {
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
        
          if(document.getElementById('percentage').checked)
              {
              	
            discount = parseInt(document.getElementById("disc").value);
            
            discountReceived = parseInt((originalPrice*discount)/100);
            
            purchasePrice = originalPrice-discountReceived;
            $('#nt').val(purchasePrice);
            $('#update_disc').val(discountReceived);
            //alert(purchasePrice);
              }
            else if(document.getElementById('amount').checked)
            {
            	
            discount = parseInt(document.getElementById("disc").value);
                  
            purchasePrice = originalPrice - discount;
            //alert(purchasePrice);
              //discountReceived = discount;
             $('#nt').val(purchasePrice);
             $('#update_disc').val(discount);
            // $('#paid_amount').val("");

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
      	//alert(paid);
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