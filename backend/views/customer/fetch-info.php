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

 	 if(isset($_POST['invoice_date']) && isset($_POST['customer_id'])
 	  && isset($_POST['total_amount']) && isset($_POST['net_total']) 
 	  && isset($_POST['paid']) && isset($_POST['remaining'])
 	 && isset($_POST['status']) && isset($_POST['vehicleArray'])
 	   && isset($_POST['serviceArray']) && isset($_POST['amountArray'])
 	    && isset($_POST['ItemTypeArray']))
 	{
 		$total_amount = $_POST["total_amount"];
 		$invoice_date= $_POST["invoice_date"];
	 	$customer_id= $_POST['customer_id'];
		$net_total = $_POST['net_total'];
		$paid = $_POST['paid'];
		$remaining = $_POST['remaining'];
		$status = $_POST["status"];
		$vehicleArray = $_POST['vehicleArray']; 
		$serviceArray = $_POST["serviceArray"];
		$amountArray = $_POST['amountArray'];
		$ItemTypeArray = $_POST['ItemTypeArray'];
		$user_id = $_POST["user_id"];
		$disc_amount = $total_amount - $net_total;
		$countItemArray = count($vehicleArray);
		
		//starting of transaction handling
	$transaction = \Yii::$app->db->beginTransaction();
	try {
		 $insert_invoice_head = Yii::$app->db->createCommand()->insert('sale_invoice_head',[

		'customer_id'   	=> $customer_id,
		'date'    			=> $invoice_date,
		'total_amount'    	=> $total_amount,
		'discount'    		=> $disc_amount,
		'net_total'    		=> $net_total,
		'paid_amount'    	=> $paid,
		'remaining_amount'  => $remaining,
		'status'    		=> $status,
		'created_by'		=> $user_id,

	])->execute();
	 if ($insert_invoice_head) {

		$select_invoice = Yii::$app->db->createCommand("
	    SELECT 	sale_inv_head_id
	    FROM sale_invoice_head
	    WHERE customer_id		= '$customer_id'
		AND CAST(date as DATE) 	= '$invoice_date'
		AND	total_amount		= '$total_amount'
		AND	discount			= '$disc_amount'
		AND	net_total			= '$net_total'
		AND	paid_amount			= '$paid'
		AND remaining_amount	= '$remaining'
		AND	status				= '$status'
	    ")->queryAll();
	
	$selectedInvHeadID = $select_invoice[0]['sale_inv_head_id'];
	for ($j=0; $j <$countItemArray ; $j++) { 
	    	
	    	$insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

				'sale_inv_head_id'  	=> $selectedInvHeadID,
				'customer_vehicle_id'   => $vehicleArray[$j],
				'item_id'    			=> $serviceArray[$j],
				'item_type'    			=> $ItemTypeArray[$j],
				'discount_per_service'  => $amountArray[$j],
				'created_by'		=> $user_id,
				])->execute();
	    		if ($ItemTypeArray[$j] == "Stock") {

	    		$examScheduleUpdate = Yii::$app->db->createCommand()->update('stock',[
							'status'		=> "Sold",	
							'updated_by'	=> $user_id
	                        ],
	                        ['stock_id' => $serviceArray[$j]]
	            )->execute();
	    	}
	    } // end of for loop
	    // transaction commit
    	$transaction->commit();
	    echo json_encode($insert_invoice_detail);
	} // end of if
    
	} // closing of try block 
	catch (Exception $e) {
		// transaction rollback
        $transaction->rollback();
	} // closing of catch block
	// closing of transaction handling
echo json_encode($insert_invoice_detail);
	
	
}
		
?>
<!--  -->
