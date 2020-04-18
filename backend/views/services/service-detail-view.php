<?php 
	$service_id = $_GET["id"];
	

	$services = Yii::$app->db->createCommand("
		SELECT s.*,sd.*
		FROM services as s
		INNER JOIN service_details as sd
		ON s.service_id = sd.service_id
		WHERE s.service_id = '$service_id'")->queryAll();
	$count_setrvices =  count($services);
	// echo $count_setrvices;
	//$this->title = 'Service Details';
	//$this->params['breadcrumbs'][] = $this->title;
	?>

<!DOCTYPE html>
<html>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="margin-top:0px">
				<h3 style="color:;">
			      	<a href="./services" class="btn btn-danger btn-xs" style="padding-bottom:4px;">
			      		<i class="glyphicon glyphicon-backward"> <b>Back</b></i>
					</a>
							<?php echo "Service Details: ".$services[0]['service_name']; ?>
					<a href="./update-service?serviceID=<?php echo $service_id;?>"  style="padding-bottom:4px;">
			      		<i class="glyphicon glyphicon-edit"style="color:#00c0ef;font-size:25px;"></i>
					</a>
			      	<!-- <a href="./update-stock" class="btn btn-info btn-xs" style="">
							<i class="glyphicon glyphicon-edit"></i>  Update Stock
						</a> -->
			    </h3>
				<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="background-color: #367FA9;color: #fff;">Sr.#</th>
							<th style="background-color: #367FA9;color: #fff;">Vehicle Type</th>
							<th style="background-color: #367FA9;color: #fff;">Price</th>
							<th style="background-color: #367FA9;color: #fff;">Action</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
							for ($i=0; $i <$count_setrvices ; $i++) { 
									$vehicle_type_id = $services[$i]['vehicle_type_id'];
									$vehicle_type_name = Yii::$app->db->createCommand("
										SELECT name	
										FROM vehicle_type 
										WHERE vehical_type_id = '$vehicle_type_id'")->queryAll();

								?>
								<tr>
									<td><?php echo $i+1;?></td>
									<td><?php echo $vehicle_type_name[0]['name'];?></td>
									<td><?php echo $services[$i]['price'];?></td>
									<td><a href="./update-service?service_id=<?=$services[$i]['service_id']?>&vehicleType_id=<?=$vehicle_type_id?>" class="label label-info" title="Edit"><i class="fa fa-edit"></i> Update</a></td>

								</tr>
						<?php	}

						?>
					</tbody>
				</table>
			  </div>
			</div>
		</div>
	</div>
</body>
</html>
