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
									<input type="date" name="date" id="invoice_date" class="form-control" value="<?php echo $date;?>" onchange="datechange()">
								</div>
							</div>
						</div>
						<div class="box-header">
							<h3 style="text-align: center;font-family:georgia;color:#ffffff;padding:5px;margin-top:0px;margin-bottom:0px;background-color:#367FA9;">Add Item (<b><?php echo $customerData[0]['customer_name']; ?></b>) <?php if ($statusCheck == "Paid"){
						    	echo 'Paid';
							    }else {
							    	echo "Credit";
							    } ?> Invoice</h3>
							<div class="row">
								<div class="col-md-12">
									<div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;text-align: center;" id="alert">
				    				</div>								
								</div>							
							</div><br>
							<div class="form-group">
			                  <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
			                </div>
			                <div class="row">
			                  	<div class="col-md-12">
			                    	<div class="container-fluid" style="margin-bottom:8px;">
			                      		<div class="row">
					                        <div class="col-md-3">
					                          	<div class="form-group">
						                            <label>Select Vehicle</label>
						                            <select id="custVehicle" class="form-control">
						                            	<option>Select Vehicle</option>
						                            	<?php 
						                            	foreach ($customer_vehicle  as $key => $value) { ?>
						                            	 	<option value="<?php echo $value['customer_vehicle_id'] ?>"><?php echo $value['registration_no'] ?></option>
						                            	<?php } ?>
						                            </select>
					                          	</div>
					                        </div>
					                        <div class="col-md-3">
					                          	<div class="form-group" id="types">
					                            	<label>Select Type</label>
					                            	<select id="item_type" class="form-control" autofocus="">
					                              		<option value="">Select Type</option>
					                              		<option value="Service">Service</option>
					                              		<option value="Stock">Stock</option>
					                            	</select>
					                            	<input type="hidden" id="remove_amount">
					                          	</div>
					                        </div>
					                        <div class="col-md-3">
					                          	<div id="servic" style="display: none;">
					                            	<div class="form-group">
					                              		<label>Select Service</label>
				                              			<select name="services" class="form-control" id="services">
				                                			<option value="">Select Services</option>
							                                <?php 
							                                $allservices = Yii::$app->db->createCommand("
							                                SELECT *
							                                FROM services
							                                ")->queryAll();
							                                $countAll = count($allservices);
							                                  for ($s=0; $s <$countAll ; $s++) { 
							                                
							                                ?>
							                                <option value="<?php echo $allservices[$s]['service_id']; ?>"><?php echo $allservices[$s]['service_name']; ?></option>
							                                <?php } ?>
				                              			</select>
					                            	</div>
					                            	<div class="form-group">
					                              		<input type="hidden" name="amount" class="form-control" value="0" id="price" readonly="" >
					                            	</div>
					                          	</div>
					                          	<div id="stock" style="display: none;">
					                            	<div class="form-group">
					                              		<label>Barcode </label>
					                              		<input type="text" id="barcode" class="form-control">
					                            	</div>
					                            	<div class="form-group">
					                              		<input type="hidden" class="form-control" id="selling_price" readonly="" >
					                            	</div>
					                          	</div>
					                        </div>
					                        <div class="col-md-3">
					                          	<div id="pname" style="display: none;">
						                            <div class="form-group">
						                              	<label>Product Name </label>
						                              	<?php 
						                                echo Select2::widget([
						                                'name' => 'product_name',
						                                'value' => '',
						                                'data' => ArrayHelper::map(Products::find()->all(),'product_id','product_name'),
						                                'options' => ['placeholder' => 'Select Product','id' => 'productid']
							                              ]);
							                              ?>
						                            </div>
					                          	</div>
					                        </div>
			                      		</div>
				                      	<div class="row">
					                        <div class="col-md-3">
					                          	<div id="quantity" style="display: none;">
						                            <div class="form-group">
						                              	<label>Quantity</label>
						                              	<input type="text" id="product_quantity" class="form-control">
						                              	<input type="hidden" id="hide_quantity" class="form-control">
						                            </div>
					                          	</div>
					                        </div>
					                        <div class="col-md-3">
					                          	<div id="availbleStock" style="display: none;">
					                            	<div class="form-group">
					                              		<label>Available Stock</label>
					                              		<input type="text" id="availble_stock" class="form-control" readonly="">
					                            	</div>
					                          	</div>
					                        </div>
				                        	<div class="col-md-3" id="alertDiv">
				                          		<p id="message" style="display:none;">
				                          		</p>
				                        	</div>
				                      	</div>
			                      		<div class="row" style="margin-top: 25px" id="remove_index">
			                        		<div class="col-md-1"></div>
			                        		<div class="col-md-4">
			                          			<input type="hidden" id="remove_value">
			                          			<input type="text" placeholder="" class="form-control" id="removed_value" readonly="" style="display:none;">
			                        		</div>
			                        		<div class="col-md-4" style="display: none" id="check_quantity">
			                          			<input type="text" id="check_no" class="form-control" placeholder="Quantity To Remove" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
			                          			<input type="hidden" id="check_no_quantity" >
			                        		</div>
			                        		<div class="col-md-2">
			                          			<button type="button" class="btn btn-warning btn-flat" id="remove" style="display:none;"><i class="fa fa-times"></i> Remove</button>
			                        		</div>
			                      		</div><br>
				                    	<div class="row" id="mydata" style="display: none;">
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
						                            </tbody>
				                          		</table>
				                        	</div>
				                      	</div>
				                      	<input type="hidden" id="service_name">
				                      	<input type="hidden" id="stock_name">
				                      	<input type="hidden" id="vehicle_name">
				                      	<input type="hidden" id="serviceDetailId">
				                      	<input type="hidden" id="productSellingPrice">
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
												<input type="number" name="cash_return" id="cash_return" class="form-control" value="<?php echo $updateinvoiceData[0]['cash_return'];?>">
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
								<div class="col-md-6">
									<a href="./update-sale-invoice?saleinvheadID=<?php echo $saleinvHeadID; ?>&customerid=<?php echo $customerid; ?>" class="btn btn-danger btn-xs btn-block" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>						
								</div>
								
								<div class="col-md-6">
									<button id="update" class="btn btn-success btn-xs btn-block" disabled style="width: 100%;"><i class="glyphicon glyphicon-open"></i> Update Invoice</button>								
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

<?php  $id =  Yii::$app->user->identity->id; ?>
 <script>

 	let vehicleArray = new Array();
	let serviceArray = new Array();
	let amountArray = new Array();
	let ItemTypeArray = new Array();
  	let quantityArray = new Array();
  	let tempProductArray = new Array();
  	let tempquantityArray = new Array();
	let user_id = <?php echo $id; ?>;
  	let branch_id = <?php echo Yii::$app->user->identity->branch_id; ?>;
	let rIndex;
	let table;
	let index = 1;
	var invoice_id 	= <?php echo $saleinvHeadID; ?>;
	var customer_id 	= <?php echo $customerid; ?>;


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
      	if(eremaining == '' || eremaining == null){
      		//$('#update').hide();
      		$("#update").attr("disabled", true);
      	}
    }
 </script>

 <?php
