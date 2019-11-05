<?php 

$serviceID = $_GET['service_id'];
$vehicleTypeID = $_GET['vehicleType_id'];

$services = Yii::$app->db->createCommand("
		SELECT *
		FROM services
		WHERE service_id = '$serviceID'")->queryAll();
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

	<div class="container">
		<div class="row">
 		<div class="col-md-8 col-md-offset-2" style="text-align: center;font-family:georgia;color: #367FA9; font-size: 32px;">
 			<span>Update Service (<b><?=$services[0]['service_name']?></b>)</span>
 		</div>	
 	</div>
	
	<form action="" method="POST">
		<div class="row">
		   <div class="col-md-8 col-md-offset-2" style="background-color:#efefef;border-top:3px solid #367FA9;">
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-4">
			 			<div class="form-group">
			        		<label>Service Name</label>
			        		<input type="text" class="form-control" name="Service_Name" value="<?=$services[0]['service_name']?>">
			    		</div>
			 		</div>
					<div class="col-md-4">
			 			<div class="form-group">
			 				<label>Select Vehicle Type</label>
			        		<select class="form-control" name="vehicleType">
			        			<option value="">Select vehicle type</option>
			        			<?php 
			        			for ($i=0; $i <$countvehicleType ; $i++) {
			        			?>
			        			<option <?php if ($vehicleTypeData[$i]['vehical_type_id'] == $vehicleTypeID ) {
			        				echo "selected";
			        			} ?> value="<?php echo $vehicleTypeData[$i]['vehical_type_id']; ?>"><?php echo $vehicleTypeData[$i]['name']; ?></option>
			        			<?php } ?>
			        		</select>
			    		</div>
			    	</div>
			    	<div class="col-md-4">
			    		<div class="form-group">
			    			<label>Price</label>
			    			<input type="text" name="price" class="form-control" value="<?=$services_details[0]['price']?>">
			    		</div>
			    	</div>
			    	<input type="hidden" name="vehicleTypeId" class="form-control" value="<?=$vehicleTypeID?>"> 
          			<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
          			<input type="hidden" name="serviceid" class="form-control" value="<?=$serviceID?>">
          			<input type="hidden" name="serviceDetailid" class="form-control" value="<?=$servicesDetailID?>">
		    </div>
		    <div class="row">
		    	<div class="col-md-2" style="margin-left: 20px;">
				<div class="form-group">
			 	<a href="./service-detail-view?id=<?=$serviceID?>" class="form-control btn btn-danger">
			      	<i class="glyphicon glyphicon-backward"> <b>Back</b></i>
				</a>
				</div>		
			</div> 
			<div class="col-md-4">
				<button type="submit" name="update_service" id="update" class="btn btn-success"><i class="glyphicon glyphicon-open"></i> Update Service</button>		
			</div>
		    </div>
		  </div>
		</div>
	</form>

	</div>
</body>
</html>

<?php 

if(isset($_POST['update_service']))
 { 
	$vehicleTypeId  	= $_POST['vehicleTypeId'];
	$serviceid  		= $_POST['serviceid'];
	$serviceDetailid  	= $_POST['serviceDetailid'];
	$updateserviceName  = $_POST['Service_Name'];
	$updatevehicleType  = $_POST['vehicleType'];
	$updateprice 		= $_POST['price'];
	$user_id   			= Yii::$app->user->identity->id;

     $transaction 		= \Yii::$app->db->beginTransaction();
     try {
      $update_service = Yii::$app->db->createCommand()->update('service_details',[
     'vehicle_type_id'   => $updatevehicleType,
     'price'        	 => $updateprice,
     'updated_at' 		 => new \yii\db\Expression('NOW()'),
	 'updated_by' 		 => $user_id ,
    ], 
		['service_detail_id' => $serviceDetailid]
	)->execute();

    $update_service_name = Yii::$app->db->createCommand()->update('services',[

    'service_name' 		=> $updateserviceName,
    'updated_at' 		 => new \yii\db\Expression('NOW()'),
	'updated_by' 		 => $user_id ,

  ], 
		['service_id' => $serviceid]
	)->execute();

     // transaction commit
     $transaction->commit();
     \Yii::$app->response->redirect(['./service-detail-view', 'id' => $serviceid]);
    
        
     } // closing of try block 
     catch (Exception $e) {
     	Yii::$app->session->setFlash('danger', (string)$e);
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
		}
 ?>