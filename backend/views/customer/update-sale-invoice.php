<?php 
use common\models\Customer; 
use common\models\Branches;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Products;
use common\models\CustomerVehicles;
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
?>
<?php 
	if (isset($_GET['saleinvheadID']) && isset($_GET['customerid']))	 {
	$saleinvHeadID = $_GET['saleinvheadID'];
	$customerid = $_GET['customerid'];
	//$regNoID = $_GET['regno'];
	} else {
		$saleinvHeadID = $_GET['sihID'];
		$customerid = $_GET['customerid'];
	}

	$updateinvoiceData = Yii::$app->db->createCommand("
	    SELECT *
	    FROM sale_invoice_head
	    WHERE sale_inv_head_id = '$saleinvHeadID'
	    ")->queryAll();
	$statusCheck = $updateinvoiceData[0]['status'];
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

	$customer_vehicle = Yii::$app->db->createCommand("
    SELECT *
    FROM customer_vehicles 
    WHERE customer_id = '$customerid'
    ")->queryAll();

    $updateinvoiceDetail = Yii::$app->db->createCommand("
	    SELECT *
	    FROM sale_invoice_detail
	    WHERE sale_inv_head_id = '$saleinvHeadID'
	    ")->queryAll();
    $countSaleInvDetail = count($updateinvoiceDetail);

	//echo $countSaleInvAmount;

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
					<a href="./add-items?saleinvheadID=<?php echo $saleinvHeadID;?>&customerid=<?php echo $customerid;?>" title="Add" class="btn btn-success btn-block" style="padding: 10px"><i class="fa fa-edit"></i> Add More Items</a>
					<div class="box box-warning" style="margin-top: 10px;">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-2">
								<label>Invoice no.</label>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="saleinvHeadID" id="saleinvHeadID" class="form-control" value="<?php echo $saleinvHeadID;?>" onchange="datechange()" readonly>
								</div>
							</div>
							<div class="col-md-2">
								<label>Date:</label>
							</div>
							<div class="col-md-4" style="float: right;">
								<div class="form-group">
									<?php $date = date('Y-m-d',strtotime($updateinvoiceData[0]['date']));?>
									<input type="date" name="inv_date" id="date" class="form-control" value="<?php echo $date;?>" onchange="datechange()">
								</div>
							</div>
						</div>
						<div class="box-header">
							<h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#367FA9;">Update (<b><?php echo $customerData[0]['customer_name']; ?></b>) <?php if ($statusCheck == "Paid"){
						    	echo 'Paid';
							    }else {
							    	echo "Credit";
							    } ?> Invoice</h3>
			                <div class="row">
			                  	<div class="col-md-12">
			                    	<div class="container-fluid" style="margin-bottom:8px;">
			                      		<div class="row" style="margin-top: 25px" id="remove_index">
			                        		<div class="col-md-1"></div>
			                        		<div class="col-md-4">
			                          			<input type="hidden" id="remove_value">
			                          			<input type="text" placeholder="" class="form-control" id="removed_value" readonly="">
			                          			<input type="hidden" id="hide_quantity" class="form-control">
			                        		</div>
			                        		<div class="col-md-4" style="display: none" id="check_quantity">
			                          			<input type="text" id="check_no" class="form-control" placeholder="Quantity To Remove" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
			                          			<input type="hidden" id="check_no_quantity" >
			                        		</div>
			                        		<div class="col-md-2">
			                          			<button type="button" class="btn btn-warning btn-flat" id="remove_btn" ><i class="fa fa-times"></i> Remove</button>
			                        		</div>
			                      		</div><br>
				                    	<div class="row" id="mydata">
				                        	<div class="col-md-12">
				                          		<table class="table table-bordered" id="myTableData">
						                            <thead>
						                              	<th style="background-color: skyblue">Sr # </th>
						                              	<th style="background-color: skyblue">Vehicle </th>
						                              	<th style="background-color: skyblue">Item</th>
						                              	<th style="background-color: skyblue">Type</th>
						                              	<th style="background-color: skyblue">Quantity</th>
						                              	<th style="background-color: skyblue">Amount</th>
						                              <!-- <th style="background-color: skyblue">Action</th> -->
						                            </thead>
						                            <tbody>
						                            	<?php foreach ($updateinvoiceDetail as $key => $value) {

						                            		$cust_vehicle_id = $value['customer_vehicle_id'];
						                            		$regNo = Yii::$app->db->createCommand("
															    SELECT registration_no
																    FROM customer_vehicles
																    WHERE customer_vehicle_id  = '$cust_vehicle_id' AND customer_id = '$customerid'
																    ")->queryAll();

						                            		$itemType = $value['item_type'];

						                            		$item = $value['item_id'];

						                            		if($itemType == 'Stock'){
						                            			$itemName = Yii::$app->db->createCommand("
															    SELECT p.product_name as item 
																    FROM products as p
																    INNER JOIN stock as s
																    ON s.name = p.product_id
																    WHERE s.stock_id   = '$item'
																    ")->queryAll();
						                            		} else {
						                            			$itemName = Yii::$app->db->createCommand("
															    SELECT s.service_name as item
																    FROM services as s
																    INNER JOIN service_details as sd ON s.service_id = sd.service_id 
																    WHERE sd.service_detail_id = '$item'
																    ")->queryAll();
						                            		}
						                            		//var_dump($item);
						                            		//echo "<br><br>";
						                            		//var_dump($itemName);
						                            		$quantity = Yii::$app->db->createCommand("
															    SELECT COUNT(sale_inv_head_id)
																    FROM sale_invoice_detail
																    WHERE sale_inv_head_id   = '$saleinvHeadID' AND customer_vehicle_id = '$cust_vehicle_id' AND item_id = '$item' AND item_type = '$itemType'
																    ")->queryAll();
						                            		
						                            		$amount = $value['discount_per_service'];
						                            		?>
															<tr id="tr_<?php echo $key; ?>" onclick="removeItem(<?php echo $key; ?>)">
																<td>
																	<?php echo $key+1; ?>	
																</td>
																<td>
																	<?php echo $regNo[0]['registration_no']; ?>
																	<input type="hidden" id="sid_id_<?php echo $key; ?>" value="<?php echo $value['sale_inv_ser_detail_id']; ?>">
																</td>
																<td>
																	<input type="hidden" id="item_id_<?php echo $key; ?>" value="<?php echo $value['item_id']; ?>">
																	<input type="hidden" id="item_name_<?php echo $key; ?>" value="<?php echo $itemName[0]['item']; ?>">
																	<?php echo $itemName[0]['item']; ?>
																</td>
																<td>
																	<?php echo $itemType; ?></td>
																<td>
																	<?php 
																if($itemType == 'Service'){ ?>
																	<input type="hidden" id="item_qty_<?php echo $key; ?>" value="1">
																	<?php
																	echo 1;
																} else { ?>
																	<input type="hidden" id="item_qty_<?php echo $key; ?>" value="<?php echo $quantity[0]['COUNT(sale_inv_head_id)']; ?>">
																	<?php
																	echo $quantity[0]['COUNT(sale_inv_head_id)'];
																}
																?>
																	
																</td>
																<td>
																	<input type="hidden" id="item_amount_<?php echo $key; ?>" value="<?php echo $amount; ?>">
																	<?php echo $amount; ?>
																</td>
															</tr>
						                            	<?php } ?>
						                            </tbody>
				                          		</table>
				                        	</div>
				                      	</div>
				                      	<input type="hidden" name="itemIdArray[]" id="itemIdArray">
				                      	<input type="hidden" name="qtyArray[]" id="qtyArray">
				                      	<input type="hidden" nae="amountArray[]" id="amountArray">
				                      	<input type="hidden" name="serviceDetailIdArray[]" id="serviceDetailIdArray">

				                      	<input type="hidden" id="trId">
				                      	<input type="hidden" id="productName">
				                      	<input type="hidden" id="saleInvId">
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
												<input type="hidden" name="ttl_amt" id="ttl_amt" value="<?php echo $updateinvoiceData[0]['total_amount'];?>">
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
												  <input type="radio" name="discountType" id="percentage" onclick="discEmpty()">Percent
												<input type="text" name="discount" oninput="discountFun()" class="form-control" id="disc" value="<?php echo $updateinvoiceData[0]['discount'];?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
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
												<input type="number" name="paid_amount" id="paid_amount" class="form-control" value="<?php echo $updateinvoiceData[0]['paid_amount'];?>" readonly="">
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
											<input type="hidden" name="custID" value="<?php echo $customerid; ?>">
											<input type="hidden" name="invID" value="<?php echo $saleinvHeadID; ?>"
											>
											<input type="hidden" name="update_discount" id="update_disc" value="<?php echo $updateinvoiceData[0]['discount'];?>">
										</td>
									</tr>
									<tr>
										<td style="line-height:2.8;">
											<label>Cash Return</label>
										</td>
										<td>
											<div class="form-group">
												<input type="number" name="cash_return" id="cash_return" class="form-control" value="<?php echo $updateinvoiceData[0]['cash_return'];?>" readonly="">
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
									<?php $status = $updateinvoiceData[0]['status'];?>
									<input type="hidden" name="status" id="status" class="form-control" readonly="" value="<?=$status?>">
								</thead>
							</table>
							<div class="row">
								<div class="col-md-12">
									<h3 style="color:#000000;margin-bottom:5px;margin-top:6px;text-align: center;background-color:lightgray;padding:5px;">Transaction Details</h3>
									<?php 
									for ($amount=0; $amount <$countSaleInvAmount ; $amount++) { 
										$transDate = date('Y-m-d',strtotime($saleInvoiceAmount[$amount]['transaction_date']));
										$paidAmount = $saleInvoiceAmount[$amount]['paid_amount'];
										$sIAD = $saleInvoiceAmount[0]['s_inv_amount_detail'];

										$transactionData = Yii::$app->db->createCommand("
										    SELECT *
										    FROM transactions
										    WHERE head_id = '$saleinvHeadID'
										    AND ref_no = '$sIAD'
										    AND ref_name = 'Sale'
										    ")->queryAll();
										$transid = $transactionData[0]['transaction_id'];

									?>
									<div class="row" style="padding:0px;">
										<div class="col-md-8">
											<div class="form-group">
												<label>Transaction Date</label>
												<input type="date" name="transaction_date[]"class="form-control" value="<?php echo $transDate;?>" style="background-color:#D2D6DE;">

												<input type="text" style="display: none !Important;" name="transaction_id[]" value="<?= $transid;?>">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Paid</label>
												<input type="text" name="detail_paid_amount[]" class="form-control" value="<?php echo $paidAmount;?>" oninput="cal_paid_amount(<?php echo $amount; ?>, <?php echo $countSaleInvAmount; ?>)" id="d_p_a_<?php echo $amount; ?>">

												<input type="hidden" name="saleInvAmountID[]" value="<?php echo $saleInvoiceAmount[$amount]['s_inv_amount_detail'];?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="row">
								<?php if(isset($_GET['saleinvheadID'])){ ?>
										<div class="col-md-6">
											<a href="./sale-invoice-view" class="btn btn-danger btn-xs btn-block" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
										</div>
								<?php } else { ?>
										<div class="col-md-6">
											<a href="./customer-profile?customer_id=<?php echo $customerid; ?>" class="btn btn-danger btn-xs btn-block" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
										</div>
								<?php } ?>
								
								<div class="col-md-6">
									<button type="submit" name="update_invoice" id="update" class="btn btn-success btn-xs btn-block" disabled style="width: 100%;"><i class="glyphicon glyphicon-open"></i> Update Invoice</button>								
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

<?php 
use common\models\SaleInvoiceDetail;

if(isset($_POST['update_invoice'])){
	//sale_Inv_Head
   	$customerID              = $_POST['custID'];
   	$invID                   = $_POST['invID'];
   	//$regNoID                 = $_POST['regno'];
  	// $net_total               = $_POST['net_total'];
   	$updateDate              = $_POST['inv_date'];
   	$updateDiscount          = $_POST['update_discount'];
   	$updatetotalamount       = $_POST['total_amount'];
   	$updatenetTotal          = $_POST['net_total'];
   	$updatedpaidAmount       = $_POST['paid_amount'];
   	$updateremainingAmount   = $_POST['remaining_amount'];
   	$updatestatus            = $_POST['status'];
   	//sale_Inv_detail
   	//$itemIdArray 			= $_POST['itemIdArray'];
   	//$qtyArray 				= $_POST['qtyArray'];
   	//$amountArray 			= $_POST['amountArray'];
   	$serviceDetailIdArray 	= $_POST['serviceDetailIdArray'];
   	//sale_Inv_Amount_detail
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

      	if(!empty($serviceDetailIdArray)){
      		var_dump($serviceDetailIdArray);
      		foreach ($serviceDetailIdArray as $key => $detailId) {
      			Yii::$app->db->createCommand("DELETE FROM sale_invoice_detail WHERE sale_inv_ser_detail_id = '$detailId'")->execute();
      		}
      	}

    	$countpaidAmountArray = count($paidAmountArray);

    	$counttransid = count($transaction_update_id);

	    for($i=0; $i<$countpaidAmountArray; $i++){
	      $s_inv_amount_detail = Yii::$app->db->createCommand()->update('sale_invoice_amount_detail',[
	      //'transaction_date' => $transactionDateArray[$i],
	      'paid_amount' => $paidAmountArray[$i],
	      ],
	         ['sale_inv_head_id' => $invID , 's_inv_amount_detail' => $saleInvAmountIDArray[$i]]

	      )->execute();

	      $tran = Yii::$app->db->createCommand()->update('transactions',
	        [
	          //'transactions_date' => $transactionDateArray[$i],
	          'amount' => $paidAmountArray[$i],
	          'narration' => 'After Updation paid '.$paidAmountArray[$i].' out of total ' .$updatetotalamount,
	        ],['ref_no' => $saleInvAmountIDArray[$i], 'ref_name' => "Sale"]
	      )->execute();

	    }
     	$transaction->commit();
      	\Yii::$app->response->redirect(["./sale-invoice-view?customer_id=$customerID"]);  
    } catch (Exception $e) {
     	echo $e;
        $transaction->rollback();
    } 
}

 ?>
 <script>

	let itemArray = new Array();
  	let quantityArray = new Array();
	let amountArray = new Array();
	let saleInvDetailArray = new Array();
	let rIndex;
	let table;
	let index = 1;

 	function datechange(){
 		$('#alert').css("display","none");
      	$("#update").removeAttr("disabled");
 	}

	function discEmpty(){
		if(document.getElementById('percentage').checked){
          	$('#disc').val("");
          	$('#paid_amount').val("");
          	$('#disc').focus();
        } else if(document.getElementById('amount').checked) {
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
        disco = document.getElementById("disc").value;
    	if (disco =="" || disco == null) {
		    $('#nt').val(originalPrice);
		    //$('#remaining').val(originalPrice);
		    // $('#paid').val("0");
		    // $('#cash_return').val("0"); 
    	}else{ 
	        if(document.getElementById('percentage').checked){
	              	
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
	        } 
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
      	 
      	if (remaining == 0) {
      		$('#status').val('Paid');
      	}

      	 if (remaining == nt && paid == 0) {
      		$('#status').val('Unpaid');
      	}        
         if (paid > 0 && remaining > 0) {
          $('#status').val('Partially');
        }
        
      	//$('#insert').show();
        //$("#insert").removeAttr("disabled");
        if (remaining < 0) {
          //$('#insert').hide();
          $("#cash_return").attr("readonly", false);
         // $("#cash_return").removeAttr("readonly");
          // $('#alert').css("display","block");
          // $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
          var cash_return = paid - nt;
           $('#cash_return').val(cash_return);
           $('#remaining').val(0);
           $('#status').val('Paid');
        }else{
          $('#remaining').val(remaining);
          $('#cash_return').val(0);
          // $('#alert').css("display","none");
          // $("#insert").removeAttr("disabled");
        }
        $("#update").removeAttr("disabled");
        // if(remaining < 0){
        //   $("#insert").attr("disabled", true);
        //   $('#alert').css("display","block");
        //   $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
        // }
    }

 	// function cal_remaining(){ 		
  //     	var paid = $('#paid_amount').val();
  //     	//alert(paid);
  //     	 var nt = $('#nt').val();
  //     	 var remaining = nt - paid;
  //     	$('#remaining').val(remaining); 
  //     	if (remaining == 0) {
  //     		$('#status').val('Paid');
  //     	}
  //     	else if (remaining == nt && paid <= 0) {
  //     		$('#status').val('Unpaid');
  //     	}        
  //       else if (paid > 0) {
  //         	$('#status').val('Partially');
  //       }
  //     	//$('#update').show();
  //     	$('#alert').css("display","none");
  //     	$("#update").removeAttr("disabled");

  //     	if(remaining < 0){
  //     		//$('#update').hide();
  //     		//$("#update").attr("disabled", true);
  //     		$('#alert').css("display","block");
  //           $('#alert').html("&ensp;Please Enter A Valid Amount");
  //     	}
  //     	var eremaining = $('#remaining').val();
  //     	if(eremaining == '' || eremaining == null){
  //     		//$('#update').hide();
  //     		//$("#update").attr("disabled", true);
  //     	}
  //   }

    function removeItem(i){
    	var item_id = $('#item_id_'+i).val();
    	var item_name = $('#item_name_'+i).val();
    	var item_qty = $('#item_qty_'+i).val();
    	var item_amount = $('#item_amount_'+i).val();
    	var sid_id = $('#sid_id_'+i).val();

  		$("#remove_value").val(i);
  		$("#removed_value").val(item_name);
  		$("#check_no_quantity").val(item_qty);
  		$("#remove_amount").val(item_amount);
  		$("#trId").val(i);
  		$('#check_no').val("");
  		var q = item_qty;
  		$("#hide_quantity").val(q); 
  		//alert(saleInvDetailArray);

  		if(q>1){
    		$('#check_quantity').show();
    		$('#check_no').focus();
  		}
  		else{
      		$('#check_quantity').hide();
  		}
    }

    function deleteRow(tableID) {
        try {
            var table = document.getElementById('myTableData');
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox&& true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }
        }catch(e) {
            alert(e);
        }
    }
 </script>

 <?php
$url = \yii\helpers\Url::to("customer/fetch-info");
$script = <<< JS

$('#remove_btn').click(function(){
	var remove_value1= $('#remove_value').val();
  	var no_quantity = parseInt($('#hide_quantity').val());
  	var check_quantity = Number($('check_no').val());
	var remain_number = no_quantity - check_quantity;
	var trId = $("#trId").val();
	$("#tr_"+trId).css("display", "none");


	var item_id = $('#item_id_'+trId).val();
	var item_qty = $('#item_qty_'+trId).val();
	var item_amount = $('#item_amount_'+trId).val();
	var sid_id = $('#sid_id_'+trId).val();

	if(remove_value1 =="" || remove_value1==null){
		alert("Please Select the Service/Item to remove");
  	} else{ 

  		itemArray.push(item_id);
  		quantityArray.push(item_qty);
  		amountArray.push(item_amount);
  		saleInvDetailArray.push(sid_id);

    	var qty = $("#hide_quantity").val();
    	var nt=$('#ttl_amt').val();
    	var remove_value = $('#remove_value').val();
    	var countamount=0;
    	var total=0;
    	for(var i=0; i<amountArray.length; i++){
    		var amt = parseInt(amountArray[i]);
    		countamount = parseInt(countamount)+parseInt(amt);
    		var total = nt - countamount;
    	}

      	$('#tp').val(total);

        //$("#paid_amount").removeAttr("readonly");
        //$("#cash_return").removeAttr("readonly");
      	discountFun();


      	$('#itemIdArray').val(itemArray);
      	$('#qtyArray').val(quantityArray);
      	$('#amountArray').val(amountArray);
      	$('#serviceDetailIdArray').val(saleInvDetailArray);
  	}
  //$('#removed_value').hide();
  //$('#remove_btn').hide();
  $('#check_quantity').hide();
  $('#check_no').val("");
});

JS;
$this->registerJs($script);
?>

