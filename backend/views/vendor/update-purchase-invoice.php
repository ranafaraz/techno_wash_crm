<?php 

//if (isset($_GET['piID']) && isset($_GET['vendorID'])) {
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
	// getting stock type
  $stockType = Yii::$app->db->createCommand("
    SELECT *
    FROM stock_type
    ")->queryAll();
  $countStockType = count($stockType);

   $id=Yii::$app->user->identity->id;
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
						<div class="row">
							<div class="col-md-4"  style="float: right;">
								<div class="form-group">
									<?php $date = date('Y-m-d',strtotime($updateinvoiceData[0]['purchase_date']));?>
									<input type="date" name="purchase_date" id="purchase_date" class="form-control" value="<?php echo $date;?>" onchange="inputchange()">
									<input type="hidden" name="update_discount" id="update_disc" value="<?php echo $updateinvoiceData[0]['discount'];?>">
									<input type="hidden" name="piID" value="<?php echo $purchaseInvID; ?>">
									<input type="hidden" name="vendorID" value="<?php echo $vendorID; ?>">
								</div>
							</div>
							<div class="col-md-2" style="margin-top: 8px;float: right;">
				              <label>Date</label>
				            </div>
				            <div class="col-md-4"  style="float: right;">
								<div class="form-group">						
									<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||  event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="bilty_no" class="form-control"name="bill_no" id="bill_no" class="form-control" value="<?=$updateinvoiceData[0]['bill_no']?>" oninput="inputchange()">
								</div>
							</div>
							<div class="col-md-2" style="margin-top: 8px;float: right;">
				              <label>Bill No:</label>
				            </div>
						</div>
						<h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#367FA9;">Update Vendor (<b><?php echo $vendorData[0]['name']; ?></b>) <?php if ($statusCheck == "Paid"){
					    	echo 'Paid';
					    }else {
					    	echo "Credit";
					    } ?> Invoice</h3>
					    <div class="row" style="padding:16px;">
					    	<div class="col-md-12" style="border-top:2px solid #D2D6DE;">
					    		
					    	</div>
					    </div>
					    <div class="row">
  			            	<div class="col-md-3">
  			            		<div class="form-group">
  				            		<label>Select Stock Type</label>
  				            		<select class="form-control" id="stock_type">
  				            			<option value="">Select Stock Type</option>
  				            			<?php 
  				            			for ($i=0; $i <$countStockType ; $i++) {
  				            			?>
  				            			<option value="<?php echo $stockType[$i]['stock_type_id']; ?>"><?php echo $stockType[$i]['name'];  ?></option>
  				            			<?php } ?>
  				            		</select>
  			            		</div>
  			            	</div>
  			            	<div class="col-md-3">
  			            		<div class="form-group">
  				            		<label>Manufacture</label>
  				            		<select class="form-control" id="manufacture_type">
  				            			<option value="">First Select StockType</option>
  				            		</select>
  			            		</div>
  			            	</div>
  			            	<div class="col-md-3">
  			            		<div class="form-group">
  				            		<label>Product Name</label>
  				            		<select class="form-control" id="product_name">
                            			<option value="">First Select Manufacturer</option>
                          			</select>
  			            		</div>
  			            	</div>
  			            	<div class="col-md-3">
  			            		<div class="form-group">
  				            		<label>Stock Status</label>
                          			<select id="stock_status" class="form-control">
			                            <option value="Purchased">Purchased</option>
			                            <option value="Partnership">Partnership</option>
                          			</select>
  			            		</div>
  			            	</div>
  			            </div>
  			            <div class="row">
  			            	<div class="col-md-3">
  			            		<div class="form-group">
  				            		<label>Purchase Price</label>
                          			<input type="text"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="purchase_price" class="form-control">
  			            		</div>
  			            	</div>
  			            	<div class="col-md-3">
  			            		<div class="form-group">
  				            		<label>Selling Price</label>
                          			<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="selling_price" class="form-control" >
  			            		</div>
  			            	</div>
  			            	<div class="col-md-3">
  			            		<div class="form-group">
  				            		<label>Barcode</label>
  				            		<input type="text" class="form-control" id="barcode">
  			            		</div>
  			            	</div>
	                      	<div class="col-md-3">
		                        <div class="fomr-group">
		                          <label>Quantity</label>
		                          <input type="text" name="" class="form-control" id="quantity" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
		                        </div>
	                      	</div>
  			            	<input type="hidden" id="stockTypeName">
  			            	<input type="hidden" id="manufactreName">
                      		<input type="hidden" id="productName">
  			            </div>
  			            <div class="row">
			                <div class="col-md-12" >
			                  <div class="row">
			                    <div class="col-md-1"></div>      						
			                    <div class="col-md-12">
			                      <br>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="background-color: #3C8DBC;color:white;">Sr #</th>
												<th style="background-color: #3C8DBC;color:white;">ST.</th>
												<th style="background-color: #3C8DBC;color:white;">Mnu.</th>
												<th style="background-color: #3C8DBC;color:white;">Name</th>
												<th style="background-color: #3C8DBC;color:white;">Purch Price</th>
												<th style="background-color: #3C8DBC;color:white;">Sale Price</th>
			            						<th style="background-color: #3C8DBC;color:white;">Qty</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
									</div>
								</div>
			                </div>
			            </div>
  			            <div class="row">
			                <div class="col-md-12" >
			                  <div class="row" id="mydata" style="display:none;">
			                    <div class="col-md-1"></div>
			                    <div class="col-md-4">
			                       <input type="text" class="form-control" id="remove_value" style="display: none;" readonly="">
			                       <input type="text"  id="remove_value1" style="display: none;">
			                       <input type="text" id="hide_quantity" style="display: none;">
			                       <input type="text" id="get_purchase_value" style="display: none;">
			                    </div>
			                    <div class="col-md-4" style="display: none" id="quantity_no_div">
			                      <input type="text" class="form-control" id="check_no" placeholder="Enter quantity to remove" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
			                    </div>
			                    <div class="col-md-2">
			                      <button type="button" class="btn btn-danger btn-flat" id="remove" style="display: none;"> <i class="fa fa-times"></i> Remove</button>
			                    </div>      						
			                    <div class="col-md-12">
			                      <br>
									<table class="table table-bordered" id="myTableData">
										<thead>
											<tr>
												<th style="background-color: #3C8DBC;color:white;">Sr #</th>
												<th style="background-color: #3C8DBC;color:white;">ST.</th>
												<th style="background-color: #3C8DBC;color:white;">Mnu.</th>
												<th style="background-color: #3C8DBC;color:white;">Name</th>
												<!-- <th style="background-color: #3C8DBC;color:white;">Exp. Date</th> -->
												<!-- <th style="background-color: #3C8DBC;color:white;">Org. Price</th> -->
												<th style="background-color: #3C8DBC;color:white;">Purch Price</th>
												<th style="background-color: #3C8DBC;color:white;">Sale Price</th>
			            						<th style="background-color: #3C8DBC;color:white;">Qty</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
								</div>
			                </div>
			            </div>
						<div class="row">
							<div class="col-md-12">
								<div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;text-align: center;" id="alert">
	            				</div>								
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
											<input type="hidden" name="status" id="status" class="form-control" readonly="" value="<?=$updateinvoiceData[0]['status']; ?>">
											<input type="number" name="total_amount" id="total_p" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['total_amount'];?>">
										</div>
									</td>
								</tr>
								<tr id="profit_div" style="display:none;">
									<td>
						                <label>Profit</label>
									</td>
									<td>
										<div class="form-group">
						                	<input type="text" name="orgProfit" class="form-control" readonly="" id="orgProfit" value="0">
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
											<input type="text" name="net_total" id="net_t" class="form-control" readonly="" value="<?php echo $updateinvoiceData[0]['net_total'];?>">
										</div>
									</td>
								</tr>
								<tr>
									<td style="line-height:2.8;">
										<label>Paid Amount</label>
									</td>
									<td>
										<div class="form-group">
											<input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 ||  event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" name="paid_amount" id="paid" class="form-control" value="<?php echo $updateinvoiceData[0]['paid_amount'];?>" oninput="cal_remaining()" readonly="">

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
								<tr>
									<td>
										<label>Invoice Status: </label>
									</td>
									<td>
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
									</td>
								</tr>
							</thead>
						</table>
						<div class="row">
							<div class="col-md-12">
								<h3 style="color:#000000;margin-bottom:5px;margin-top:6px;text-align: center;background-color:lightgray;padding:5px;">Transaction Details</h3>
					    		<?php  
								for ($amount=0; $amount <$countPurchaseInvAmount ; $amount++) {
									$transDate = date('Y-m-d',strtotime($purchaseInvAmount[$amount]['transaction_date']));
									$paidAmount = $purchaseInvAmount[$amount]['paid_amount']; 
									$pIAD = $purchaseInvAmount[0]['p_inv_amount_detail'];

									$transactionData = Yii::$app->db->createCommand("
									    SELECT *
									    FROM transactions
									    WHERE head_id = '$purchaseInvID'
									    AND ref_no = '$pIAD'
									    AND ref_name = 'Purchase'
									    ")->queryAll();
									$transid = $transactionData[0]['transaction_id'];	
								?>
								<div class="row" style="padding:0px;">
									<div class="col-md-8">
										<div class="form-group" style="">
											<label>Transaction Date</label>
											<input type="date" name="transaction_date[]"class="form-control" value="<?php echo $transDate;?>" style="background-color:#D2D6DE;">
										</div>
										<input type="hidden" name="purchaseInvAmountID[]" value="<?php echo $purchaseInvAmount[$amount]['p_inv_amount_detail'];?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
										<input type="text" style="display: none !Important;" name="transaction_id[]" value="<?= $transid;?>">
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Paid</label>
											<input type="text" name="detail_paid_amount[]" class="form-control" value="<?php echo $paidAmount;?>" oninput="cal_paid_amount(<?php echo $amount; ?>, <?php echo $countPurchaseInvAmount; ?>)" id="d_p_a_<?php echo $amount; ?>">
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<a href="./purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>" class="btn btn-danger btn-xs btn-block" style=""><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
							</div>
							<div class="col-md-6">
								<button type="submit" name="update_invoice" id="update" class="btn btn-success btn-xs  btn-block"  style=""><i class="glyphicon glyphicon-open"></i> Update</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>

 <?php //} 
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
 	let barcodeArray   	   = new Array();
	let stockTypeArray 	   = new Array();
	let manufacturerArray  = new Array();
	let nameArray 		   = new Array();
  	let stockStatusArray   = new Array();
	let expiryDateArray    = new Array();
	let originalPriceArray = new Array();
	let purchasePriceArray = new Array();
	let sellingPriceArray  = new Array();
	let quantityArray      = new Array();
	let vendorID 		   = <?php echo $vendorID; ?>;
  	let branch_id = <?php echo Yii::$app->user->identity->branch_id; ?>;
	let user_id = <?php echo Yii::$app->user->identity->id; ?>;

 	function inputchange(){
 		$('#alert').css("display","none");
      	$("#update").removeAttr("disabled");
 	}
	function discEmpty(){
		if(document.getElementById('percentage').checked){
          	$('#disc').val("");
          	$('#paid').val("");
          	$('#disc').focus();
        }else if(document.getElementById('amount').checked){
        	$('#disc').val("");
        	$('#paid').val("");
        	$('#disc').focus();
        }
	}
	function discountFun(){
        // Getting the value from the original price
        originalPrice = parseInt(document.getElementById("total_p").value);
        // alert(originalPrice);
        //discountType  = parseInt(document.getElementById("discountType").value);
        
        if(document.getElementById('percentage').checked) {	
            discount = parseInt(document.getElementById("disc").value);
            discountReceived = parseInt((originalPrice*discount)/100);
            purchasePrice = originalPrice-discountReceived;
            $('#net_t').val(purchasePrice);
            $('#update_disc').val(discountReceived);
            //alert(purchasePrice);
        } else if(document.getElementById('amount').checked) {
            discount = parseInt(document.getElementById("disc").value);
            purchasePrice = originalPrice - discount;
            //alert(purchasePrice);
            //discountReceived = discount;
            $('#net_t').val(purchasePrice);
            $('#update_disc').val(discount); 
        } 
        cal_remaining();
    }
    function cal_paid_amount(i, count){
    	var paid=0;
      	for(var p=0; p<count; p++){
      		paid = paid+parseInt($('#d_p_a_'+p).val());
      	}
      	$('#paid').val(paid);
      	cal_remaining();
    }    
 	function cal_remaining(){
      	var paid = $('#paid').val();
      	var nt = $('#net_t').val();
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

 <?php
$url = \yii\helpers\Url::to("vendor/fetch-vendor-info");
$script = <<< JS
$("#stock_type").change(function(){
	var stockType = $('#stock_type').val();
	$.ajax({
    type:'post',
    data:{
      stockType:stockType
    },
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));

      $('#manufacture_type').empty();
      $('#manufacture_type').append("<option>"+"Select Manufacturer"+"</option>");
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['manufacture_id']+'">'+jsonResult[i]['name']+'</option>';
      }
      // Append to the html
      $('#manufacture_type').append(options);
    }      
  });
});

