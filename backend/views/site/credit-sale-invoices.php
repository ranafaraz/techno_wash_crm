<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
	if(isset($_GET['creditInvoice'])){
		$this->title = "Credit Invoices";
		$this->params['breadcrumbs'][] = $this->title;
		$creditInvoicesDetails  = Yii::$app->db->createCommand("
	    SELECT *
	    FROM sale_invoice_head as sih
	    WHERE sih.status != 'Paid' AND sih.net_total != 0
	    ORDER BY CAST(date AS DATE) DESC
	    ")->queryAll();
	    $count = count($creditInvoicesDetails); ?>
		<div class="container-fluid">
			<div class="row" style="border: 2px solid; border-radius: 10px;">
				<div class="col-md-12">
					<img src="images/technowash_logo.png" width="" style="margin-left: 33%;">
					<p style="text-align: center;">
						Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur <br>	
						Contact #: +92 (300) 0600106<br>https://www.technowashbwp.pk
					</p>
				</div>
			</div>
		</div><br>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th colspan="7" style="background-color: black !important;">
										<h4 style="font-family: georgia; text-align: center;">
											
												<b style="color: white !important; text-align: center !important;">CREDIT INVOICES</b>
											
										</h4>
									</th>
								</tr>
								<tr>
									<th>Sr.#</th>
									<th>Customer</th>
									<th>Vehicle No.</th>
									<th class="text-center">Date</th>
									<th class="text-center">Total</th>
									<th class="text-center">Paid</th>
									<th class="text-center">Remaining</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$netTotal = $paidTotal = $remainingTotal = 0;
								for ($i=0; $i <$count ; $i++) { 
									$customerID = $creditInvoicesDetails[$i]['customer_id'];
									$sale_inv_head_id = $creditInvoicesDetails[$i]['sale_inv_head_id'];
									// customer vehicle info
									$saledetails  = Yii::$app->db->createCommand("
									  	SELECT customer_vehicle_id FROM sale_invoice_detail 
									  	WHERE sale_inv_head_id = '$sale_inv_head_id'
									  	")->queryAll();
									//var_dump($saledetails);
									//$custVehicleID = $saledetails[0]['customer_vehicle_id'];
									// AND customer_vehicles.customer_vehicle_id = '$custVehicleID'
						            $customerDetail  = Yii::$app->db->createCommand("
							        	SELECT customer.customer_name,customer_vehicles.registration_no, vtsc.name
								       	FROM customer INNER JOIN customer_vehicles
							          	ON customer.customer_id = customer_vehicles.customer_id 
							      		INNER JOIN vehicle_type_sub_category as vtsc
							     		ON customer_vehicles.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id
							          	WHERE customer.customer_id = '$customerID'")->queryAll();
								?>
								<tr>
									<td><?php echo $i+1; ?></td>
									<td><?php echo $customerDetail[0]['customer_name']; ?></td>
									<td>
										<?php 
											echo $customerDetail[0]['name']." - ".$customerDetail[0]['registration_no'];
										?>
									</td>
									<td class="text-center">
										<?php 
											$date = date('d-M-y',strtotime($creditInvoicesDetails[$i]['date']));
											echo $date;
										?>
									</td>
									<td class="text-center">
										<?php 
											echo $creditInvoicesDetails[$i]['net_total'];
										?>
									</td>
									<td class="text-center">
										<?php 
											echo $creditInvoicesDetails[$i]['paid_amount'];
										?>
									</td>
									<td class="text-center">
										<?php 
											$netTotal += $creditInvoicesDetails[$i]['net_total'];
											$paidTotal += $creditInvoicesDetails[$i]['paid_amount'];
											$remainingTotal += $creditInvoicesDetails[$i]['remaining_amount'];
											echo $creditInvoicesDetails[$i]['remaining_amount'];
										?>
									</td>
								</tr>
								<?php } ?>
								<tr>
									<td colspan="4" style="text-align: center;background-color:black !important; color: white !important; font-weight: bolder;">Total</td>
									<td style="background-color: black !important; color: white !important;font-weight: bolder;" class="text-center">
										<?php echo number_format($netTotal); ?>
									</td>
									<td style="background-color: black !important; color: white !important;font-weight: bolder;" class="text-center">
										<?php echo number_format($paidTotal); ?>
									</td>
									<td style="background-color: black !important; color: white !important;font-weight: bolder;" class="text-center">
										<?php echo number_format($remainingTotal); ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
<?php } 
else if(isset($_GET['debitInvoice'])){
	$this->title = "Debit Invoices";
	$this->params['breadcrumbs'][] = $this->title;
	$debitInvoicesDetails  = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice as pi
    WHERE pi.status != 'Paid'
    ORDER By purchase_date DESC
    ")->queryAll();
    $countdebit = count($debitInvoicesDetails);
    ?>
	<div class="container-fluid">
		<div class="row" style="border: 2px solid; border-radius: 10px;">
			<div class="col-md-12">
				<img src="images/technowash_logo.png" width="" style="margin-left: 36%;">
				<p style="text-align: center;">
					Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur <br>	
					Contact #: +92 (300) 0600106<br>https://www.technowashbwp.pk
				</p>
			</div>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered">
						<thead">
							<tr>
								<th colspan="7" style="background-color: black !important;">
									<h4 style="font-family: georgia; text-align: center;">
										<b style="color: white !important; text-align: center !important;">DEBIT INVOICES</b>
									</h4>
								</th>
							</tr>
							<tr>
								<th class="text-center">Sr.#</th>
								<th>Vendor Name</th>
								<th class="text-center">Bill No.</th>
								<th class="text-center">Date</th>
								<th class="text-center">Total</th>
								<th class="text-center">Paid</th>
								<th class="text-center">Remaining</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$netTotalDebit = $paidTotalDebit = $remainingDebit = 0;
							for ($i=0; $i <$countdebit ; $i++) { 
								$vendorID = $debitInvoicesDetails[$i]['vendor_id'];
								$venodrDetail  = Yii::$app->db->createCommand("
							    SELECT *
							    FROM vendor
							    WHERE vendor_id = '$vendorID'
							    ")->queryAll();
							?>
							<tr>
								<th class="text-center"><?php echo $i+1; ?></th>
								<td><?php echo $venodrDetail[0]['name']; ?></td>
								<td class="text-center"><?php echo $debitInvoicesDetails[$i]['bill_no']; ?></td>
								<td class="text-center">
									<?php 
									$date = date('d-M-y',strtotime($debitInvoicesDetails[$i]['purchase_date']));
									echo $date;
									?>
								</td>
								<td class="text-center"><?php echo $debitInvoicesDetails[$i]['net_total']; ?></td>
								<td class="text-center"><?php echo $debitInvoicesDetails[$i]['paid_amount']; ?></td>
								
								<td class="text-center">
									<?php 
										$netTotalDebit += $debitInvoicesDetails[$i]['net_total'];
										$paidTotalDebit += $debitInvoicesDetails[$i]['paid_amount'];
										$remainingDebit += $debitInvoicesDetails[$i]['remaining_amount'];
										echo $debitInvoicesDetails[$i]['remaining_amount'];
									?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="4" style="text-align: center; background-color:black !important; color:white !important; font-weight: bolder;">Total</td>
								<td style="background-color: black !important; color: white !important;font-weight: bolder;" class="text-center">
									<?php echo number_format($netTotalDebit); ?>
								</td>
								<td style="background-color: black !important; color: white !important;font-weight: bolder;" class="text-center">
									<?php echo number_format($paidTotalDebit); ?>
								</td>
								<td style="background-color: black !important; color: white !important;font-weight: bolder;" class="text-center">
									<?php echo number_format($remainingDebit); ?>
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