$url = \yii\helpers\Url::to("customer/fetch-info");

$script = <<< JS

$(document).ready(function(){
  $('#types').show();
});

$("#custVehicle").on('focus', function(){
  $('#item_type').val("");
  $('#servic').hide();
  $('#stock').hide();
  $('#pname').hide();
  $('#quantity').hide();
});

$("#custVehicle").on("change",function(){
	var vehicle = $("#custVehicle").val();
  	if(vehicle == null || vehicle ==""){  
	    $('#types').hide();
	    $('#servic').hide();
	    $('#stock').hide();
	    $('#pname').hide();
	    $('#quantity').hide();
  	} else{
	    $('#types').val("");
	    $('#types').show();
  	}

	$.ajax({
	    type:'post',
	    data:{vehicle:vehicle},
	    url: "$url",
	    success: function(result){
	    	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	    	$('#vehicle_name').val(jsonResult[0]['registration_no']);
	  	}      
  	}); 

  	$.ajax({
	    type:'post',
	    data:{vehicle_id:vehicle},
	    url: "$url",
	    success: function(result){
	      	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	      	console.log(jsonResult);
	      	var vdetail = jsonResult[0]['vehicle_typ_sub_id'];
	      	var carmanu = jsonResult[0]['car_manufacture_id'];
	      	var vehtyp = jsonResult[0]['vehical_type_id'];
	      	var custVehid = jsonResult[0]['customer_vehicle_id'];

	      	$("#message").show();
	      	$("#message").html("<a href='./update-vehicle-type?vdetail="+vdetail+"&carmanu="+carmanu+"&vehtyp="+vehtyp+"&custVehid="+custVehid+"' style='color:white;'>Car Data Incorrect,Please Click on Update</a>");
	      	$("#message").css(
	        {
	            //"color":"#008D4C",
	            "border":"1px solid",
	            "background-color":"#008D4C",
	        });
	    }      
  	}); 
});

