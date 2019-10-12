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
	  AND CAST(date as DATE) = '$currentDate'
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
			Service Category: <b style="color:#000000;"><?php //echo $serviceName[0]['name']; ?></b></h3> 
		</div>
	</div>
	<div class="row">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Sr.#</th>
					<th>Customer Name</th>
					<th>Reg.#</th>
				</tr>
			</thead>
			<tbody>
				<?php 
	               
	              for ($m=0; $m <$countwash ; $m++) { 
	              $custID = $countWash[$m]['customer_id'];
	              $custVehicleID = $countWash[$m]['customer_vehicle_id'];
	              $washDetails  = Yii::$app->db->createCommand("
		          SELECT customer.customer_name,customer_vehicles.registration_no
		          FROM customer
		          INNER JOIN customer_vehicles
		          ON customer.customer_id = customer_vehicles.customer_id 
		          WHERE customer.customer_id = '$custID'
		          AND customer_vehicles.customer_vehicle_id = '$custVehicleID'
		          ")->queryAll();
	              ?>          
				<tr>
					<td><?php echo $m+1; ?></td>
					<td><?php echo $washDetails[0]['customer_name']; ?></td>
					<td><?php echo $washDetails[0]['registration_no']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
</body>
</html>
<?php } ?>