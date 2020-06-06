<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="font-family:verdana;">
	<?php 
	if(isset($_GET['creditInvoice'])){

		$creditInvoicesDetails  = Yii::$app->db->createCommand("
	    SELECT *
	    FROM sale_invoice_head as sih
	    WHERE sih.status != 'Paid'
	    ORDER BY CAST(date AS DATE) DESC
	    ")->queryAll();
	    $count = count($creditInvoicesDetails); ?>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h3 style="color:#3C8DBC;">
						<a href="./home" class="btn btn-success">
							<i class="glyphicon glyphicon-home"> HOME</i>
						</a>
					Credit Invoices <b style="color:#000000;"><?php //echo $serviceName[0]['name']; ?></b></h3> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<table class="table table-bordered">
								<thead style="background-color:#3C8DBC;color:white;">
									<tr>
										<th>Sr.#</th>
										<th>Customer Name</th>
										<th>Date</th>
										<th>Remaining Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$creditSum = 0;
									for ($i=0; $i <$count ; $i++) { 
										$custID = $creditInvoicesDetails[$i]['customer_id'];
										$customerDetail  = Yii::$app->db->createCommand("
									    SELECT *
									    FROM customer
									    WHERE customer_id = '$custID'
									    ")->queryAll();
									?>
									<tr>
										<td><?php echo $i+1; ?></td>
										<td><?php echo $customerDetail[0]['customer_name']; ?></td>
										<td>
											<?php 
											$date = date('d-M-y',strtotime($creditInvoicesDetails[$i]['date']));
											echo $date;
											?>
										</td>
										<td>
											<?php 
											$creditSum += $creditInvoicesDetails[$i]['remaining_amount'];
											echo $creditInvoicesDetails[$i]['remaining_amount'];
											?>
										</td>
									</tr>
									<?php } ?>
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
			</div>
		</div>

<?php } 
else if(isset($_GET['debitinvoice'])){
	$debitInvoicesDetails  = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice as pi
    WHERE pi.status != 'Paid'
    
    ")->queryAll();
    $countdebit = count($debitInvoicesDetails);
    ?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h3 style="color:#3C8DBC;">
				<a href="./home" class="btn btn-success">
					<i class="glyphicon glyphicon-home"> HOME</i>
				</a>
			Debit  Invoices <b style="color:#000000;"><?php //echo $serviceName[0]['name']; ?></b></h3> 
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered">
						<thead style="background-color:#3C8DBC;color:white;">
							<tr>
								<th>Sr.#</th>
								<th>Vendor Name</th>
								<th>Date</th>
								<th>Remaining Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$debitSum = 0;
							for ($i=0; $i <$countdebit ; $i++) { 
								$vendorID = $debitInvoicesDetails[$i]['vendor_id'];
								$venodrDetail  = Yii::$app->db->createCommand("
							    SELECT *
							    FROM vendor
							    WHERE vendor_id = '$vendorID'
							    ")->queryAll();
							?>
							<tr>
								<td><?php echo $i+1; ?></td>
								<td><?php echo $venodrDetail[0]['name']; ?></td>
								<td>
									<?php 
									$date = date('d-M-y',strtotime($debitInvoicesDetails[$i]['purchase_date']));
									echo $date;
									?>
								</td>
								<td>
									<?php 

									$debitSum += $debitInvoicesDetails[$i]['remaining_amount'];
									echo $debitInvoicesDetails[$i]['remaining_amount'];
									?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="3" style="text-align: center;background-color:#3C8DBC;color:white;font-weight: bolder;">Total</td>
								<td style="background-color: lightgray;font-weight: bolder;">
									<?php echo $debitSum; ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } 

else if(isset($_GET['creditInvoiceDaily'])){
		$currentDate = date('Y-m-d');

		$creditInvoicesDetails  = Yii::$app->db->createCommand("
	    SELECT sih.*
	    FROM sale_invoice_head as sih
	    WHERE sih.status != 'Paid'
	    AND CAST(date AS DATE) = '$currentDate'
	    ")->queryAll();
	    $count = count($creditInvoicesDetails); ?>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h3 style="color:#3C8DBC;">
						<a href="./home" class="btn btn-success">
							<i class="glyphicon glyphicon-home"> HOME</i>
						</a>
					Credit Invoices <b style="color:#000000;">( <?php echo date('d-m-Y', strtotime($currentDate)); ?> )</b></h3> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<table class="table table-bordered">
								<thead style="background-color:#3C8DBC;color:white;">
									<tr>
										<th>Sr.#</th>
										<th>Customer Name</th>
										<th>Vehicle</th>
										<th>Remaining Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$creditSum = 0;
									for ($i=0; $i <$count ; $i++) { 
										$sihID = $creditInvoicesDetails[$i]['sale_inv_head_id'];
										$custID = $creditInvoicesDetails[$i]['customer_id'];

										$cvID = Yii::$app->db->createCommand("
									    SELECT sid.customer_vehicle_id
									    FROM sale_invoice_detail as sid
									    WHERE sid.sale_inv_head_id = '$sihID'
									    ")->queryAll();

										$custvehID = $cvID[0]['customer_vehicle_id'];
										$customerDetail  = Yii::$app->db->createCommand("
									    SELECT c.customer_name,cv.registration_no, vtsc.name
								          FROM customer as c
								          INNER JOIN customer_vehicles as cv
								          ON c.customer_id = cv.customer_id 
								          INNER JOIN vehicle_type_sub_category as vtsc
								          ON cv.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id 
								          WHERE c.customer_id = '$custID'
								          AND cv.customer_vehicle_id = '$custvehID'
									    ")->queryAll();
									?>
									<tr>
										<td><?php echo $i+1; ?></td>
										<td><?php echo $customerDetail[0]['customer_name']; ?></td>
										<td><?php echo $customerDetail[0]['name']." - ".$customerDetail[0]['registration_no']; ?></td>
										<td>
											<?php 
											$creditSum += $creditInvoicesDetails[$i]['remaining_amount'];
											echo $creditInvoicesDetails[$i]['remaining_amount'];
											?>
										</td>
									</tr>
									<?php } ?>
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
			</div>
		</div>

<?php } ?>
</body>
</html>