$("#item_type").change(function(){
  	$('#servic').val("SelectServices");
  	$('#selling_price').val("");
  	$('#price').val("");

	var item_type = $('#item_type').val();
	if(item_type == "Service"){
	 	$('#servic').show();
    	$('#services').focus();
	 	$('#stock').hide();
    	$('#pname').hide();
    	$('#quantity').hide();
    	$('#availbleStock').hide();
    	$('#message').hide();
	} else if(item_type == "Stock") {
	 	$('#stock').show();
	    $('#pname').show();
	    $('#barcode').focus();
	    $('#barcode').val("");
	    $('#servic').hide();
	    $('#productid').val('').trigger("change");
	} else{
	 	$('#stock').hide();
	 	$('#servic').hide();
    	$('#pname').hide();
	}
});

$("#services").on('change',function(){
	var serviceID = $("#services").val();
  	$('#product_quantity').val("");
  	var customerVehicle = $("#custVehicle").val();
	
	$.ajax({
    	type:'post',
	    data:{
	        serviceID:serviceID,
	        customerVehicle:customerVehicle
	    },
    	url: "$url",
    	success: function(result){
        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
        	
          	$('#price').val(jsonResult[0]['price']);
          	$('#serviceDetailId').val(jsonResult[0]['service_detail_id']);
          	$('#service_name').val(jsonResult[0]['service_name']);

          	var totalAmount = parseInt($('#tp').val());
			var tprice = jsonResult[0]['price'];
			var tp = parseInt(totalAmount)+parseInt(tprice);
          	$('#tp').val(tp);
          	$('#disc').val("");
          	discountFun();

			var vehicle = $('#custVehicle').val();
			var services = $('#serviceDetailId').val();
			var price = $('#price').val();
			var servicesName = $('#service_name').val();
			var reg_name = $('#vehicle_name').val();
			var type = $('#item_type').val();
          	var quantity = 1;
					
			if (vehicle=="" || vehicle==null) {
				alert("Select the Vehicle name ");
			} else if (services =="" || services==null) {
						//alert("Select the Services ");
			} else {
				vehicleArray.push(vehicle);
				serviceArray.push(services);
				amountArray.push(price);
				ItemTypeArray.push(type);
            	quantityArray.push(quantity);

				$("#mydata").show();
				$('#bill_form').show();
				$('#insertdata').attr("disabled", false);
				let table = document.getElementById("myTableData");

				//count the table row
				let rowCount = table.rows.length;
				
				//insert the new row
				let row = table.insertRow(1);
				
				//insert the coulmn against the row
				row.insertCell(0).innerHTML=rowCount;
            	row.insertCell(1).innerHTML=reg_name;
				row.insertCell(2).innerHTML= servicesName;
				row.insertCell(3).innerHTML= type;
            	row.insertCell(4).innerHTML= quantity;
				row.insertCell(5).innerHTML= price;
            	//row.insertCell(6).innerHTML= "<button class='btn btn-danger' onclick='remove(this)'>Remove</button>";
						
           		$('#services').val("");
				$('#remove_index').show();
				for(var i = 1; i < table.rows.length; i++){
              		table.rows[i].onclick = function() {
                		$('#removed_value').show();
                		$('#remove').show();
                		// get the seected row index
		                rIndex = this.rowIndex;
		                document.getElementById("remove_value").value = rIndex;
		                document.getElementById("removed_value").value = this.cells[2].innerHTML;
		                document.getElementById("check_no").value = this.cells[4].innerHTML;
		                document.getElementById("check_no_quantity").value = this.cells[4].innerHTML;
		                document.getElementById("remove_amount").value = this.cells[5].innerHTML;
		                $('#check_no').val("");
		                var q = this.cells[4].innerHTML;

		                $("#hide_quantity").val(q); 
		                if(q>1){
		                  $('#check_quantity').show();
		                  $('#check_no').focus();
		                } else{
		                    $('#check_quantity').hide();
		                }        
              		};
            	}
          	}
  		}   
	}); 
});

$("#pname").focusin(function(){
  $('#quantity').show();
  $('#availbleStock').show();
  $('#availbleStock').val("");
  $('#barcode').val("");
});

