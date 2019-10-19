<?php
	if(isset($_POST['PRODUCTid']))
	{
		$PRODUCTid = $_POST['PRODUCTid'];
		$availbleStock = Yii::$app->db->createCommand("
		SELECT *
		FROM stock
		WHERE name = '$PRODUCTid'
		AND status = 'In-stock'
		")->queryAll();
		echo json_encode($availbleStock);

	}

	if(isset($_POST['productID']))
	{
		$productID = $_POST['productID'];
		$productData = Yii::$app->db->createCommand("
		SELECT p.product_name,s.selling_price
		FROM products as p 
		INNER JOIN stock as s
		ON s.name = p.product_id
		WHERE p.product_id = '$productID'
		AND s.status = 'In-stock'
		")->queryAll();
		echo json_encode($productData);

	}

	if(isset($_POST['barcode'])){
	$barcode = $_POST['barcode'];

 	$stock = Yii::$app->db->createCommand("
	    SELECT st.*, prod.product_name
	    FROM stock as st
	    INNER JOIN products as prod
	    ON st.name = prod.product_id
	    WHERE st.barcode = '$barcode'
	    AND st.status = 'In-stock'
	    ")->queryAll();
 	echo json_encode($stock);
 	}


 	if(isset($_POST['serviceID']))
 	{
 		$serviceID = $_POST['serviceID'];
 		$customerVehicle = $_POST['customerVehicle'];

 		$vehcID = Yii::$app->db->createCommand("
	    SELECT vt.vehical_type_id
	    FROM ((customer_vehicles as cv
		INNER JOIN vehicle_type_sub_category as vtsc
		ON cv.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id)
		INNER JOIN car_manufacture as cm
		ON cm.car_manufacture_id = vtsc.manufacture)
		INNER JOIN vehicle_type as vt
		ON vt.vehical_type_id = cm.vehical_type_id
	    WHERE cv.customer_vehicle_id = '$customerVehicle'
	    ")->queryAll();
 		$vehicleTypID = $vehcID[0]['vehical_type_id'];

 		$serviceDetails = Yii::$app->db->createCommand("
	    SELECT sd.*,s.service_name
	    FROM service_details as sd
	    INNER JOIN services as s
	    ON sd.service_id = s.service_id
	    WHERE sd.vehicle_type_id = '$vehicleTypID'
	    AND s.service_id = '$serviceID'
	    ")->queryAll();
 		 

	   echo json_encode($serviceDetails); 
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
	$quantityArray = $_POST["quantityArray"];
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
		ORDER BY sale_inv_head_id DESC
	    ")->queryAll();
	
	$selectedInvHeadID = $select_invoice[0]['sale_inv_head_id'];

	for ($j=0; $j <$countItemArray ; $j++) {

		$quantity = $quantityArray[$j];

	    	if($quantity > 1){
	    		$product_id = $serviceArray[$j];

	    		$selectProduct = Yii::$app->db->createCommand("
				    SELECT 	*
				    FROM stock
				    WHERE name = '$product_id'
				    AND status = 'In-stock'
				    LIMIT '$quantity'
				    ")->queryAll();
	    		$count = count($selectProduct);

	    		for ($i=0; $i<4; $i++) { 
	    			//$prod_id = $selectProduct[$i]['stock_id'];

	    			$insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

					'sale_inv_head_id'  	=> $selectedInvHeadID,
					'customer_vehicle_id'   => $vehicleArray[$j],
					'item_id'    			=> $serviceArray[$j],
					'item_type'    			=> $ItemTypeArray[$j],
					'discount_per_service'  => $amountArray[$j],
					'created_by'			=> $user_id,
					])->execute();

	    			// if ($ItemTypeArray[$i] == "Stock") {

		    		// $examScheduleUpdate = Yii::$app->db->createCommand()->update('stock',[
								// 'status'		=> "Sold",	
								// 'updated_by'	=> $user_id
		      //                   ],
		      //                   ['stock_id' => $prod_id[$j]]
		      //       )->execute();
		      //   }
	    			    			
	    		}
	    	} //closing of quantity if 
	    	else {
		    	$insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

					'sale_inv_head_id'  	=> $selectedInvHeadID,
					'customer_vehicle_id'   => $vehicleArray[$j],
					'item_id'    			=> $serviceArray[$j],
					'item_type'    			=> $ItemTypeArray[$j],
					'discount_per_service'  => $amountArray[$j],
					'created_by'			=> $user_id,
					])->execute();
		    		if ($ItemTypeArray[$j] == "Stock") {

		    		$examScheduleUpdate = Yii::$app->db->createCommand()->update('stock',[
								'status'		=> "Sold",	
								'updated_by'	=> $user_id
		                        ],
		                        ['stock_id' => $serviceArray[$j]]
		            )->execute();
		        }
	    	} // closing of quantity else
	    } // end of for loop itemarray
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
} // closing of isset
		
?>