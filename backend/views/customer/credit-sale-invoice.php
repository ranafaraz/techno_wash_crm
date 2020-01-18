 
<?php 
$sihID = $_GET['sihID'];
$regNoID = $_GET['regno'];
	$paidinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE sale_inv_head_id = '$sihID'
    ")->queryAll();
    $date = date('d-M-Y',strtotime($paidinvoiceData[0]['created_at']));
    $time = date('h:i a',strtotime($paidinvoiceData[0]['created_at']));

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

$customervehicleID = Yii::$app->db->createCommand("
    SELECT DISTINCT(sid.customer_vehicle_id)
    FROM sale_invoice_head as sih
    INNER JOIN sale_invoice_detail as sid
    ON sih.sale_inv_head_id = sid.sale_inv_head_id
    WHERE sih.customer_id = '$customerID'
    AND sih.sale_inv_head_id = '$sihID'
    ")->queryAll();
    $countcustomervehicleID = count($customervehicleID);
    //echo $countcustomervehicleID;
    $stockItems = Yii::$app->db->createCommand("
    SELECT DISTINCT(item_id)
    FROM sale_invoice_detail
    WHERE sale_inv_head_id = '$sihID'
    AND (item_type = 'Stock' OR item_type = 'Service')
    ")->queryAll();
    $countStockItems = count($stockItems);

    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Paid Sale Invoice</title>
	<style type="text/css" media="print">
		footer,#print_button{
			display: none;
		}
	</style>
</head>
<body style="font-size:15px;" onload="window.print();" onafterprint="returnBack();">
	
	<div class="container-fluid">
		<!-- <div class="row">
			<div class="col-md-2">
				<a href="./sale-invoice-view?customer_id=<?php //echo $customerID; ?>&regno=<?=$regNoID?>" class="btn btn-danger btn-flat" style="width: 70%;"><i class="glyphicon glyphicon-backward"></i> Back</a>
			</div>
			<div class="col-md-8"></div>
			<div class="col-md-2">
				<button type="button" onclick="printContent('div1')" class="btn btn-warning btn-flat" id="print_button"><i class="glyphicon glyphicon-print"></i> Print Invoice</button>
			</div>
		</div> -->
		<div id="div1" style="font-size:20px;font-family:arial;">
			
		
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h3  style="text-align: center;font-weight: bolder;">
						TECHNO WASH
					</h3>
					<p style="text-align: center;">
						Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur<br>Contact #: +92 (300) 060 0106<br>http://www.technowashbwp.pk
					</p>
					<h3 style="text-align: center;background-color:#000000 !important;color:white !important;padding:10px;">Credit Cash Memo</h3>
					
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
						for ($i=0; $i <$countcustomervehicleID ; $i++) {
						$customerVehID = $customervehicleID[$i]['customer_vehicle_id'];
						//echo $customerVehID;
						// echo $sihID;
						$customervehicleData = Yii::$app->db->createCommand("
					    SELECT cm.manufacturer,cv.registration_no,cvst.name,vt.name as Name
					    FROM ((customer_vehicles as cv
					    INNER JOIN vehicle_type_sub_category as cvst
					    ON cv.vehicle_typ_sub_id = cvst.vehicle_typ_sub_id)
					    INNER JOIN car_manufacture as cm
					    ON cm.car_manufacture_id = cvst.manufacture)
					    INNER JOIN vehicle_type as vt
					    ON vt.vehical_type_id = cm.vehical_type_id
					    WHERE cv.customer_vehicle_id = '$customerVehID'
					    ")->queryAll();
					 ?>
					<table class="table table-bordered">
						<thead style="background-color: #3C8DBC !important;color:white;">
							<tr>
								<th colspan="6" style="text-align: center;background-color:lightgray !important;">
									<b>
										<?php echo "VEH #: "."( ".$customervehicleData[0]['Name']." - ".$customervehicleData[0]['manufacturer']." - ".$customervehicleData[0]['name']." ) ".$customervehicleData[0]['registration_no'] ;?>
									</b>
								</th>
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
							<?php 
							$stockDetails = Yii::$app->db->createCommand("
						    SELECT DISTINCT(item_id)
						    FROM sale_invoice_detail
						    WHERE sale_inv_head_id = '$sihID'
						    AND customer_vehicle_id = '$customerVehID'
						    AND item_type = 'Stock'
						    ")->queryAll();
						    $countStockDetails = count($stockDetails);
						    

						    $serviceDetails = Yii::$app->db->createCommand("
						    SELECT DISTINCT(item_id)
						    FROM sale_invoice_detail as sid
						    WHERE sale_inv_head_id = '$sihID'
						    AND customer_vehicle_id = '$customerVehID'
						    AND item_type = 'Service'
						    ")->queryAll();
						    
						    $countServiceDetails = count($serviceDetails);

						    for ($j=0; $j <$countStockDetails ; $j++) { 
						    $stockID = $stockDetails[$j]['item_id'];
						    $stockData = Yii::$app->db->createCommand("
						    SELECT name,selling_price
						    FROM stock
						    WHERE stock_id = '$stockID'
						    ")->queryAll();

						    $stockName = $stockData[0]['name'];
						    $productData = Yii::$app->db->createCommand("
						    SELECT product_name,manufacture_id
						    FROM products
						    WHERE product_id = '$stockName'
	 					    ")->queryAll();
	 					    $countproductData= count($productData);

						    $stockCount = Yii::$app->db->createCommand("
						    SELECT item_id
						    FROM sale_invoice_detail as sid
						    WHERE sale_inv_head_id = '$sihID'
						    AND customer_vehicle_id = '$customerVehID'
						    AND item_id = '$stockID'
						    AND item_type = 'Stock'
	 					    ")->queryAll();
	 					    $countStock= count($stockCount);
	 					    $quantity += $countStock; 
							?>
							<tr>
								<th><?php echo $j+1; ?></th>
								<th><?php echo $productData[0]['product_name']; ?></th>
								<th><?php echo "STOCK"; ?></th>
								<th style="text-align: center;"><?php echo $stockData[0]['selling_price']; ?></th>
								<th style="text-align: center;"><?php echo $countStock; ?></th>
								<th style="text-align: center;">
									<?php echo $total = $stockData[0]['selling_price']*$countStock; 
									$totalAmount += $total;
									?>
								</th>
							</tr>
							<?php }
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
							<?php } ?>
						</tbody>
					</table>
					<?php  } ?>
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
								<?php
								 $status = $bill[0]['status'];
								 if (($status == "Unpaid") || ($status == "unpaid")) {
								 	?>
									<th style="text-align: center;background-color: #DD4B39;color: white;"><?php echo $bill[0]['status']; ?></th>
								<?php } elseif (($status == "Partially") || ($status == "partially")) {
									?>
									<th style="text-align: center;background-color:#FAB61C;color: white;"><?php echo $bill[0]['status']; ?> Paid</th>
								<?php } ?>
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

										echo Yii::$app->user->identity->username;
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
<script>
// function printContent(el){
// 	var restorepage = document.body.innerHTML;
// 	var printcontent = document.getElementById(el).innerHTML;
// 	document.body.innerHTML = printcontent;
// 	window.print();
// 	document.body.innerHTML = restorepage;
// }
function returnBack() {
  window.location='sale-invoice-view?customer_id=<?php echo $customerID;?>&regno=<?php echo $regNoID;?>';
}
</script>
