<?php 
	if(isset($_GET['creditInvoice'])){
	$creditInvoicesDetails  = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head as sih
    WHERE sih.status != 'Paid'
    ORDER BY CAST(date AS DATE) DESC
    ")->queryAll();
    $count = count($creditInvoicesDetails);


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="font-family:verdana;">
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
</body>
</html>
<?php } ?>