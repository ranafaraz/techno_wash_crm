
<?php 

if(isset($_GET['sihID'])){
	$sihID = $_GET['sihID'];
}

if(isset($_GET['SIH'])){
	$sihID = $_GET['SIH'];	
}
// $regNoID = $_GET['regno'];
$paidinvoiceData = Yii::$app->db->createCommand("
SELECT *
FROM sale_invoice_head
WHERE sale_inv_head_id = '$sihID'
")->queryAll();
date_default_timezone_set("Asia/Karachi");
$date = date('d-M-y');
$time = date('h:i A');
//$date = date('d-M-Y',strtotime($paidinvoiceData[0]['created_at']));
//$time = date('g:i a',strtotime($paidinvoiceData[0]['created_at']));

// echo $date."<br>";
// echo $time;

$customerID = $paidinvoiceData[0]['customer_id'];

$CustmName  = Yii::$app->db->createCommand("
SELECT customer_name
FROM customer
WHERE customer_id = '$customerID'
")->queryAll();
$customer_name = $CustmName[0]['customer_name'];


$bill = Yii::$app->db->createCommand("
SELECT *
FROM sale_invoice_head
WHERE sale_inv_head_id = '$sihID'
AND customer_id = '$customerID'
")->queryAll();

// query to fetch all customer vehicles against `sale invoice id` and `customer id`
$customervehicleID = Yii::$app->db->createCommand("
SELECT DISTINCT(sid.customer_vehicle_id)
FROM sale_invoice_head as sih
INNER JOIN sale_invoice_detail as sid
ON sih.sale_inv_head_id = sid.sale_inv_head_id
WHERE sih.customer_id = '$customerID'
AND sih.sale_inv_head_id = '$sihID'
")->queryAll();
// count customer vehicles
$countcustomervehicleID = count($customervehicleID);
   
?>

<!DOCTYPE html>
<html>
<head>
	<title>Paid Sale Invoice</title>
	 <style type="text/css" media="screen">
 	@media print{
 		table{
 			break-inside: avoid !important;
 			page-break-inside: avoid !important;
 		}
 		.footer{
 			border: 0px !important;
 		}
 	}
 </style>
</head>
<body style="font-size:15px;" onload="window.print()" onafterprint="returnBack();">
	<style type="text/css" media="print">
		footer,#print_button{
			display: none;
		}

	</style>
	<div class="container-fluid">
		
		<div id="div1" style="font-size:20px;font-family:arial;">
			<div class="row">
				<div class="col-md-6  col-md-offset-3">
					<h3  style="text-align: center;font-weight: bolder;">
						TECHNO WASH
					</h3>
					<p style="text-align: center;">
						Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur<br>Contact #: +92 (300) 060 0106<br>https://www.technowashbwp.pk
					</p>
					<h3 style="text-align: center;background-color:#000000 !important;color:white !important;padding:10px;">Cash Memo</h3>
					
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="vertical-align: top;">Name:</th>
										
										<td style="text-align: center;"><?php echo $customer_name; ?></td>
										<th>Date</th>
										
										<td style="text-align: center;"><?php echo $date; ?></td>
									</tr>
									<tr>
										<th><b>INV #</b></th>
										
										<td style="text-align: center;"><?php echo $sihID; ?></td>
										<th>Time</th>
										
										<td style="text-align: center;"><?php echo $time; ?></td>
									</tr>
								</thead>
							</table>
						</div>
					</div>

					<?php 
						$quantity = 0;
						$totalAmount = 0;
						$countStockItems =0;

						// loop for customer vehicles 

						for ($i=0; $i <$countcustomervehicleID ; $i++) {
							$customerVehID = $customervehicleID[$i]['customer_vehicle_id'];

							// 	Query to fetch customer vehicles data against `customerVehID`
							// 	Data;
							// `vehicle type`
							// `manufacture`
							// `car model`
							// `registration #`

							$customervehicleData = Yii::$app->db->createCommand("
						    SELECT 
						    cv.registration_no,
						    cvst.name,
						    vtsch.vehicle_type_id,vtsch.manufacture
						    FROM ((customer_vehicles as cv
						    INNER JOIN vehicle_type_sub_category as cvst
						    ON cv.vehicle_typ_sub_id = cvst.vehicle_typ_sub_id)
						    INNER JOIN vehicle_type_sub_cat_head as vtsch
						    ON vtsch.sub_cat_head_id = cvst.sub_type_head_id)
						    WHERE cv.customer_vehicle_id = '$customerVehID'
						    ")->queryAll();
						    // vehicle type id
						    $vTypeId = $customervehicleData[0]['vehicle_type_id'];
						    // vehicle manufacture
						    $manId = $customervehicleData[0]['manufacture'];

						    // get vehicle type name
						    $vehicleType = Yii::$app->db->createCommand("
						    SELECT *
						    FROM vehicle_type
						    WHERE vehical_type_id = '$vTypeId'
						    ")->queryAll();
						    // get car manufacture name
						    $manufactureData = Yii::$app->db->createCommand("
						    SELECT *
						    FROM car_manufacture
						    WHERE car_manufacture_id = '$manId'
						    ")->queryAll();

						 ?>
						<table class="table table-bordered">
							<thead style="background-color: #3C8DBC !important;color:white;">
								<tr>
									<th colspan="6" style="text-align: center;background-color:lightgray !important;"><?php echo "VEH #: "."( ".$vehicleType[0]['name']." - ".$manufactureData[0]['manufacturer']." - ".$customervehicleData[0]['name']." ) ".$customervehicleData[0]['registration_no'] ;?></th>
								</tr>
								<tr>
									<th style="background-color: #f1f1f1 !important;">Sr #</th>
									<th style="background-color: #f1f1f1 !important;">Item</th>
									<th style="background-color: #f1f1f1 !important;">Type</th>
									<th style="background-color: #f1f1f1 !important;">Price</th>
									<th style="background-color: #f1f1f1 !important;">Quantity</th>
									<th style="background-color: #f1f1f1 !important;">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="2" style="text-align: center;background-color: #f1f1f1 !important;">Stock</td>
								</tr>
								<?php 
								$stockDetails = Yii::$app->db->createCommand("
							    SELECT DISTINCT(s.name)
							    FROM sale_invoice_detail as sid
							    INNER JOIN stock as s
							    ON s.stock_id = sid.item_id
							    WHERE sid.sale_inv_head_id = '$sihID'
							    AND sid.customer_vehicle_id = '$customerVehID'
							    AND sid.item_type = 'Stock'
							    ")->queryAll();
							    $countStockDetails = count($stockDetails);
							    
								for ($j=0; $j <$countStockDetails ; $j++) { 
								
								    $productId = $stockDetails[$j]['name'];
								    $stockData = Yii::$app->db->createCommand("
								    SELECT name,selling_price
								    FROM stock
								    WHERE name = '$productId'
								    ")->queryAll();

								    $stockName = $stockData[0]['name'];
								    $productData = Yii::$app->db->createCommand("
								    SELECT product_name,manufacture_id
								    FROM products
								    WHERE product_id = '$productId'
			 					    ")->queryAll();
								   
								    $stockCount = Yii::$app->db->createCommand("
								    SELECT sid.item_id
								    FROM sale_invoice_detail as sid
								    WHERE sid.sale_inv_head_id = '$sihID'
								    AND sid.customer_vehicle_id = '$customerVehID'
								    AND sid.item_type = 'Stock'
			 					    ")->queryAll();
								    $stockCounter=0;
			 					    foreach ($stockCount as $key => $value) {
			 					    	$item = $value['item_id'];
			 					    	$stock = Yii::$app->db->createCommand("
										    SELECT s.stock_id
										    FROM stock as s
										    WHERE s.name = '$productId'
										    AND s.status = 'Sold'
											AND s.stock_id = '$item'
					 					    ")->queryAll();
			 					    	if(!empty($stock)){
			 					    		$stockCounter++;
			 					    	}
			 					    }
			 					    $quantity += $stockCounter; 
									?>
									<tr>
										<th><?php echo $j+1; ?></th>
										<th><?php echo $productData[0]['product_name']; ?></th>
										<th><?php echo "STOCK"; ?></th>
										<th style="text-align: center;"><?php echo $stockData[0]['selling_price']; ?></th>
										<th style="text-align: center;"><?php echo $stockCounter; ?></th>
										<th style="text-align: center;">
											<?php echo $total = $stockData[0]['selling_price']*$stockCounter; 
											$totalAmount += $total;
											?>
										</th>
									</tr>
								<?php } // stock loop close ?>
								<tr>
									<td colspan="2" style="text-align: center;background-color: #f1f1f1 !important;">Services</td>
								</tr>
								<?php
								$serviceDetails = Yii::$app->db->createCommand("
								    SELECT DISTINCT(item_id)
								    FROM sale_invoice_detail as sid
								    WHERE sale_inv_head_id = '$sihID'
								    AND customer_vehicle_id = '$customerVehID'
								    AND item_type = 'Service'
							    ")->queryAll();
							    $countServiceDetails = count($serviceDetails);
							 	$countStockItems +=$countStockDetails +$countServiceDetails;
								for ($k=0; $k <$countServiceDetails ; $k++) { 
								    $serviceID = $serviceDetails[$k]['item_id'];
								    $serviceData = Yii::$app->db->createCommand("
								    SELECT sd.price,s.service_name 
								    FROM service_details as sd
								    INNER JOIN services as s
								    ON sd.service_id = s.service_id
								    WHERE sd.service_detail_id = '$serviceID'
								    ")->queryAll();

								    $servicesCount = Yii::$app->db->createCommand("
								    SELECT item_id
								    FROM sale_invoice_detail as sid
								    WHERE sale_inv_head_id = '$sihID'
								    AND customer_vehicle_id = '$customerVehID'
								    AND item_id = '$serviceID'
								    AND item_type = 'Service'
			 					    ")->queryAll();
			 					    $countService = count($servicesCount);
			 					    $quantity += $countService; 
									?>
									<tr>
										<th><?php echo $k+1; ?></th>
										<th><?php echo $serviceData[0]['service_name']; ?></th>
										<th><?php echo "SERVICE"; ?></th>
										<th style="text-align: center;"><?php echo $serviceData[0]['price']; ?></th>
										<th style="text-align: center;"><?php echo $countService; ?></th>
										<th style="text-align: center;">
											<?php echo $total = $serviceData[0]['price']*$countService; 
											$totalAmount += $total;
											?>
										</th>
									</tr>
								<?php } // service loop close?>
							</tbody>
						</table>
					<?php  } // customer vehicles loop close ?>
				</div>
				<div class="col-sm-12">
					<table class="table table-bordered" >
						<thead>
							<tr>
								<th style="text-align: center;background-color: lightgray !important;">Total Item: </th>
								<th style="background-color: white;text-align: center;"><?php echo $countStockItems; ?></th>
								<th style="text-align: center;background-color: lightgray !important;">Total Qty: </th>
								<th style="background-color:white;text-align: center;"><?php echo $quantity; ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="background-color:white;color:black;">Total Amount</th>
								<th style="text-align: center;"><?php echo $bill[0]['total_amount']; ?></th>
							</tr>
							<tr>
								<th style="background-color:white;color:black;">Invoice Discount</th>
								<th style="text-align: center;"><?php echo $bill[0]['discount']; ?></th>
							</tr>
							<tr>
								<th style="background-color:white;color:black;">Net Bill</th>
								<th style="text-align: center;"><?php echo $bill[0]['net_total']; ?></th>
							</tr>
							<tr>
								<th style="background-color:white;color:black;">Paid</th>
								<th style="text-align: center;"><?php echo $bill[0]['paid_amount']; ?></th>
							</tr>
							<tr>
								<th style="background-color:white;color:black;">Cash Returned</th>
								<th style="text-align: center;"><?php echo $bill[0]['cash_return']; ?></th>
							</tr>
							<tr>
								<th style="background-color:white;color:black;">Remaining</th>
								<th style="text-align: center;"><?php echo $bill[0]['remaining_amount']; ?></th>
							</tr>
							<tr>
								<th style="background-color:white;color:black;">Status</th>
								<th style="background-color:#68c968;color:white;text-align: center;"><?php echo $bill[0]['status']; ?></th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-sm-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td style="font-weight: bold;background-color: #f1f1f1 !important;">
									Salesman:
								</td>
								<td style="text-align: center;">
									<?php 

										//echo Yii::$app->user->identity->username;
									?>
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-sm-3">
					<tr style="border:none;" class="footer">
						<td colspan="2" style="border:0px !important;" class="footer">
							<h4 style="text-align: center;background-color:#000000!important;padding:10px;color: white !important;">Thanks For Visting Us!</h4>
							<p style="text-align: center;">
								<i>Powered By:</i>&nbsp;<b>Dexterous Developers</b><br>Contact #: +92 (306) 377 2106<br><b>Website: </b><i>www.dexdevs.com</i>
							</p>
						</td>
					</tr>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>

<?php 

if(isset($_GET['sihID'])){
?>
	<script>
		function returnBack() {
		  window.location='./sale-invoice-view';
		}
	</script>
<?php
}

if(isset($_GET['SIH'])){
?>
	<script>
		function returnBack() {
		  window.location='customer-profile?customer_id=<?php echo $customerID;?>';
		}
	</script>
<?php	
}
