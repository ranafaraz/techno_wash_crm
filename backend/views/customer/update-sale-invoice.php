<?php 
if (isset($_GET['sihID']) && isset($_GET['customerID'])) {
	$saleHeadID = $_GET['sihID'];
	$customerID = $_GET['customerID'];

$updateinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE sale_inv_head_id = '$saleHeadID' AND (status = 'Unpaid' OR status = 'Partially')
    ")->queryAll();
    $countupdateinvoiceData = count($updateinvoiceData);

$customerData = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = $customerID
    ")->queryAll();

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
			<div class="row">		
			<div class="col-md-12">
			    <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Update Customer Invoice (<b><?php echo $customerData[0]['customer_name']; ?></b>)</h2>
			</div>
		</div>
		<div class="row" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">
			<form action="sale-invoice-view?customer_id=<?php echo $customerID; ?>" method="POST" accept-charset="utf-8">
					<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Date</label>
									<?php $date = date('20y-m-d',strtotime($updateinvoiceData[0]['date']));?>
									<input type="date" name="date" id="date" class="form-control" value="<?php echo $date;?>" onchange="datechange()">
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
									<input type="number" name="paid_amount" id="paid_amount" class="form-control" value="<?php echo $updateinvoiceData[0]['paid_amount'];?>" oninput="cal_remaining()">
								</div>
								
								
								<input type="hidden" name="custID" value="<?php echo $customerID; ?>">
								<input type="hidden" name="invID" value="<?php echo $saleHeadID; ?>">
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
									<label>Remaining</label>
									<input type="number" name="remaining_amount" id="remaining" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['remaining_amount'];?>">
								</div>
								
								<input type="hidden" name="custID" value="<?php echo $customerID; ?>">
								<input type="hidden" name="invID" value="<?php echo $saleHeadID; ?>">	
							</div>
							<div class="col-md-12">
							<div class="form-group">
									<label>Status</label>
									<?php $status = $updateinvoiceData[0]['status'];?>
									<input type="text" name="status" id="status" class="form-control" readonly="" value="<?=$status?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<a href="./sale-invoice-view?customer_id=<?php echo $customerID; ?>" class="btn btn-danger" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
							</div>
							<div class="col-md-3">
								<button type="submit" name="update_invoice" id="update" class="btn btn-success" style="display: none;width: 100%;"><i class="glyphicon glyphicon-open"></i> Update Invoice</button>								
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
 	function datechange(){
 		$('#update').show();
 	}
	function discEmpty(){
		if(document.getElementById('percentage').checked)
              {
              	$('#disc').val("");
              	$('#disc').focus();
              }
              else if(document.getElementById('amount').checked)
            {
            	$('#disc').val("");
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

 	function cal_remaining(){
 		
      	var paid = $('#paid_amount').val();
      	var nt = $('#nt').val();
      	var remaining = nt - paid;
      	$('#remaining').val(remaining); 
      	if (remaining == 0) {
      		$('#status').val('paid');
      	}
      	else if (remaining < paid) {
      		$('#status').val('Partially');
      	}
      	else if (remaining == nt) {
      		$('#status').val('Unpaid');
      	}
      	$('#update').show();

      	if(remaining < 0){
      		$('#update').hide();
      	}
      }
      
 </script>