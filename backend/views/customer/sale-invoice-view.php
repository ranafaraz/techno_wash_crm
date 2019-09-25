<?php 

	use yii\helpers\Html;
  $customerID = $_GET['customer_id'];
  $id=Yii::$app->user->identity->id;
  // getting customer name
  $customerName = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = $customerID
    ")->queryAll();

  // getting vehicle
  $customerVehicles = Yii::$app->db->createCommand("
    SELECT *
    FROM customer_vehicles
    WHERE customer_id = '$customerID'
    ")->queryAll();
    $countcustomerVehicles = count($customerVehicles);

 // getting services
  $services = Yii::$app->db->createCommand("
    SELECT *
    FROM services
    ")->queryAll();
    $countServices = count($services);

 // getting customer name
  $customerName = Yii::$app->db->createCommand("
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
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <h2 style="color:#3C8DBC;">Sale Invoice: <?php echo $customerName[0]['customer_name']; ?></h2>
    </div>
    <div class="col-md-4">

    </div>
  </div>
  <div class="row">
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-body">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#invoice" data-toggle="tab">New Invoice</a>
              </li>
              <li><a href="#previous" data-toggle="tab">Prevoius Invoices</a></li>
              <!-- <li><a href="#details" data-toggle="tab">Account Details</a></li> -->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="invoice">
               
                  <div class="form-group">
                          <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                  </div> 
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date"  class="form-control" id="invoice_date">
                      </div>
                    </div>
                    <div class="col-md-8">
                     
                    </div>
                  </div>
                </form>				
                <div class="row">
                    <div class="col-md-4" id=>
                      <div class="box box-info">
												<div class="box-body">
								          <div class="container-fluid" style="margin-bottom:8px;">
								            <div class="row">
								              <div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
								                Add Items
								              </div>
								            </div>
								          </div>
								          <div class="row">
								            <div class="col-md-12">
								                <div class="form-group">
								                  <label>Select Vehicle</label>
								                  <select name="customer_vehicle" class="form-control" id="vehicle">
								                    <option value="">Select Vehicle</option>
								                    <?php 
								                    for ($i=0; $i <$countcustomerVehicles ; $i++) { 
								                    $customerVehicleType = $customerVehicles[$i]['vehicle_typ_sub_id'];
								                    $VehicleReg = $customerVehicles[$i]['registration_no'];

								                    // getting vehicle type name
								                    $VehiclesName = Yii::$app->db->createCommand("
								                      SELECT *
								                      FROM vehicle_type_sub_category
								                      WHERE vehicle_typ_sub_id = '$customerVehicleType'
								                      ")->queryAll();
								                     ?>
								                    <option value="<?php echo $customerVehicles[$i]['customer_vehicle_id']; ?>"><?php echo $VehiclesName[0]['name']." - ".$VehicleReg; ?> </option>
								                    <?php } ?>
								                  </select>
								                </div>
								                <div class="form-group">
								                	<label>Select Type</label>
								                	<select id="item_type" class="form-control">
								                		<option value="">Select Type</option>
								                		<option value="Service">Service</option>
								                		<option value="Stock">Stock</option>
								                	</select>
								                </div>
								                <div id="servic" style="display: none;">
									                <div class="form-group">
									                  <label>Select Service</label>
									                  <select name="services" class="form-control" id="services">
									                    <option value="">Select Service</option>
									                    <?php 

									                    for ($j=0; $j <$countServices ; $j++) { 
									                    ?>
									                    <option value="<?php echo $services[$j]['services_id']; ?>"><?php echo $services[$j]['name'];?></option>
									                    <?php } ?>
									                  </select>
									                </div>
									                <div class="form-group">
									                  <label>Amount</label>
									                  <input type="text" name="amount" class="form-control" id="price" readonly="" >
									                </div>
								                </div>
								                <!-- services div -->
								                <div id="stock" style="display: none;">
									                <div class="form-group">
									                  <label>Barcode </label>
									                  <input type="text" id="barcode" class="form-control">
									                </div>
									                <div class="form-group">
									                  <label>Amount</label>
									                  <input type="text" class="form-control" id="selling_price" readonly="" >
									                </div>
								                </div>
								                <!-- stock div -->
								                <input type="hidden" id="service_name" >
								                <input type="hidden" id="stock_name">
																<input type="hidden" id="vehicle_name" >
								            </div>
								          </div>
												</div>
											</div>
                    </div>
                    <div class="col-md-8" >
                      <div class="row" id="mydata" style="display: none;">
												<div class="col-md-12">
													<table class="table table-bordered" id="myTableData">
														<thead>
															<tr>
																<th>Sr #</th>
																<th>Vehicle</th>
																<th>Item</th>
																<th>Type</th>
																<th>Amount</th>
															</tr>
														</thead>
													</table>
												</div>
											</div>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="previous">
                      
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      </div>
    </div>
    <div class="col-md-3" id="bill_form" style="display: none;">
      <div class="box box-success">
        <div class="box-body">
        	<div class="container-fluid" style="margin-bottom:8px;">
            <div class="row">
              <div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
                Bill
              </div>
            </div>
          </div>
          <div class="row" >
            <div class="col-md-12">
         
                <div class="form-group">
                  <label>Total Amount</label>
                  <input type="text" name="total_amount" class="form-control" readonly="" id="tp" value="0">
                </div>
                <div class="form-group">
					<label>Discount</label>
					 <input type="radio" name="discountType" id="percentage"   checked > Percentage
	
					  <input type="radio" name="discountType" id="amount"> Amount
					<input type="text" name="discount" class="form-control" id="disc" value="0">
					<input type="hidden" id="name" >
					<input type="hidden" id="vehicle_name" >
				</div>
                <div class="form-group">
                  <label>Net Total</label>
                  <input type="text" name="net_total" class="form-control" id="nt"readonly="" onfocus="discountFun()">
                </div>
                <div class="form-group">
                  <label>Paid</label>
                  <input type="text" name="paid" class="form-control"  id="paid">
                </div>
                <div class="form-group">
                  <label>Remaining</label>
                  <input type="text" name="remain" class="form-control" readonly="" id="remaining"
                  onfocus="cal_remaining()"> 
                </div>
                <div class="form-group">
                  <label>status</label>
                  <input type="text" name="status" class="form-control" readonly="" id="status">
                </div>
                <button class="btn btn-success btn-block btn-flat" id="insert" >
                	<i class="glyphicon glyphicon-plus" ></i> Add Bill</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>

	let vehicleArray 	= new Array();
	let serviceArray 	= new Array();
	let amountArray 	= new Array();
	let ItemTypeArray   = new Array();
	let customer_id     = <?php echo $customerID; ?>;
	let user_id= <?php echo $id; ?>;

	//var invoice_id 					= <?php //echo $saleInvoiceID; ?>;
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
            //alert(purchasePrice);
              }
            else if(document.getElementById('amount').checked)
            {
            	
            discount = parseInt(document.getElementById("disc").value);
                  
            purchasePrice = originalPrice - discount;
            //alert(purchasePrice);
              //discountReceived = discount;
             $('#nt').val(purchasePrice);
              //alert(originalPrice);
            } 
      }
      function cal_remaining(){
      	var paid = $('#paid').val();
      	var nt = $('#nt').val();
      	var remaining =nt - paid;
      	$('#remaining').val(remaining); 
      	if (remaining ==0) {
      		$('#status').val('paid');
      	}
      	else if (remaining < paid) {
      		$('#status').val('Partially');
      	}
      	else if (remaining = nt) {
      		$('#status').val('Unpaid');
      	}
      	$('#insert').show();
      }
</script>
<?php
$url = \yii\helpers\Url::to("customer/fetch-info");


$script = <<< JS

	$("#item_type").change(function(){
		 var item_type = $('#item_type').val();
		 if(item_type == "Service")
		 {
		 	$('#servic').show();
		 	$('#stock').hide();
		 }
		 else if(item_type == "Stock")
		 {
		 	$('#stock').show();
		 	$('#servic').hide();
		 }
	});


	$("#services").change(function(){
		var serviceID = $("#services").val();
		//alert(serviceID);
		$.ajax({
	        type:'post',
	        data:{serviceID:serviceID},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	
           $('#price').val(jsonResult[0]['price']);
           $('#service_name').val(jsonResult[0]['name']);

            var totalAmount = parseInt($('#tp').val());
				    var tprice = jsonResult[0]['price'];
				    var tp = parseInt(totalAmount)+parseInt(tprice);
				    $('#tp').val(tp);

				    var vehicle 						= $('#vehicle').val();
						var services 						= $('#services').val();
						var price 							= $('#price').val();
						var servicesName				=$('#service_name').val();
						var reg_name 						= $('#vehicle_name').val();
						var type                =$('#item_type').val();
						
						if (vehicle=="" || vehicle==null)
						{
									alert("Select the Vehicle name ");
						}
						else if (services=="" || services==null) {
									alert("Select the Services ");
						}
						else
						{
						vehicleArray.push(vehicle);
						serviceArray.push(services);
						amountArray.push(price);
						ItemTypeArray.push(type);

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
						row.insertCell(4).innerHTML= price;


					  // $('#vehicle').val("");
						$('#services').val("");
				
	}
        	}      
    	}); 
	});

	$("#disc").change(function(){
		 var totalAmount = $('#tp').val();

		 if($("#percentage").checked)
              {
              	
            discount = parseInt($("#disc").val());
            
            discountReceived = parseInt((totalAmount*discount)/100);
            
            purchasePrice = totalAmount-discountReceived;
            $('#nt').val(purchasePrice);
              }
            else if(document.getElementById("#amount").checked)
            {
            	
            discount = parseInt(document.getElementById("disc").value);
                  
            purchasePrice = originalPrice - discount;
              //discountReceived = discount;
             //$('#nt').val(purchasePrice);
              //alert(originalPrice);
            } 
	});

	$("#vehicle").change(function(){
		var vehicle = $("#vehicle").val();
		//alert(vehicle);
		$.ajax({
	        type:'post',
	        data:{vehicle:vehicle},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	 $('#vehicle_name').val(jsonResult[0]['registration_no']);
        	}      
    	}); 
	});

	$("#barcode").change(function(){
		var barcode = $("#barcode").val();
		$.ajax({
	        type:'post',
	        data:{barcode:barcode},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	 $('#selling_price').val(jsonResult[0]['selling_price']);
	        	 $('#stock_name').val(jsonResult[0]['name']);

	        	var totalAmount = parseInt($('#tp').val());
				    var tprice = jsonResult[0]['selling_price'];
				    var tp = parseInt(totalAmount)+parseInt(tprice);
				    $('#tp').val(tp);

				    var vehicle 						= $('#vehicle').val();
						var barcode             = jsonResult[0]['stock_id'];
						var stock_price 				= $('#selling_price').val();
						var servicesName				=$('#stock_name').val();
						var reg_name 						= $('#vehicle_name').val();
						var type                =$('#item_type').val();
						
						if (vehicle=="" || vehicle==null)
						{
									alert("Select the Vehicle name ");
						}
						else if (services=="" || services==null) {
									alert("Select the Services ");
						}
						else
						{
						vehicleArray.push(vehicle);
						serviceArray.push(barcode);
						amountArray.push(stock_price);
						ItemTypeArray.push(type);

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
						row.insertCell(4).innerHTML= stock_price;


					  // $('#vehicle').val("");
						$('#barcode').val("");
						//$('#selling_price').val("");
						$('#barcode').focus();


				
	}
        	}      
    	}); 
	});
	$('#insert').click(function(){

		var invoice_date = $('#invoice_date').val();

		customer_id;
		var total_amount = $('#tp').val();
		var net_total = $('#nt').val();
		var paid = $('#paid').val();
	    var remaining = $('#remaining').val();
	    var status = $('#status').val();
		vehicleArray;
		serviceArray; 
		amountArray;
 		ItemTypeArray;
 			
			// alert(ItemTypeArray);
			// if(invoice_date=='' || invoice_date==null){
			// 	alert("Please Select the today's Date");
			// }
		$.ajax({
	        type:'post',
	        data:{
	        	user_id:user_id,
	        	invoice_date:invoice_date,
				customer_id:customer_id,
				vehicleArray:vehicleArray,
				serviceArray:serviceArray,
				amountArray:amountArray,
				ItemTypeArray:ItemTypeArray,
				total_amount:total_amount,
				net_total:net_total,
				paid:paid,
				remaining:remaining,
				status:status
	        	},
	        url: "$url",
	        success: function(result){
	        	//var jsonResult = JSON.parse(result);
        		if(result){
        			
        			window.location = './sale-invoice-view?customer_id=$customerID';
        		}       	
        	}      
    	}); 

	});

JS;
$this->registerJs($script);
?>