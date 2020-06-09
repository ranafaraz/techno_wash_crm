<?php 
if(isset($_GET['customer'])){
	$currentDate = date('Y-m-d');

	$countCustomer  = Yii::$app->db->createCommand("
	  SELECT sih.*
	  FROM sale_invoice_head as sih
	  WHERE CAST(sih.date as DATE) = '$currentDate'
	")->queryAll();
	
	$countcustomer = count($countCustomer);
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
					<h3 style="color:#3C8DBC;">
						<a href="./home" class="btn btn-success">
							<i class="glyphicon glyphicon-home"> HOME</i>
						</a>
					Customers (<?php echo $currentDate;?>)
					</h3> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered">
						<thead style="background-color:#3C8DBC;color:white;">
							<tr>
								<th>Sr.#</th>
								<th>Customer Name</th>
								<th>Reg.#</th>
								<th>Total</th>
								<th>Paid</th>
								<th>Remaining</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php 
				               $netTotal=$paidamt=$remainAmt=0;
				              for ($c=0; $c <$countcustomer ; $c++) {
				              	$sale_inv_head_id = $countCustomer[$c]['sale_inv_head_id'];

				              	$saledetails  = Yii::$app->db->createCommand("
								  SELECT sid.*
								  FROM sale_invoice_detail as sid
								  WHERE sid.sale_inv_head_id = '$sale_inv_head_id'
								")->queryAll();

				              	$customerID = $countCustomer[$c]['customer_id'];

								$custVehicleID = $saledetails[0]['customer_vehicle_id'];
					              $customerInfo  = Yii::$app->db->createCommand("
						          SELECT customer.customer_name,customer_vehicles.registration_no, vtsc.name
						          FROM customer
						          INNER JOIN customer_vehicles
						          ON customer.customer_id = customer_vehicles.customer_id 
						      		INNER JOIN vehicle_type_sub_category as vtsc
						     		ON customer_vehicles.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id
						          WHERE customer.customer_id = '$customerID'
						          AND customer_vehicles.customer_vehicle_id = '$custVehicleID'
						          ")->queryAll();
						          $status = $countCustomer[$c]['status'];
						          if($status == 'Paid'){
						          	$trClass = 'success';
						          } else if($status == 'Partially'){
						          	$trClass = 'warning';
						          } else if ($status == 'Unpaid'){
						          	$trClass = 'danger';
						          }
				              ?>          
							<tr class="<?php echo $trClass; ?>">
								<td><?php echo $c+1; ?></td>
								<td>
									<?php
									 echo $customerInfo[0]['customer_name'];
									 ?>
								</td>
								<td>
									<?php
									 echo $customerInfo[0]['name']." - ".$customerInfo[0]['registration_no'];
									 ?>
								</td>
								<td>
									<?php
									 echo $countCustomer[$c]['net_total'];
									 ?>
								</td>
								<td>
									<?php
									 echo $countCustomer[$c]['paid_amount'];
									 ?>
								</td>
								<td>
									<?php
									 echo $countCustomer[$c]['remaining_amount'];
									 ?>
								</td>
								<td>
									<?php
									 echo $status;
									 ?>
								</td>
							</tr>
							<?php $netTotal += $countCustomer[$c]['net_total'];
								$paidamt += $countCustomer[$c]['paid_amount'];
								$remainAmt += $countCustomer[$c]['remaining_amount'];
								}
							 ?>
							 <tr>
								<td colspan="3" style="text-align: center;background-color:#3C8DBC;color:white;font-weight: bolder;">Total</td>
								<td style="background-color: lightgray;font-weight: bolder;">
									<?php echo $netTotal; ?>
								</td>
								<td style="background-color: lightgray;font-weight: bolder;">
									<?php echo $paidamt; ?>
								</td>
								<td style="background-color: lightgray;font-weight: bolder;">
									<?php echo $remainAmt; ?>
								</td>
								<td style="background-color: lightgray;font-weight: bolder;">
									<?php //echo $creditSum; ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
<?php } ?>
<?php 
if(isset($_GET['serviceID'])){
	$serviceID = $_GET['serviceID'];

	$currentDate = date('Y-m-d');
  	$countWash  = Yii::$app->db->createCommand("
	  SELECT s.service_name,sd.vehicle_type_id,sid.discount_per_service,sih.customer_id,sid.customer_vehicle_id
	  FROM services as s
	  INNER JOIN service_details as sd
	  ON s.service_id = sd.service_id
	  INNER JOIN sale_invoice_detail as sid
	  ON sid.item_id = sd.service_detail_id
	  INNER JOIN sale_invoice_head as sih
	  ON sih.sale_inv_head_id = sid.sale_inv_head_id
	  WHERE s.service_id = '$serviceID'
	  AND sid.item_type = 'Service'
	  AND CAST(sih.date as DATE) = '$currentDate'
	  ")->queryAll();
  	$countwash = count($countWash);

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
					<h3 style="color:#3C8DBC;">
						<a href="./home" class="btn btn-success">
							<i class="glyphicon glyphicon-home"> HOME</i>
						</a>
					Service Category: <b style="color:#000000;"><?php 
					if (!empty($countWash)) {
						echo $countWash[0]['service_name'];
					}
					 ?></b></h3> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered">
						<thead style="background-color:#3C8DBC;color:white;">
							<tr>
								<th>Sr.#</th>
								<th>Customer Name</th>
								<th>Reg.#</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php 
				               $creditSum=0;
				              for ($m=0; $m <$countwash ; $m++) { 
				              $custID = $countWash[$m]['customer_id'];
				              $custVehicleID = $countWash[$m]['customer_vehicle_id'];
				              $washDetails  = Yii::$app->db->createCommand("
					          SELECT customer.customer_name,customer_vehicles.registration_no, vtsc.name
					          FROM customer
					          INNER JOIN customer_vehicles
					          ON customer.customer_id = customer_vehicles.customer_id 
					      		INNER JOIN vehicle_type_sub_category as vtsc
					     		ON customer_vehicles.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id
					          WHERE customer.customer_id = '$custID'
					          AND customer_vehicles.customer_vehicle_id = '$custVehicleID'
					          ")->queryAll();
					          if (!empty($washDetails)) {
					          
				              ?>          
							<tr>
								<td><?php echo $m+1; ?></td>
								<td><?php echo $washDetails[0]['customer_name']; ?></td>
								<td><?php echo $washDetails[0]['name']." - ".$washDetails[0]['registration_no']; ?></td>
								<td><?php echo $countWash[$m]['discount_per_service']; ?></td>
							</tr>
							<?php $creditSum += $countWash[$m]['discount_per_service'];
								  }
								}
							 ?>
							<tr>
								<td colspan="3" style="text-align: center;background-color:#3C8DBC;color:white;font-weight: bolder;">Total</td>
								<td style="background-color: lightgray;font-weight: bolder;">
									<?php echo $creditSum; ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
<?php } ?>

<?php 
if(isset($_GET['polish'])) {
	$currentDate = date('Y-m-d');
  	// counter for WAX
  	$WAX = 2;
  	$countWax  = Yii::$app->db->createCommand("
  	SELECT s.service_name,sd.vehicle_type_id,sih.customer_id,sid.discount_per_service,sid.customer_vehicle_id
  	FROM services as s
  	INNER JOIN service_details as sd
  	ON s.service_id = sd.service_id
  	INNER JOIN sale_invoice_detail as sid
  	ON sid.item_id = sd.service_detail_id
  	INNER JOIN sale_invoice_head as sih
  	ON sih.sale_inv_head_id = sid.sale_inv_head_id
  	WHERE s.service_id = '$WAX'
  	AND sid.item_type = 'Service'
  	AND CAST(date as DATE) = '$currentDate'
  	")->queryAll();
  	$countwax = count($countWax);

  	// counter for interior protection
	$interiorProtection = 3;
	$countInteriorProt  = Yii::$app->db->createCommand("
	SELECT s.service_name,sd.vehicle_type_id,sih.customer_id,sid.discount_per_service,sid.customer_vehicle_id
	FROM services as s
	INNER JOIN service_details as sd
	ON s.service_id = sd.service_id
	INNER JOIN sale_invoice_detail as sid
	ON sid.item_id = sd.service_detail_id
	INNER JOIN sale_invoice_head as sih
	ON sih.sale_inv_head_id = sid.sale_inv_head_id
	WHERE s.service_id = '$interiorProtection'
	AND sid.item_type = 'Service'
	AND CAST(date as DATE) = '$currentDate'
	")->queryAll();
	$countinteriorprot = count($countInteriorProt);

	// counter for engine dressing
	$engineDressing = 4;
	$countEngineDressing  = Yii::$app->db->createCommand("
	SELECT s.service_name,sd.vehicle_type_id,sih.customer_id,sid.discount_per_service,sid.customer_vehicle_id
	FROM services as s
	INNER JOIN service_details as sd
	ON s.service_id = sd.service_id
	INNER JOIN sale_invoice_detail as sid
	ON sid.item_id = sd.service_detail_id
	INNER JOIN sale_invoice_head as sih
	ON sih.sale_inv_head_id = sid.sale_inv_head_id
	WHERE s.service_id = '$engineDressing'
	AND sid.item_type = 'Service'
	AND CAST(date as DATE) = '$currentDate'
	")->queryAll();
	$countenginedressing = count($countEngineDressing);

	// counter for under carriage
	$underCarriage = 9;
	$countUnderCarriage  = Yii::$app->db->createCommand("
	SELECT s.service_name,sd.vehicle_type_id,sih.customer_id,sid.discount_per_service,sid.customer_vehicle_id
	FROM services as s
	INNER JOIN service_details as sd
	ON s.service_id = sd.service_id
	INNER JOIN sale_invoice_detail as sid
	ON sid.item_id = sd.service_detail_id
	INNER JOIN sale_invoice_head as sih
	ON sih.sale_inv_head_id = sid.sale_inv_head_id
	WHERE s.service_id = '$underCarriage'
	AND sid.item_type = 'Service'
	AND CAST(date as DATE) = '$currentDate'
	")->queryAll();
	$countundercarriage = count($countUnderCarriage);
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
					<h3 style="color:#3C8DBC;">
						<a href="./home" class="btn btn-success">
							<i class="glyphicon glyphicon-home"> HOME</i>
						</a>
					Service Category: <b style="color:#000000;">Polish ( <?php echo date('d-m-Y', strtotime($currentDate)); ?> )</b></h3> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="background-color:#FAB61C;text-align: center;">WAX <span style="background-color:#000000;color:white;padding:5px;border-radius:50%;"><?php echo $countwax; ?><span>
								</th>
							</tr>
						</thead>
					</table>	
				</div>
				<div class="col-md-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="background-color:#FAB61C;text-align: center;">Interior Protections <span style="background-color:#000000;color:white;padding:5px;border-radius:50%;"><?php echo $countinteriorprot; ?><span>
								</th>
							</tr>
						</thead>
					</table>	
				</div>
				<div class="col-md-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="background-color:#FAB61C;text-align: center;">Engine Dressing <span style="background-color:#000000;color:white;padding:5px;border-radius:50%;"><?php echo $countenginedressing; ?><span>
								</th>
							</tr>
						</thead>
					</table>	
				</div>
				<div class="col-md-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th style="background-color:#FAB61C;text-align: center;">Under Carriage <span style="background-color:#000000;color:white;padding:5px;border-radius:50%;"><?php echo $countundercarriage; ?><span>
								</th>
							</tr>
						</thead>
					</table>	
				</div>
			</div>
			<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered">
					<thead style="background-color:#3C8DBC;color:white;">
						<tr>
							<!-- <th>Sr.#</th> -->
							<th>Customer Name</th>
							<th>Reg.#</th>
							<th>Ploish Type</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php $creditSum=0;
						// loop for WAX   
			            for ($w=0; $w <$countwax ; $w++) { 
				              $custID = $countWax[$w]['customer_id'];
				              $custVehicleID = $countWax[$w]['customer_vehicle_id'];
				              $waxDetails  = Yii::$app->db->createCommand("
					          SELECT c.customer_name,cv.registration_no, vtsc.name
					          FROM customer as c
					          INNER JOIN customer_vehicles as cv
					          ON c.customer_id = cv.customer_id 
					          INNER JOIN vehicle_type_sub_category as vtsc
					          ON cv.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id 
					          WHERE c.customer_id = '$custID'
					          AND cv.customer_vehicle_id = '$custVehicleID'
					          ")->queryAll();

				          	if (!empty($waxDetails)) { ?>          
								<tr>
									<td><?php echo $waxDetails[0]['customer_name']; ?></td>
									<td><?php echo $waxDetails[0]['name']." - ".$waxDetails[0]['registration_no']; ?></td>
									<td><?php echo $countWax[$w]['service_name']; ?></td>
									<td><?php echo $countWax[$w]['discount_per_service']; ?></td>
								</tr>
						<?php $creditSum += $countWax[$w]['discount_per_service'];
							}
						} 
						// loop for Interior Protection   
			            for ($p=0; $p <$countinteriorprot ; $p++) { 
			              $custID = $countInteriorProt[$p]['customer_id'];
			              $custVehicleID = $countInteriorProt[$p]['customer_vehicle_id'];
			              $interiorDetails  = Yii::$app->db->createCommand("
				          SELECT customer.customer_name,customer_vehicles.registration_no, vtsc.name
				          FROM customer
				          INNER JOIN customer_vehicles
				          ON customer.customer_id = customer_vehicles.customer_id 
					      INNER JOIN vehicle_type_sub_category as vtsc
					      ON customer_vehicles.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id 
				          WHERE customer.customer_id = '$custID'
				          AND customer_vehicles.customer_vehicle_id = '$custVehicleID'
				          ")->queryAll();
				          	if (!empty($interiorDetails)) { ?>          
								<tr>
									<td><?php echo $interiorDetails[0]['customer_name']; ?></td>
									<td><?php echo $interiorDetails[0]['name']." - ".$interiorDetails[0]['registration_no']; ?></td>
									<td><?php echo $countInteriorProt[$p]['service_name']; ?></td>
									<td><?php echo $countInteriorProt[$p]['discount_per_service']; ?></td>
								</tr>
						<?php $creditSum += $countInteriorProt[$p]['discount_per_service'];
							}
						} 
						// loop for Engine Dressing   
			            for ($e=0; $e <$countenginedressing ; $e++) { 
			              $custID = $countEngineDressing[$e]['customer_id'];
			              $custVehicleID = $countEngineDressing[$e]['customer_vehicle_id'];
			              $engineDressingDetails  = Yii::$app->db->createCommand("
				          SELECT customer.customer_name,customer_vehicles.registration_no, vtsc.name
				          FROM customer
				          INNER JOIN customer_vehicles
				          ON customer.customer_id = customer_vehicles.customer_id 
					      INNER JOIN vehicle_type_sub_category as vtsc
					      ON customer_vehicles.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id 
				          WHERE customer.customer_id = '$custID'
				          AND customer_vehicles.customer_vehicle_id = '$custVehicleID'
				          ")->queryAll();

				          if (!empty($engineDressingDetails)) { ?>          
								<tr>
									<td><?php echo $engineDressingDetails[0]['customer_name']; ?></td>
									<td><?php echo $engineDressingDetails[0]['name']." - ".$engineDressingDetails[0]['registration_no']; ?></td>
									<td><?php echo $countEngineDressing[$e]['service_name']; ?></td>
									<td><?php echo $countEngineDressing[$e]['discount_per_service']; ?></td>
								</tr>
						<?php $creditSum += $countEngineDressing[$e]['discount_per_service'];
							} 
						}
						// loop for Under Carriage   
			            for ($u=0; $u <$countundercarriage ; $u++) { 
			              $custID = $countUnderCarriage[$u]['customer_id'];
			              $custVehicleID = $countUnderCarriage[$u]['customer_vehicle_id'];
			              $underCarriageDetails  = Yii::$app->db->createCommand("
				          SELECT customer.customer_name,customer_vehicles.registration_no, vtsc.name
				          FROM customer
				          INNER JOIN customer_vehicles
				          ON customer.customer_id = customer_vehicles.customer_id 
					      INNER JOIN vehicle_type_sub_category as vtsc
					      ON customer_vehicles.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id 
				          WHERE customer.customer_id = '$custID'
				          AND customer_vehicles.customer_vehicle_id = '$custVehicleID'
				          ")->queryAll();
				         	if (!empty($underCarriageDetails)) { ?>          
								<tr>
									<td><?php echo $underCarriageDetails[0]['customer_name']; ?></td>
									<td><?php echo $underCarriageDetails[0]['name']." - ".$underCarriageDetails[0]['registration_no']; ?></td>
									<td><?php echo $countUnderCarriage[$u]['service_name']; ?></td>
									<td><?php echo $countUnderCarriage[$u]['discount_per_service']; ?></td>
								</tr>
						<?php $creditSum += $countUnderCarriage[$u]['discount_per_service'];
							}
						} ?>

						<tr>
							<td colspan="3" style="text-align: center;background-color:#3C8DBC;color:white;font-weight: bolder;">Total</td>
							<td style="background-color: lightgray;font-weight: bolder;">
								<?php echo $creditSum; ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<?php } ?>