$('#productid').on("change",function(){
  	var PRODUCTid = parseInt($('#productid').val());

  	$.ajax({
      	type:'post',
      	data:{PRODUCTid:PRODUCTid},
      	url: "$url",
      	success: function(result){
	        var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        var count = jsonResult.length;
	        if(count > 0){
	          $("#availble_stock").val(count);
	          $("#message").removeAttr("Style");
	          $("#message").html("Stock available");
	          $("#message").css({
	            "color":"#008D4C",
	            "text-align":"left",
	            "margin-top":"25px",
	          });
	        } else if(count == 0) {
	            $("#availble_stock").val(count);
	            $("#message").html("Stock is not available");
	            $("#message").css({
	              "color":"red",
	              "text-align":"left",
	              "margin-top":"25px",
	            });
	        } 
      	}      
  	});
});

$('#product_quantity').on("change",function(){
  	var productID  = parseInt($("#productid").val());
  	var pro_quantity=parseInt($("#product_quantity").val());
  	var avastock = $("#availble_stock").val();
  	// var remainStock = avastock - pro_quantity;
  	// $("#availble_stock").val(remainStock);
  	if(pro_quantity =="" || pro_quantity == null){
  	} else if(pro_quantity > avastock ) {
	    alert("Enter the valid Number of quantities");
	    $("#product_quantity").css("border", "1px solid red");
	    $("#product_quantity").val("");
	    //$("#message").html("not a valid stock");
  	} else{
    	$("#product_quantity").css("border", "");
    	$("#product_quantity").val("");
    	$.ajax({
      		type:'post',
      		data:{productID:productID},
      		url: "$url",
      		success: function(result){
		        var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
		        $('#productName').val(jsonResult[0]['product_name']);
		        $("#productSellingPrice").val(jsonResult[0]['selling_price']);

		        var totalAmount = parseInt($('#tp').val());
		        var tprice = jsonResult[0]['selling_price'];
		        var totalPrice = tprice*pro_quantity;
		        var totalprices = parseInt(totalAmount)+parseInt(totalPrice);
		        $('#tp').val(totalprices);
		        $('#nt').val(totalprices);
		        $('#remaining').val(totalprices);
		        $('#disc').val("");
		        discountFun();

		        var vehicle             = $('#custVehicle').val();
		        var productid           = parseInt($("#productid").val());
		        var stock_price         = $("#productSellingPrice").val();
		        var servicesName        = $('#productName').val();
		        var reg_name            = $('#vehicle_name').val();
		        var type                = "Product";
		        var quantity            = pro_quantity;

		        if (vehicle=="" || vehicle==null) {
		          	alert("Select the Vehicle name ");
		        } else if (services=="" || services==null) {
		          	alert("Select the Services ");
		        } else {
		            vehicleArray.push(vehicle);
			        serviceArray.push(productid);
			        amountArray.push(stock_price);
			        ItemTypeArray.push(type);
			        quantityArray.push(quantity);

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
			        row.insertCell(1).innerHTML= reg_name;
			        row.insertCell(2).innerHTML= servicesName;
			        row.insertCell(3).innerHTML= type;
			        row.insertCell(4).innerHTML= pro_quantity;
			        row.insertCell(5).innerHTML= stock_price;

			        $("#product_quantity").val("");
			        $("#product_quantity").focus("");
			        $('#remove_index').show();

		          	for(var i = 1; i < table.rows.length; i++) {
		            	table.rows[i].onclick = function(){
		              		$('#removed_value').show();
		              		$('#check_quantity').show();
		              		$('#remove').show();
		              		// get the seected row index
		              		rIndex = this.rowIndex;
		              		document.getElementById("remove_value").value = rIndex;
		              		document.getElementById("removed_value").value = this.cells[2].innerHTML;
		              		document.getElementById("check_no_quantity").value = this.cells[4].innerHTML;
		              		document.getElementById("remove_amount").value = this.cells[5].innerHTML;
		              		$('#check_no').val("");
		              		var q = this.cells[4].innerHTML;
		              		$("#hide_quantity").val(q); 
		              		if(q>1){
		                		$('#check_quantity').show();
		                		$('#check_no').focus();
		              		}
		              		else{
		                  		$('#check_quantity').hide();
		              		}         
		            	};
		          	}
		        }     
      		}      
    	});
  	}
});