$("#manufacture_type").change(function(){
  var manufactureType = $('#manufacture_type').val();
  $.ajax({
    type:'post',
    data:{
      manufactureType:manufactureType
    },
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));

      $('#product_name').empty();
      $('#product_name').append("<option>"+"Select Product"+"</option>");
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['product_id']+'">'+jsonResult[i]['product_name']+'</option>';
      }
      // Append to the html
      $('#product_name').append(options);         
    }      
  });
});

$("#barcode").change(function(){
	var barcode 			= $("#barcode").val();
	var stock_type 			= $("#stock_type").val();
	var manufacture_type 	= $("#manufacture_type").val();
	var name 				= $("#product_name").val();
  	var stock_status        = $("#stock_status").val();
	var expiry_date 		= $("#expiry_date").val();
	var original_price 		= $("#original_price").val();
	var purchase_price 		= $("#purchase_price").val();
	var selling_price 		= $("#selling_price").val();
	var qty					= 1;
	var stockTypeName 		= $('#stockTypeName').val();
	var manufactreName 		= $('#manufactreName').val();
  	var product_name    	= $('#productName').val();
	var totalAmount         = parseInt($('#total_p').val());
 	 var profitOrg          = parseInt($('#orgProfit').val());
  
  if(stock_status == 'Partnership'){
    $('#profit_div').show();
    var totalProfit = parseInt(selling_price)-parseInt(purchase_price);
    var divideProfit = totalProfit/2;
    var op = parseInt(profitOrg)+divideProfit;
    var tp = parseInt(totalAmount)+parseInt(purchase_price);
    var remain = parseInt(tp)+parseInt(op);

    $('#total_p').val(tp);
    $('#orgProfit').val(op);
    $('#net_t').val(remain);
    $('#disc').val("");
    $('#paid').val("0");
    $('#remaining').val(remain);
    $('#status').val('Unpaid');
  } else {
    var tp = parseInt(totalAmount)+parseInt(purchase_price);
    var op = 0;
    var remain = parseInt(tp)+parseInt(op);

    $('#total_p').val(tp);
    $('#orgProfit').val(op);
    $('#net_t').val(remain);
    $('#disc').val("");
    $('#paid').val("0");
    $('#remaining').val(remain);
    $('#status').val('Unpaid');
  }

	if(stock_type == "" || stock_type == null)
	{
		alert('Please Select the Stock Type');
	    $('#stock_type').css("border", "1px solid red");
	    $('#stock_type').focus();
	}
	else if(manufacture_type == "" || manufacture_type == null)
	{
		alert('Please Select the Manufacture Type');
	    $('#manufacture_type').css("border", "1px solid red");
	    $('#manufacture_type').focus();
	}
	else if(name == "" || name == null)
	{
		alert('Please Select the Name');
	    $('#product_name').css("border", "1px solid red");
	    $('#product_name').focus();
	}
	else if(purchase_price == "" || purchase_price == null)
	{
		alert('Please fill the Purchase Price');
	    $('#purchase_price').css("border", "1px solid red");
	    $('#purchase_price').focus();
	}
	else if(selling_price == "" || selling_price == null)
	{
		alert('Please fill the Selling Price');
	    $('#selling_price').css("border", "1px solid red");
	    $('#selling_price').focus();
	}
  else{
    	discountFun();
		barcodeArray.push(barcode);
		stockTypeArray.push(stock_type);
		manufacturerArray.push(manufacture_type);
		nameArray.push(name);
    	stockStatusArray.push(stock_status);
		expiryDateArray.push(expiry_date);
		originalPriceArray.push(original_price);
		purchasePriceArray.push(purchase_price);
		sellingPriceArray.push(selling_price);
		quantityArray.push(qty);

		$("#mydata").show();
		$('#bill_form').show();
		//document.getElementById('insertdata').disabled=false;
		$('#insertdata').attr("disabled", false);

		let table = document.getElementById("myTableData");

		//count the table row
		let rowCount = table.rows.length;

		//insert the new row
		let row = table.insertRow(1);
		  
		//insert the coulmn against the row
		row.insertCell(0).innerHTML= rowCount;
		row.insertCell(1).innerHTML= stockTypeName;
		row.insertCell(2).innerHTML= manufactreName;
		row.insertCell(3).innerHTML= product_name;
		//row.insertCell(4).innerHTML= expiry_date;
		//row.insertCell(5).innerHTML= original_price;
		row.insertCell(4).innerHTML= purchase_price;
		row.insertCell(5).innerHTML= selling_price;
    	row.insertCell(6).innerHTML= qty;

		$('#barcode').val("");
		$('#barcode').focus();
	}
  	table = document.getElementById("myTableData");
  	for(var i = 1; i < table.rows.length; i++) {
	    table.rows[i].onclick = function(){
	      $('#remove_value').show();
	      $('#remove').show();
	       
	      // get the seected row index
	      rIndex = this.rowIndex;
	      document.getElementById("remove_value1").value = rIndex;
	      document.getElementById("remove_value").value = this.cells[3].innerHTML;
	      document.getElementById("hide_quantity").value = this.cells[6].innerHTML;
	      document.getElementById("get_purchase_value").value = this.cells[4].innerHTML;
	      $('#check_no').val("");
	      $('#check_no').focus();
	      var q = Number(document.getElementById("hide_quantity").value);
	      if(q>1){
	        $('#quantity_no_div').show();
	      } else {
	        $('#quantity_no_div').hide();
	      }
	    };
	}
});

