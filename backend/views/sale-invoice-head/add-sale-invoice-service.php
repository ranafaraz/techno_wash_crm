<?php 

	$customerID = $_GET['customerID'];
	$saleInvoiceID = $_GET['saleInvoiceID'];

	// getting vehicle
	$customerVehicles = Yii::$app->db->createCommand("
    SELECT *
    FROM customer_vehicles
    WHERE customer_id = '$customerID'
    ")->queryAll();
    $countcustomerVehicles = count($customerVehicles);

 //    // getting services
	$services = Yii::$app->db->createCommand("
    SELECT *
    FROM services
    ")->queryAll();
    $countServices = count($services);

 //    // getting customer name
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
		<div class="col-md-12">
			<h2 style="color:#3C8DBC;">Sale Invoice: <?php echo $customerName[0]['customer_name']; ?> ( ID: <?php echo $saleInvoiceID; ?> )</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="box box-default">
				<div class="box-body">
					<div class="container-fluid" style="margin-bottom:8px;">
						<div class="row">
							<div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
								Add Service
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
										<option value="<?php echo $VehiclesName[0]['vehicle_typ_sub_id']; ?>"><?php echo $VehiclesName[0]['name']." - ".$VehicleReg; ?> </option>
										<?php } ?>
									</select>
								</div>
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
									<input type="text" name="amount" class="form-control" id="price" readonly="">
								</div>
								<div class="form-group">
									<label>Discount</label>
									 <input type="radio" name="discountType" id="percentage"  required="required" value="percentage" checked >By Percentage
					
									  <input type="radio" name="discountType" id="amount"  required="required" value="amount"> By Amount
									<input type="text" name="discount" class="form-control" id="disc">
								</div>
								<div class="form-group">
									<label>After Discount</label>
									<input type="text" name="after_discount" class="form-control" readonly="" id="after">
								</div>
								<button onclick="insertArray()" type="submit" name="add" class="btn btn-success">Add</button>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="box box-default">
				<div class="box-body">
					<div class="container-fluid" style="margin-bottom:8px;">
						<div class="row">
							<div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
								List of Services
							</div>
						</div>
					</div>
					<div class="row" id="mydata">
						<div class="col-md-12">
							<table class="table table-bordered" id="myTableData">
								<thead>
									<tr>
										<th>Sr #</th>
										<th>Vehicle</th>
										<th>Services</th>
										<th>Amount</th>
										<th>Discount</th>
										<th>After Discount</th>
									</tr>
								</thead>
							</table>
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

	let vehicleArray 		= new Array();
	let serviceArray 		= new Array();
	let amountArray 		= new Array();
	let discountArray 		= new Array();
	let afterDiscountArray 	= new Array();

	function insertArray(){

	var vehicle 	= $('#vehicle').val();
	var services 	= $('#services').val();
	var price 		= $('#price').val();
	var disc 		= $('#disc').val();
	var after 		= $('#after').val();

	vehicleArray.push(vehicle);
	serviceArray.push(services);
	amountArray.push(price);
	discountArray.push(disc);
	afterDiscountArray.push(after);

	$("#mydata").show();

	let table = document.getElementById("myTableData");

	//count the table row
	let rowCount = table.rows.length;

	//insert the new row
	let row = table.insertRow(1);
	  
	//insert the coulmn against the row
	row.insertCell(0).innerHTML= rowCount;
	row.insertCell(1).innerHTML= vehicle;
	row.insertCell(2).innerHTML= services;
	row.insertCell(3).innerHTML= price;
	row.insertCell(4).innerHTML= disc;
	row.insertCell(5).innerHTML= after;


    $('#vehicle').val("");
	$('#services').val("");
	$('#price').val("");
	$('#disc').val("");
	$('#after').val("");

	}
</script>
<?php
$url = \yii\helpers\Url::to("sale-invoice-head/fetch-info");


$script = <<< JS

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
           $("#disc").change(function(){
		var afterDiscount = $("#price").val() - $("#disc").val();
           $('#after').val(afterDiscount);
		
	});
           
        	}      
    	}); 
	});

	
	


JS;
$this->registerJs($script);
?>