$("#barcode").focusin(function(){
  $('#quantity').hide();
  $('#availbleStock').hide();
  $('#availble_stock').val("");
  $('#message').hide();
  $('#productid').val('').trigger("change");  
});

$("#barcode").on('change',function(){
	var barcode = $("#barcode").val();
  	if(barcode=="" || barcode==null){

  	} else{
		$.ajax({
	        type:'post',
	        data:{barcode:barcode},
	        url: "$url",
	      	success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
        	  	$('#selling_price').val(jsonResult[0]['selling_price']);
	        	$('#stock_name').val(jsonResult[0]['product_name']);
                     
	        	var totalAmount = parseInt($('#tp').val());
				    var tprice = jsonResult[0]['selling_price'];
				    var tp = parseInt(totalAmount)+parseInt(tprice);
            	$('#tp').val(tp);
            	//$('#nt').val(tp);
				    //$('#remaining').val(tp);
            	//$('#status').val('Unpaid');
            	$('#disc').val("");
            	discountFun();

				var vehicle = $('#custVehicle').val();
				var barcode = jsonResult[0]['stock_id'];
				var stock_price = $('#selling_price').val();
				var servicesName = $('#stock_name').val();
				var reg_name = $('#vehicle_name').val();
				var type = $('#item_type').val();
            	var quantity = 1;

				if (vehicle=="" || vehicle==null) {
					alert("Select the Vehicle name ");
				} else if (services=="" || services==null) {
					alert("Select the Services ");
				} else {
  					vehicleArray.push(vehicle);
  					serviceArray.push(barcode);
  					amountArray.push(stock_price);
  					ItemTypeArray.push(type);
              		quantityArray.push(quantity);

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
  					row.insertCell(1).innerHTML= reg_name;
  					row.insertCell(2).innerHTML= servicesName;
  					row.insertCell(3).innerHTML= type;
              		row.insertCell(4).innerHTML= quantity;
  					row.insertCell(5).innerHTML= stock_price;

  					$('#barcode').val("");
  					$('#barcode').focus();
  					$('#remove_index').show();

              		for(var i = 1; i < table.rows.length; i++) {
			          	table.rows[i].onclick = function() {
                  			$('#removed_value').show();
                  			$('#remove').show();
                   			// get the seected row index
                  			rIndex = this.rowIndex;
                  			document.getElementById("remove_value").value = rIndex;
                  			document.getElementById("removed_value").value = this.cells[2].innerHTML;
                  			document.getElementById("check_no").value = this.cells[4].innerHTML;
                  			document.getElementById("check_no_quantity").value = this.cells[4].innerHTML;
                  			document.getElementById("remove_amount").value = this.cells[5].innerHTML;
                  			$('#check_no').val("");
                  			var q = this.cells[4].innerHTML;
                  			$("#hide_quantity").val(q); 
                  			if(q>1){
                    			$('#check_quantity').show();
                    			$('#check_no').focus();
                  			}  
                  			else{ 
                    			$('#check_quantity').hide();
                  			}       
                		};
			        }// loop
				} // else     
        	} // success
    	}); 
  	}
});