$("#quantity").change(function(){
	var qty 				= parseInt($('#quantity').val());
	var stock_type 			= $("#stock_type").val();
	var manufacture_type 	= $("#manufacture_type").val();
	var name 				= $("#product_name").val();
  	var stock_status        = $("#stock_status").val();
	var expiry_date 		= $("#expiry_date").val();
	var original_price 		= $("#original_price").val();
	var purchase_price 		= $("#purchase_price").val();
	var selling_price 		= $("#selling_price").val();
	var stockTypeName 		= $('#stockTypeName').val();
	var manufactreName 	  = $('#manufactreName').val();
  	var product_name      = $('#productName').val();
  	var barcode			  = ''; 
  	var totalAmount       = parseInt($('#total_p').val());
  	var paid       		  = parseInt($('#paid').val());
  	var profitOrg         = parseInt($('#orgProfit').val());
  	
  if(stock_status == 'Partnership'){
    $('#profit_div').show();
    var pp = parseInt(purchase_price)*qty;
    var sp = parseInt(selling_price)*qty;
    var totalProfit = parseInt(sp)-parseInt(pp);
    var divideProfit = totalProfit/2;
    var op = parseInt(profitOrg)+divideProfit;
    var tp = parseInt(totalAmount)+pp;
    var nt = parseInt(tp)+parseInt(op);

    alert(nt);

    $('#total_p').val(tp);
    $('#orgProfit').val(op);
    $('#net_t').val(nt);
    $('#disc').val("");
    //$('#paid').val("0");
    //$('#remaining').val(nt);
    //$('#status').val('Unpaid');
  } else {
  	var pp = parseInt(purchase_price)*qty;
  	var tp = parseInt(totalAmount)+pp;
    var op = 0;
    var nt = parseInt(tp)+parseInt(op);

    alert(nt);

  	$('#total_p').val(tp);
    $('#orgProfit').val(op);
    $('#net_t').val(nt);
    $('#disc').val("");
    //$('#paid').val("0");
    //$('#remaining').val(nt);
    //$('#status').val('Unpaid');
  }
  
    discountFun();

    if(stock_type == "" || stock_type == null) {
		alert('Please Select the Stock Type');
	    $('#stock_type').css("border", "1px solid red");
	    $('#stock_type').focus();
	}
	else if(manufacture_type == "" || manufacture_type == null)
	{
		alert('Please Select the Manufacture Type');
	  	$('#manufacture_type').css("border", "1px solid red");
	  	$('#manufacture_type').focus();
	}
	else if(name == "" || name == null)
	{
		alert('Please Select the Name');
	  	$('#product_name').css("border", "1px solid red");
	  	$('#product_name').focus();
	}
	else if(purchase_price == "" || purchase_price == null)
	{
		alert('Please fill the Purchase Price');
	    $('#purchase_price').css("border", "1px solid red");
	    $('#purchase_price').focus();
	}
	else if(selling_price == "" || selling_price == null)
	{
		alert('Please fill the Selling Price');
      	$('#selling_price').css("border", "1px solid red");
      	$('#selling_price').focus();
	}
	else
	{
		barcodeArray.push(barcode);
		stockTypeArray.push(stock_type);
		manufacturerArray.push(manufacture_type);
		nameArray.push(name);
    	stockStatusArray.push(stock_status);
		expiryDateArray.push(expiry_date);
		originalPriceArray.push(original_price);
		purchasePriceArray.push(purchase_price);
		sellingPriceArray.push(selling_price);
		quantityArray.push(qty);

		$("#mydata").show();
		$('#bill_form').show();
		$('#insertdata').attr("disabled", false);

		let table = document.getElementById("myTableData");

		//count the table row
		let rowCount = table.rows.length;

		//insert the new row
		let row = table.insertRow(1);
	  
		//insert the coulmn against the row

		row.insertCell(0).innerHTML= rowCount;
		row.insertCell(1).innerHTML= stockTypeName;
		row.insertCell(2).innerHTML= manufactreName;
		row.insertCell(3).innerHTML= product_name;
		//row.insertCell(4).innerHTML= expiry_date;
		//row.insertCell(5).innerHTML= original_price;
		row.insertCell(4).innerHTML= purchase_price;
		row.insertCell(5).innerHTML= selling_price;
    	row.insertCell(6).innerHTML= qty;

		$('#quantity').val("");
		$('#quantity').focus();
	}
	table = document.getElementById("myTableData");
  	for(var i = 1; i < table.rows.length; i++)
    {
      table.rows[i].onclick = function()
      {
        $('#remove_value').show();
        $('#remove').show();
        
        // get the seected row index
        rIndex = this.rowIndex;
        document.getElementById("remove_value1").value = rIndex;
        document.getElementById("remove_value").value = this.cells[3].innerHTML;
        document.getElementById("hide_quantity").value = this.cells[6].innerHTML;
        document.getElementById("get_purchase_value").value = this.cells[4].innerHTML;
        $('#check_no').val("");
        $('#check_no').focus();
        var q = Number(document.getElementById("hide_quantity").value);
        if(q>1){
          $('#quantity_no_div').show();
        }
        else{
          $('#quantity_no_div').hide();
        }
      };
    }
});

