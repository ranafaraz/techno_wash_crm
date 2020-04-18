<?php 

if(isset($_GET['service_id']))
{

	$serviceID = $_GET['service_id'];
	$vehicleTypeID = $_GET['vehicleType_id'];

	$serviceName = Yii::$app->db->createCommand("
	SELECT *
	FROM services
	WHERE service_id = $serviceID")->queryAll();

	$services = Yii::$app->db->createCommand("
	SELECT *
	FROM services")->queryAll();
	$count_setrvices =  count($services);

	$services_details = Yii::$app->db->createCommand("
	SELECT *
	FROM service_details
	WHERE service_id = '$serviceID'
	AND vehicle_type_id = '$vehicleTypeID '")->queryAll();
	$countservices_details =  count($services_details);

	$servicesDetailID = $services_details[0]['service_detail_id'];

	$vehicleTypeData = Yii::$app->db->createCommand("
	SELECT *
	FROM vehicle_type
	")->queryAll();
	$countvehicleType = count($vehicleTypeData);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Service</title>
</head>
<body>
	<div class="container-fluid">
		<form method="post">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-default" style="padding:10px;">
					<p style="font-weight:bolder;background-color:#d2d6de;padding:5px;text-align: center;color:#000000;font-size:15px;">Update Service Details<br>( <?php echo $serviceName[0]['service_name'];?> )
					</p>
					<div class="form-group">
		 				<label>Vehicle Type</label>
		        		<select class="form-control" name="vehicleType">
		        			<?php 
		        			for ($i=0; $i <$countvehicleType ; $i++) {
		        			?>
		        			<option <?php if ($vehicleTypeData[$i]['vehical_type_id'] == $vehicleTypeID ) {
		        				echo "selected";
		        			} ?> value="<?php echo $vehicleTypeData[$i]['vehical_type_id']; ?>"><?php echo $vehicleTypeData[$i]['name']; ?>
		        			</option>
		        			<?php } ?>
		        		</select>
			    	</div>
			    	<div class="form-group">
		    			<label>Price</label>
		    			<input type="text" name="price" class="form-control" value="<?php echo $services_details[0]['price']?>">
			    	</div>
			    	<div class="form-group">
		    			<label>Description</label>
		    			<input type="text" name="description" class="form-control" value="<?php echo $services_details[0]['description'];?>">
			    	</div>
          			<input type="hidden" name="service_ID" class="form-control" value="<?php echo $serviceID; ?>">
          			<input type="hidden" name="vehicle_ID" class="form-control" value="<?php echo $vehicleTypeID; ?>">
          			<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
					<button name="update_service" class="btn btn-info btn-xs">
						<i class="glyphicon glyphicon-edit"></i><b> &nbsp;Update</b>
					</button>
					<a href="./service-detail-view?id=<?php echo $serviceID;?>" class="btn btn-danger btn-xs">
			      		<i class="glyphicon glyphicon-backward"></i><b> &nbsp;Back</b>
					</a>
				</div>
			</div>
		</div>
		</form>
	</div>
</body>
</html>

<?php 
}
if(isset($_POST['update_service']))
 { 
	
	
	$updatevehicleType  = $_POST['vehicleType'];
	//$updateserviceName  = $_POST['Service_Name'];
	$updateprice 		= $_POST['price'];
	$updatedescription	= $_POST['description'];
	$service_ID			= $_POST['service_ID'];
	$vehicle_ID			= $_POST['vehicle_ID'];
	$user_id   			= Yii::$app->user->identity->id;

    $transaction 		= \Yii::$app->db->beginTransaction();
     try {
     	// Checking the service detail id
		$checkServiceDetailId = Yii::$app->db->createCommand("
		SELECT *
		FROM  service_details
		WHERE vehicle_type_id = $updatevehicleType
		AND service_id = $service_ID
		")->queryAll();
		//$vtID = $checkServiceDetailId[0]['vehicle_type_id'];
		if ($checkServiceDetailId) {
			Yii::$app->session->setFlash('danger', "Vehicle Type already exists");
			//echo "no yeh wrong hhhhhhhh";
		}else{
			$checkServiceDetailId2 = Yii::$app->db->createCommand("
			SELECT *
			FROM  service_details
			WHERE vehicle_type_id = $vehicle_ID
			AND service_id = $service_ID
			")->queryAll();
			$serDetailId = $checkServiceDetailId2[0]['service_detail_id'];
			$updateServiceDetails = Yii::$app->db->createCommand()->update('service_details',[
					'vehicle_type_id' 	=> $updatevehicleType,
				    //'service_id' 		=> $updateserviceName,
				    'price'   			=> $updateprice,
				    'description'  		=> $updatedescription,
				    'updated_at' 		=> new \yii\db\Expression('NOW()'),
					'updated_by' 		=> $user_id,
		    ],[	'service_detail_id' 	=> $serDetailId]
			)->execute();
			// transaction commit
	     $transaction->commit();
	     \Yii::$app->response->redirect(['./service-detail-view', 'id' => $service_ID]);
		}
		// else{
		// 	 $insert_serviceDetail = Yii::$app->db->createCommand()->insert('service_details',[

		// 	    'branch_id' 		=> Yii::$app->user->identity->branch_id,
		// 	    'vehicle_type_id' 	=> $updatevehicleType,
		// 	    'service_id' 		=> $updateserviceName,
		// 	    'price' 			=> $updateprice,
		// 	    'description' 		=> $updatedescription,
		// 	    'created_at' 		=> new \yii\db\Expression('NOW()'),
		// 		'created_by' 		=> $user_id ,
		// 	  ]
		// 	)->execute();
		// }
	     } // closing of try block 
	     catch (Exception $e) {
	     	Yii::$app->session->setFlash('danger', (string)$e);
	      // transaction rollback
	         $transaction->rollback();
	     } // closing of catch block
	     //closing of transaction handling
}

 ?>

 <?php 
 if(isset($_GET['serviceID']))
{
	$servID = $_GET['serviceID'];
	$services = Yii::$app->db->createCommand("
	SELECT *
	FROM services
	WHERE service_id = '$servID'")->queryAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div class="container-fluid">
		<form method="post">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-default" style="padding:10px;">
					<p style="font-weight:bolder;background-color:#d2d6de;padding:5px;text-align: center;color:#000000;font-size:15px;">Update Service<br>( <?php echo $services[0]['service_name'];?> )
					</p>
					<div class="form-group">
						<label>Service</label>
						<input type="text" name="serviceName" class="form-control" value="<?php echo $services[0]['service_name'];?>">
						<label>Description</label>
						<input type="text" name="description" class="form-control" value="<?php echo $services[0]['description'];?>">
						<input type="hidden" name="serviceId" value="<?php echo $services[0]['service_id'];?>">
					</div>
					<button name="serviceUpdate" class="btn btn-info btn-xs">
						<i class="glyphicon glyphicon-edit"></i><b> &nbsp;Update</b>
					</button>
					<a href="./service-detail-view?id=<?php echo $servID;?>" class="btn btn-danger btn-xs">
			      		<i class="glyphicon glyphicon-backward"></i><b> &nbsp;Back</b>
					</a>
				</div>
			</div>
		</div>
		</form>
	</div>
</body>
</html>
<?php } 

	if(isset($_POST['serviceUpdate'])){
		$serviceName = $_POST['serviceName'];
		$description = $_POST['description'];
		$serviceId 	 = $_POST['serviceId'];
		$user_id   			= Yii::$app->user->identity->id;

		// starting of transaction handling
		$transaction = \Yii::$app->db->beginTransaction();
		try {
			$update_service_name = Yii::$app->db->createCommand()->update('services',[

			    'service_name' 		=> $serviceName,
			    'description' 		=> $description,
			    'updated_at' 		 => new \yii\db\Expression('NOW()'),
				'updated_by' 		 => $user_id ,

			  ],['service_id' => $serviceId]
			)->execute();
        // transaction commit
        $transaction->commit();
        \Yii::$app->response->redirect(['./service-detail-view','id' => $serviceId]);
		} // closing of try block 
		catch (Exception $e) {
			// transaction rollback
            $transaction->rollback();
		} // closing of catch block
		// closing of transaction handling
	}
?>