$('#remove').click(function(){
	var remove_value1= $('#remove_value').val();
  var no_quantity = Number(document.getElementById("hide_quantity").value);
  var check_quantity = Number(document.getElementById("check_no").value);
	var remain_number = no_quantity - check_quantity;
	if(remove_value1 =="" || remove_value1==null){
		alert("Please Select the Service/Item to remove");
	} else if((check_quantity>no_quantity)&&(no_quantity>1)){
    alert("Enter valid Amount");
    $("#check_no").css("border", "1px solid red");
    $('#check_no').focus();
    $('#check_no').val("");
  } else if((check_quantity=="" || check_quantity==null)&&(no_quantity>1)){
    alert("The No of item are required ");
    $("#check_no").css("border", "1px solid red");
    $('#check_no').focus();
    $('#check_no').val("");
  } else{      
    var qty = $("#hide_quantity").val();
    var nt=$('#tp').val();
    var remove_value = $('#remove_value').val();
    if((qty > 1)&&(check_quantity<no_quantity)) {
      document.getElementById("myTableData").rows[remove_value].cells[4].innerHTML = remain_number;
      var remove_amount = Number(document.getElementById("remove_amount").value);

      var remain_amount = nt - check_quantity*remove_amount;
      $("#tp").val(remain_amount);
      $("#nt").val(remain_amount);
      $("#remaining").val(remain_amount);
      var a =amountArray.length - remove_value1;
      quantityArray[a] = remain_number;
      //alert(quantityArray[a]);
      $('#checke_no').val("");
      $('#remove_value').val("");
      $('#remove_value1').val("");
    } else{
      document.getElementById("myTableData").deleteRow(remove_value1);
      var a =amountArray.length - remove_value1;
    
      if(qty > 1){
        var qty_amount = amountArray[a]*qty;
        var nta = nt-qty_amount;
        
      }else{
        var nta = nt-amountArray[a];
      }

      amountArray.splice(a,1);
      vehicleArray.splice(a,1);
      serviceArray.splice(a,1); 
      ItemTypeArray.splice(a,1);
      quantityArray.splice(a,1);

      $('#remove_value').val("");
      $('#removed_value').val("");
      $('#tp').val(nta);
      $('#nt').val(nta);

      var paid= $('#paid_amount').val();
      var rem = nta - paid;
      if(rem <= 0 ){
      	$('#remaining').val(0);
      } else {
      	$('#remaining').val(rem);	
      }
      $('#status').val("Unpaid");
      $('#disc').val("");
      $('#paid').val("0");

      if(amountArray.length==0){
        $('#mydata').hide();
        $('#remove_index').hide();
        $('#bill_form').hide();
        $('#price').val("");
        $('#selling_price').val("");
        $("#productSellingPrice").val("");
        //$('#custVehicle').val("");
        $('#item_type').val("");
        //$('#types').hide();
        $('#stock').hide();
        $('#servic').hide();
        $('#pname').hide();
        $('#quantity').hide();
        $('#product_quantity').val("");
        $('#nta').val("");
        $("#availbleStock").hide();
        $("#message").hide();
      }
    }
  }
  $('#removed_value').hide();
  $('#remove').hide();
  $('#check_quantity').hide();
  $('#check_no').val("");
});

$('#update').click(function(){
  // krajeeDialog.confirm('Are you sure to add bill', function(out){
  // if(out) {    
		var invoice_date = $('#invoice_date').val();
		
		vehicleArray;
		serviceArray; 
		amountArray;
		ItemTypeArray;
    	quantityArray;
    	customer_id;
    	invoice_id;

		var total_amount = $('#tp').val();
		var net_total = $('#nt').val();
		var paid = $('#paid_amount').val();
    	var remaining = $('#remaining').val();
    	var status = $('#status').val();
    	//var narration = $('#narration').val();
    	var cash_return = $('#cash_return').val();

    	//alert(vehicleArray +"-"+ serviceArray +"-"+ amountArray +"-"+ ItemTypeArray +"-"+ quantityArray +"-"+ total_amount +"-"+ net_total +"-"+ paid +"-"+ remaining +"-"+ status +"-"+ cash_return);
    
		if(invoice_date=="" || invoice_date==null){
			alert('Please Select the date ');
			$('#invoice_date').css("border", "1px solid red");
			$('#invoice_date').focus();
		}
		else if(net_total=="" || net_total==null){
			alert('Please Enter the value Net Total');
			$('#nt').css("border", "1px solid red");
			$('#invoice_date').css("border", "1px solid ");
			$('#nt').focus();
		}
    	else if(paid=="" || paid==null){
      		alert('Please Enter the Paid Amount');
      		$('#paid').css("border", "1px solid red");
      		$('#nt').css("border", "1px solid white");
      		$('#paid').focus();
    	}
		else{
			$.ajax({
	      		type:'post',
	      		data:{
        			u_user_id:user_id,
          			u_branch_id:branch_id,
          			u_invoice_id:invoice_id,
          			u_customer_id:customer_id,
    				u_invoice_date:invoice_date,
          			u_vehicleArray:vehicleArray,
					u_serviceArray:serviceArray,
					u_amountArray:amountArray,
					u_ItemTypeArray:ItemTypeArray,
          			u_quantityArray:quantityArray,
					u_total_amount:total_amount,
					u_net_total:net_total,
          			u_paid:paid,
          			u_remaining:remaining,
          			u_cash_return:cash_return,
          			u_status:status
      			},
        		url: "$url",
        		success: function(result){
          			if(result){
            			console.log(result);
            			window.location = './update-sale-invoice?saleinvheadID='+invoice_id+'&customerid='+customer_id;
            		}
          		}      
  	  		}); // ajax 
		} // else
    // }
  // });
}); // insert button

JS;
$this->registerJs($script);
?>