$("#cash_return").on('input', function(){
  var cashReturn  = $('#cash_return').val();
  var paid        = $('#paid').val();
  var nt          = $('#net_t').val();
  var previous_value = paid-nt;
  var temp = cashReturn-previous_value;
  $('#remaining').val(temp);

  if(cashReturn == previous_value)
  {
    $('#status').val('Paid');
    $("#insert").attr("disabled", false);
    $('#alert').css("display","none"); 
  }
  if(temp > 0)
  {
    $('#status').val('Partially Paid');
    $("#insert").attr("disabled", false);
    $('#alert').css("display","none"); 
  }

  if(temp < 0)
  {
    $("#insert").attr("disabled", true);
    $('#alert').css("display","block");
    $('#status').val('');
    $('#alert').html("&ensp;Invalid Amount");
  }
});

$("#cash_return").on('focus', function(){
  $('#cash_return').val("");
});

$('#stock_type').change(function(){
	var stock_type = $("#stock_type").val();
	$.ajax({
	  type:'post',
      data:{
      	stock_type:stock_type
      },
      url: "$url",
      success: function(result){
      	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
      	$('#stockTypeName').val(jsonResult[0]['name']);     	
    	}      
  }); 
});

$('#manufacture_type').change(function(){
	var manufacture_type = $("#manufacture_type").val();
	$.ajax({
    type:'post',
    data:{
    	manufacture_type:manufacture_type
    },
    url: "$url",
    success: function(result){
    	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
    	$('#manufactreName').val(jsonResult[0]['name']);      	
  	}      
  }); 
});

