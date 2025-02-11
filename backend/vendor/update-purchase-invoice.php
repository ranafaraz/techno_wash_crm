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
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
			<div class="row">		
			<div class="col-md-12">
			    <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Vendor (<b><?php echo $vendorData[0]['name']; ?></b>) <?php if ($statusCheck == "Paid"){
			    	echo 'Paid';
			    }else {
			    	echo "Credit";
			    } ?> Invoice</h2>
			</div>
		</div>
		<div class="row" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">
			<form action="purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>" method="POST" accept-charset="utf-8">
				<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Bilty No:</label>
								<input type="text" name="bilty_no" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="bilty_no" class="form-control" value="<?=$updateinvoiceData[0]['bilty_no']?>" oninput="inputchange()">
							</div>
							<div class="form-group">
								<label>Bill No:</label>
								
								<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||  event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="bilty_no" class="form-control"name="bill_no" id="bill_no" class="form-control" value="<?=$updateinvoiceData[0]['bill_no']?>" oninput="inputchange()">
							</div>
							<div class="form-group">
								<label>Purchase Date</label>
								<?php $date = date('Y-m-d',strtotime($updateinvoiceData[0]['purchase_date']));?>
								<input type="date" name="purchase_date" id="purchase_date" class="form-control" value="<?php echo $date;?>" onchange="inputchange()">
							</div>
							<div class="form-group">
								<label>Dispatch Date</label>
								<?php $date = date('Y-m-d',strtotime($updateinvoiceData[0]['dispatch_date']));?>
								<input type="date" name="dispatch_date" id="dispatch_date" class="form-control" value="<?php echo $date;?>" onchange="inputchange()">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Receiving Date</label>
								<?php $date = date('Y-m-d',strtotime($updateinvoiceData[0]['receiving_date']));?>
								<input type="date" name="receiving_date" id="receiving_date" class="form-control" value="<?php echo $date;?>" onchange="inputchange()">
							</div>
							<div class="form-group">
								<label>Discount</label> &emsp;
								 <input type="radio" name="discountType" id="amount"   checked  onclick="discEmpty()">Amount
									&emsp;
								  <input type="radio" name="discountType" id="percentage" onclick="discEmpty()">Percentage
								<input type="text" name="discount" oninput="discountFun()" class="form-control" id="disc" value="<?php echo $updateinvoiceData[0]['discount'];?>">
							</div>
							<input type="hidden" name="update_discount" id="update_disc" value="<?php echo $updateinvoiceData[0]['discount'];?>">
							
							<div class="form-group">
								<label>Paid Amount</label>
								
								<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||  event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" name="paid_amount" id="paid_amount" class="form-control" value="<?php echo $updateinvoiceData[0]['paid_amount'];?>" oninput="cal_remaining()">

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Total Amount</label>
								<input type="number" name="total_amount" id="tp" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['total_amount'];?>">
							</div>
							<div class="form-group">
								<label>Net Total</label>
								<input type="text" name="net_total" id="nt" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['net_total'];?>">
							</div>
							<div class="form-group">
								<label>Remaining</label>
								<input type="number" name="remaining_amount" id="remaining" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['remaining_amount'];?>">
							</div>
							<div class="form-group">
								<label>Status</label>
								<?php $status = $updateinvoiceData[0]['status'];?>
								<input type="text" name="status" id="status" class="form-control" readonly="" value="<?=$status ?>">
							</div>
							
							<input type="hidden" name="piID" value="<?php echo $purchaseInvID; ?>">
							<input type="hidden" name="vendorID" value="<?php echo $vendorID; ?>">	
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h3 style="color:#367FA9;margin-bottom:20px;">Transaction Details</h3>
						</div>
					</div>
					<?php 

						for ($amount=0; $amount <$countPurchaseInvAmount ; $amount++) {
						$transDate = date('Y-m-d',strtotime($purchaseInvAmount[$amount]['transaction_date']));
						$paidAmount = $purchaseInvAmount[$amount]['paid_amount']; 
						
					?>
					<div class="row">
						<div class="col-md-4" style="padding-top: 5px;background-color:lightgray;">
							<div class="form-group">
								<label>Transaction Date</label>
								<input type="date" name="transaction_date[]"class="form-control" value="<?php echo $transDate;?>">
							</div>
						</div>
						<div class="col-md-4" style="padding-top: 5px;background-color:lightgray;">
							<div class="form-group">
								<label>Paid Amount</label>
								<input type="text" name="detail_paid_amount[]" class="form-control" value="<?php echo $paidAmount;?>" oninput="cal_paid_amount(<?php echo $amount; ?>, <?php echo $countPurchaseInvAmount; ?>)" id="d_p_a_<?php echo $amount; ?>">
								<input type="hidden" name="purchaseInvAmountID[]" value="<?php echo $purchaseInvAmount[$amount]['p_inv_amount_detail'];?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
							</div>
						</div>
						<div class="col-md-4">
							
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
							<a href="./purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>" class="btn btn-danger" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
						</div>
						<div class="col-md-3">
							<button type="submit" name="update_invoice" id="update" class="btn btn-success" style="width: 100%;"><i class="glyphicon glyphicon-open"></i> Update Invoice</button>								
						</div>
					</div>				
			</form>
			
		</div>
		</div>
	</div>
	</div>
</body>
</html>

 <?php } ?>
 <script>
 	function inputchange(){
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