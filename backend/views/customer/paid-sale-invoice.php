
<?php 
$sihID = $_GET['sihID'];
	$paidinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE sale_inv_head_id = '$sihID'
    ")->queryAll();
    $customerID = $paidinvoiceData[0]['customer_id'];

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
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h3  style="text-align: center;">
					TECHNO WASH
				</h3>
				<p style="text-align: center;">
					Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur<br>Contact #: +92 (300) 060 0106<br>http://www.facebook.com/technowashbwp/
				</p>
				<h3 style="text-align: center;background-color: lightgray !important;padding:10px;">Cash Memo</h3>
				<?php 
					$quantity = 0;
					$totalAmount = 0;
					for ($i=0; $i <$countcustomervehicleID ; $i++) {
					$customerVehID = $customervehicleID[$i]['customer_vehicle_id'];
					// echo $customerVehID;
					// echo $sihID;
					$customervehicleData = Yii::$app->db->createCommand("
				    SELECT cv.registration_no,cvst.name,vt.name as Name
				    FROM ((customer_vehicles as cv
				    INNER JOIN vehicle_type_sub_category as cvst
				    ON cv.vehicle_typ_sub_id = cvst.vehicle_typ_sub_id)
				    INNER JOIN vehicle_type as vt
				    ON vt.vehical_type_id = cvst.vehicle_type_id)
				    WHERE cv.customer_vehicle_id = '$customerVehID'
				    ")->queryAll();
				    //print_r($customervehicleData);

					
				 ?>
				<table class="table">
					<thead style="background-color:#3C8DBC;color:white;">
						<tr>
							<th colspan="6"><?php echo "VEH #: "."( ".$customervehicleData[0]['Name']." - ".$customervehicleData[0]['name']." ) ".$customervehicleData[0]['registration_no'] ;?></th>
						</tr>
						<tr>
							<th>Sr #</th>
							<th>Item</th>
							<th>Type</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
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
					    //print_r($stockDetails);

					    $serviceDetails = Yii::$app->db->createCommand("
					    SELECT DISTINCT(item_id)
					    FROM sale_invoice_detail as sid
					    WHERE sale_inv_head_id = '$sihID'
					    AND customer_vehicle_id = '$customerVehID'
					    AND item_type = 'Service'
					    ")->queryAll();
					    //print_r($serviceDetails);
					    $countServiceDetails = count($serviceDetails);

					    for ($j=0; $j <$countStockDetails ; $j++) { 
					    $stockID = $stockDetails[$j]['item_id'];
					    $stockData = Yii::$app->db->createCommand("
					    SELECT name,selling_price
					    FROM stock
					    WHERE stock_id = '$stockID'
					    ")->queryAll();

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
							<td><?php echo $j+1; ?></td>
							<td><?php echo $stockData[0]['name']; ?></td>
							<td><?php echo "STOCK"; ?></td>
							<td><?php echo $stockData[0]['selling_price']; ?></td>
							<td><?php echo $countStock; ?></td>
							<td>
								<?php echo $total = $stockData[0]['selling_price']*$countStock; 
								$totalAmount += $total;
								?>
							</td>
						</tr>
						<?php }
						for ($k=0; $k <$countServiceDetails ; $k++) { 
					    $serviceID = $serviceDetails[$k]['item_id'];
					    $serviceData = Yii::$app->db->createCommand("
					    SELECT name,price
					    FROM services
					    WHERE services_id = '$serviceID'
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
							<td><?php echo $k+1; ?></td>
							<td><?php echo $serviceData[0]['name']; ?></td>
							<td><?php echo "SERVICE"; ?></td>
							<td><?php echo $serviceData[0]['price']; ?></td>
							<td><?php echo $countService; ?></td>
							<td>
								<?php echo $total = $serviceData[0]['price']*$countService; 
								$totalAmount += $total;
								?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
			<div class="col-sm-6 col-md-offset-3">
				<table class="table table-bordered" >
					<thead>
						<tr>
							<th style="text-align: center;background-color: lightgray;">Total Item: </th>
							<th style="background-color: white;"><?php echo $countStockItems; ?></th>
							<th style="text-align: center;background-color: lightgray;">Total Qty: </th>
							<th style="background-color:white;"><?php echo $quantity; ?></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				
			</div>
			<div class="col-sm-3">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Total Amount</th>
							<th><?php echo $bill[0]['total_amount']; ?></th>
						</tr>
						<tr>
							<th>Invoice Discount</th>
							<th><?php echo $bill[0]['discount']; ?></th>
						</tr>
						<tr>
							<th>Net Bill</th>
							<th><?php echo $bill[0]['net_total']; ?></th>
						</tr>
						<tr>
							<th>Paid</th>
							<th><?php echo $bill[0]['paid_amount']; ?></th>
						</tr>
						<tr>
							<th>Remaining</th>
							<th><?php echo $bill[0]['remaining_amount']; ?></th>
						</tr>
						<tr>
							<th>Status</th>
							<th><?php echo $bill[0]['status']; ?></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</body>
</html>