$('#product_name').change(function(){
  var product_name = $("#product_name").val();
  $.ajax({
    type:'post',
    data:{
      product_name:product_name
    },
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
      $('#productName').val(jsonResult[0]['product_name']);            
    }      
  }); 
});

$('#remove').click(function(){
  var remove_value = $('#remove_value1').val();  
  var hide_quantity = Number(document.getElementById("hide_quantity").value);
  var check_no = Number(document.getElementById("check_no").value);
  var remain_quantity = hide_quantity-check_no;
  if(remove_value=="" || remove_value==null){
    alert("Please select the row");
  }
  else if((check_no>hide_quantity) && (hide_quantity>1)){
    alert("Enter the valid Number of Items");
  }
  else if((check_no=="" || check_no == null) && (hide_quantity>1)){
     alert("Item to be remove can not be empty");
  }
  else{
    if((hide_quantity>1) && (check_no<hide_quantity)){
      //alert(remain_quantity);
      document.getElementById("myTableData").rows[remove_value].cells[6].innerHTML = remain_quantity;
      var remove_amount = Number(document.getElementById("get_purchase_value").value);
      var nt = Number(document.getElementById("tp").value);
      var remain_amount = nt - check_no*remove_amount;
      //alert(remain_amount);
      $('#total_p').val(remain_amount);$("#total_p").val(remain_amount);
      $("#net_t").val(remain_amount);
      $("#remaining").val(remain_amount);
      // $("#disc").val("");
      // $("#paid").val("0");
      var a =quantityArray.length - remove_value;
      
      quantityArray[a] =remain_quantity;
      $('#checke_no').val("");
      $('#remove_value').val("");
      $('#remove_value1').val("");
    }
    else if(check_no == hide_quantity){
      var nt=$('#total_p').val(); 
      var a =barcodeArray.length- remove_value; 

      var remove_amount = Number(document.getElementById("get_purchase_value").value);
      document.getElementById("myTableData").deleteRow(remove_value); 
      var remove_amount = Number(document.getElementById("get_purchase_value").value);
      net_of_remove_amount = remove_amount*hide_quantity;
      nt=nt - net_of_remove_amount;
      $('#total_p').val(nt); 
      $('#net_t').val(nt); 
      $('#remaining').val(nt); 
      barcodeArray.splice(a,1);
      stockTypeArray.splice(a,1);
      manufacturerArray.splice(a,1);
      nameArray.splice(a,1);
      expiryDateArray.splice(a,1);
      originalPriceArray.splice(a,1);
      purchasePriceArray.splice(a,1);
      sellingPriceArray.splice(a,1);
      quantityArray.splice(a,1);
    }
    else{
      document.getElementById("myTableData").deleteRow(remove_value);
      var a =barcodeArray.length- remove_value;
      // alert(sellingPriceArray[a]);
      //alert(sellingPriceArray);
      var nt=$('#total_p').val();
      var nta = nt-purchasePriceArray[a];
      //alert(barcodeArray.length);
      barcodeArray.splice(a,1);
      stockTypeArray.splice(a,1);
      manufacturerArray.splice(a,1);
      nameArray.splice(a,1);
      quantityArray.splice(a,1);
      expiryDateArray.splice(a,1);
      originalPriceArray.splice(a,1);
      purchasePriceArray.splice(a,1);
      sellingPriceArray.splice(a,1);
      //alert(barcodeArray.length);
      $('#total_p').val(nta);
      $('#remaining').val(nta);
      $('#net_t').val(nta);
      $('#remove_value1').val("");
      $('#remove_value').val("");
      // alert(sellingPriceArray);
      if(barcodeArray.length==0){
        $('#bill_form').hide();
        $('#mydata').hide();
      }
    }
  }
  $('#check_no').val("");
  //$('#paid').val("0");
  $('#disc').val("");
 // $('#status').val("Unpaid");
  $('#remove_value').hide();
  $('#remove').hide();
  $('#quantity_no_div').hide();
});

JS;
$this->registerJs($script);
?>