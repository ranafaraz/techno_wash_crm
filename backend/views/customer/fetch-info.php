<?php 
	if(isset($_POST['barcode'])){
	$barcode = $_POST['barcode'];

 	$Fetch_info = Yii::$app->db->createCommand("SELECT * FROM stock WHERE barcode = '$barcode'")->queryAll();
 	echo json_encode($Fetch_info);
 	}


 	if(isset($_POST['serviceID']))
 	{
 		 $serviceID = $_POST['serviceID'];
 		 // getting services amount
		$services = Yii::$app->db->createCommand("
	    SELECT price,name
	    FROM services
	    WHERE services_id = $serviceID
	    ")->queryAll();

	   echo json_encode($services); 
 	}

 	
 	if (isset($_POST["vehicle"])) {
 		$vehicle=$_POST["vehicle"];
 		$register = Yii::$app->db->createCommand("
	    SELECT 	registration_no
	    FROM customer_vehicles
	    WHERE 	customer_vehicle_id = $vehicle
	    ")->queryAll();
 		   echo json_encode($register); 
 	}
 	if (isset($_POST["vehicleArray"]) && isset($_POST["serviceArray"])
 		&& isset($_POST["amountArray"]) && isset($_POST["discountArray"]) && isset($_POST["invoice_id"])) {


 		$invoice_id			=$_POST["invoice_id"];
 		$vehicleArray		=$_POST["vehicleArray"];
 		$serviceArray		=$_POST["serviceArray"];
 		$amountArray		=$_POST["amountArray"];
 		$discountArray 		=$_POST["discountArray"];
 		//$afterDiscountArray	=$_POST["afterDiscountArray"];
 		$countvehicle 		= count($vehicleArray);

 		for ($i=0; $i <$countvehicle ; $i++) {

	 		$insert = Yii::$app->db->createCommand()->insert(

	 			'sale_invoice_services_detail',
	 			[
	 				'sale_inv_haed_id' 		=> $invoice_id,
	 				'services_id' 			=> $serviceArray[$i],
	 				'customer_vehicle_id' 	=> $vehicleArray[$i],
	 				'discount_per_service' 	=> $discountArray[$i],
	 				'created_at' 			=> new \yii\db\Express('NOW()'),
	 				'created_by'			=> Yii::$app->user->identity->id,
	 			]
	 		)->queryAll();
 		}

 		
 		   echo json_encode($insert); 
 	}
	
	if(isset($_POST['barcode']))
 	{
 		 $barcode = $_POST['barcode'];
 		 // getting services amount
		$stock = Yii::$app->db->createCommand("
	    SELECT *
	    FROM stock
	    WHERE barcode = '$barcode'
	    ")->queryAll();

	   echo json_encode($stock); 
 	}
 	if (isset($_POST["invoice_date"]) && isset($_POST["customer_id"]) && isset($_POST["vehicleArray"])&& isset($_POST["serviceArray"])&& isset($_POST["amountArray"])&& isset($_POST["ItemTypeArray"])&& isset($_POST["ItemTypeArray"])&& isset($_POST["total_amount"])&& isset($_POST["net_total"])&& isset($_POST["paid"])&& isset($_POST["remaining"])&& isset($_POST["status"])){
customer_id,
vehicleArray,
serviceArray,
amountArray,
ItemTypeArray,
total_amount,
net_total,
paid,
remaining,
status
 	}

?>