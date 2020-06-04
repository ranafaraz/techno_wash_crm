<?php
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
use yii\helpers\Json;
if(isset($_POST['customer_id'])) {

	$customer_id = $_POST['customer_id'];
	$customerId = Yii::$app->db->createCommand("
	SELECT c.customer_id, c.customer_name, c.customer_contact_no,cv.customer_vehicle_id, cv.registration_no
	FROM customer as c
	INNER JOIN customer_vehicles as cv 
	ON c.customer_id = cv.customer_id
	WHERE c.customer_id = '$customer_id'
	")->queryAll();

	echo json_encode($customerId);
}

if(isset($_POST['PRODUCTid'])) {
	$PRODUCTid = $_POST['PRODUCTid'];
	$availbleStock = Yii::$app->db->createCommand("
	SELECT *
	FROM stock
	WHERE name = '$PRODUCTid'
	AND status = 'In-stock'
	")->queryAll();
	echo json_encode($availbleStock);
}

if(isset($_POST['productID'])) {
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

if(isset($_POST['barcode'])) {
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

if(isset($_POST['serviceID'])) {
	$serviceID = $_POST['serviceID'];
	$customerVehicle = $_POST['customerVehicle'];

	$vehcID = Yii::$app->db->createCommand("
	SELECT vtsh.vehicle_type_id
	FROM ((customer_vehicles as cv
	INNER JOIN vehicle_type_sub_category as vtsc
	ON cv.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id)
	INNER JOIN vehicle_type_sub_cat_head as vtsh
	ON vtsh.sub_cat_head_id = vtsc.sub_type_head_id)
	WHERE cv.customer_vehicle_id = '$customerVehicle'
	")->queryAll();
		$vehicleTypID = $vehcID[0]['vehicle_type_id'];

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

if (isset($_POST["vehicle_id"])) {
	$vehicle=$_POST["vehicle_id"];
	$register = Yii::$app->db->createCommand("
	SELECT 	registration_no,vehicle_typ_sub_id
	FROM customer_vehicles
	WHERE 	customer_vehicle_id = $vehicle
	")->queryAll();

	$vehicalDetailId = $register[0]['vehicle_typ_sub_id'];

	$unknownModel = Yii::$app->db->createCommand("
	SELECT
	vdetail.vehicle_typ_sub_id,
	cm.car_manufacture_id,
	vt.vehical_type_id,
	cv.customer_vehicle_id
	FROM (((vehicle_type_sub_category as vdetail
	INNER JOIN vehicle_type_sub_cat_head as vhead
	ON vdetail.sub_type_head_id = vhead.sub_cat_head_id)
	INNER JOIN vehicle_type as vt
	ON vhead.vehicle_type_id = vt.vehical_type_id)
	INNER JOIN car_manufacture as cm
	ON vhead.manufacture = cm.car_manufacture_id)
	INNER JOIN customer_vehicles as cv
	ON vdetail.vehicle_typ_sub_id = cv.vehicle_typ_sub_id
	WHERE vdetail.vehicle_typ_sub_id = $vehicalDetailId
	AND (vdetail.name = 'Unknown'
	OR vt.name = 'Unknown'
	OR cm.manufacturer = 'Unknown')
	")->queryAll();

	echo json_encode($unknownModel); 
}

if (isset($_POST["vehicle"])) {
	$vehicle=$_POST["vehicle"];
	$register = Yii::$app->db->createCommand("
	SELECT 	cv.registration_no, vtsc.name
	FROM customer_vehicles as cv
	INNER JOIN vehicle_type_sub_category as vtsc
	ON cv.vehicle_typ_sub_id = vtsc.vehicle_typ_sub_id
	WHERE cv.customer_vehicle_id = $vehicle
	")->queryAll();
	
	echo json_encode($register); 
}

if(isset($_POST['vehID'])) {

	$vehID = $_POST['vehID'];
	$vehData = Yii::$app->db->createCommand("
	SELECT c.customer_id,
	c.customer_name,
	c.customer_contact_no
	FROM customer as c
	INNER JOIN customer_vehicles as cv 
	ON c.customer_id = cv.customer_id
	WHERE cv.customer_vehicle_id = '$vehID'
	")->queryAll();

	echo json_encode($vehData);
}

if(isset($_POST['contact_no'])) {

	$contact_no = $_POST['contact_no'];
	$cust_contact = Yii::$app->db->createCommand("
	SELECT c.*
	FROM customer as c
	WHERE c.customer_contact_no = '$contact_no'
	")->queryAll();

	echo json_encode($cust_contact);
}

if( isset($_POST['invoice_date']) 
	&& isset($_POST['total_amount']) 
	&& isset($_POST['net_total']) 
	&& isset($_POST['paid']) 
	&& isset($_POST['remaining'])
	&& isset($_POST['status']) 
	&& isset($_POST['vehicleArray'])
	&& isset($_POST['serviceArray'])
	&& isset($_POST['amountArray'])
	&& isset($_POST['ItemTypeArray']) ) {

	$user_id = $_POST["user_id"];
	$branch_id = $_POST['branch_id'];
	$invoice_date= $_POST["invoice_date"];
	$total_amount = $_POST["total_amount"];
	$net_total = $_POST['net_total'];
	$paid = $_POST['paid'];
	$remaining = $_POST['remaining'];
	$cash_return = $_POST['cash_return'];
	$status = $_POST["status"];
	$vehicleArray = $_POST['vehicleArray']; 
	$serviceArray = $_POST["serviceArray"];
	$amountArray = $_POST['amountArray'];
	$ItemTypeArray = $_POST['ItemTypeArray'];
	$quantityArray = $_POST["quantityArray"];

	$disc_amount = $total_amount - $net_total;
	$countItemArray = count($vehicleArray);

	$transaction = \Yii::$app->db->beginTransaction();
	try {

		$custId = Yii::$app->db->createCommand("
		    SELECT 	c.customer_id
		    FROM customer as c 
		    INNER JOIN customer_vehicles as cv 
		    ON c.customer_id = cv.customer_id
		    WHERE c.branch_id = '$branch_id'
			AND cv.customer_vehicle_id	= '$vehicleArray[0]'
		    ")->queryAll();
		$customer_id = $custId[0]['customer_id'];

		$insert_invoice_head = Yii::$app->db->createCommand()->insert('sale_invoice_head',[
			'branch_id' => $branch_id,
			'customer_id'   	=> $customer_id,
			'date'    			=> $invoice_date,
			'total_amount'    	=> $total_amount,
			'discount'    		=> $disc_amount,
			'net_total'    		=> $net_total,
			'paid_amount'    	=> $paid,
			'remaining_amount'  => $remaining,
			'cash_return'		=> $cash_return,
			'status'    		=> $status,
			'created_by'		=> $user_id,
		])->execute();

		if ($insert_invoice_head) {
			$select_invoice = Yii::$app->db->createCommand("
			    SELECT 	sale_inv_head_id
			    FROM sale_invoice_head
			    WHERE customer_id		= '$customer_id'
			    AND branch_id = '$branch_id'
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

			$insert_invoice_amount = Yii::$app->db->createCommand()->insert('sale_invoice_amount_detail',[

				'sale_inv_head_id' => $selectedInvHeadID,
				'transaction_date'    	=> new \yii\db\Expression('NOW()'),
				'paid_amount'    		=> $paid,
				//'transaction_id'	  => $transactionId,
				'created_by'			=> $user_id,
				])->execute();

			if ($insert_invoice_amount) {
				$invoice_amount = Yii::$app->db->createCommand("
			    SELECT 	*
			    FROM sale_invoice_amount_detail
			    WHERE sale_inv_head_id	= '$selectedInvHeadID'
			    ORDER BY s_inv_amount_detail DESC
			    ")->queryAll();
				$invoice_amount = $invoice_amount[0]['s_inv_amount_detail'];

				// id 3 is reserved for Sale Account
				$account_head =3;
				$transactions = Yii::$app->db->createCommand()->insert('transactions',
				[
					'branch_id' => $branch_id,
					'account_head_id' => $account_head,
					//'total_amount' => $net_total,
					'amount' => $paid,
					//'remaining' => $remaining,
					'head_id' => $selectedInvHeadID,
					'ref_no' => $invoice_amount,
					'ref_name' => "Sale",
					'transactions_date' => $invoice_date,
					'created_by' => \Yii::$app->user->identity->id,
				 	
				])->execute();			
			}
			for ($j=0; $j <$countItemArray ; $j++) {
				$itemType = $ItemTypeArray[$j];
				$quantity = $quantityArray[$j];

		    	if($itemType == "Product"){
		     		$product_id = $serviceArray[$j];

		    		$selectProduct = Yii::$app->db->createCommand("
					    SELECT *
					    FROM stock
					    WHERE name = '$product_id'
					    AND status = 'In-stock'
					    LIMIT $quantity
					    ")->queryAll();
		    		$count = count($selectProduct);

		    		for ($i=0; $i<$count; $i++) { 
		    			$stock_id = $selectProduct[$i]['stock_id'];

		    			$insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

						'sale_inv_head_id'  	=> $selectedInvHeadID,
						'customer_vehicle_id'   => $vehicleArray[$j],
						'item_id'    			=> $stock_id,
						'item_type'    			=> "Stock",
						'discount_per_service'  => $amountArray[$j],
						'created_by'			=> $user_id,
						])->execute();

			    		$examScheduleUpdate = Yii::$app->db->createCommand()->update('stock',[
							'status'		=> "Sold",	
							'updated_by'	=> $user_id
	                        ],
	                        ['stock_id' => $stock_id]
			            )->execute();
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
		    
	    	$transaction->commit();
		    echo Json::encode("[".$selectedInvHeadID ."]");
		} // end of if
	} // closing of try block 
	catch (Exception $e) {
		echo $e;
		 $transaction->rollback();
	} // closing of catch block
} // closing of isset
	
if( isset($_POST['u_invoice_date']) 
 	&& isset($_POST['u_total_amount']) 
 	&& isset($_POST['u_net_total']) 
 	&& isset($_POST['u_paid']) 
 	&& isset($_POST['u_remaining'])
 	&& isset($_POST['u_status']) 
 	&& isset($_POST['u_vehicleArray'])
 	&& isset($_POST['u_serviceArray'])
 	&& isset($_POST['u_amountArray'])
 	&& isset($_POST['u_ItemTypeArray']) ) {

	$user_id = $_POST["u_user_id"];
	$branch_id = $_POST['u_branch_id'];
	$invoice_date= $_POST["u_invoice_date"];
	$total_amount = $_POST["u_total_amount"];
	$net_total = $_POST['u_net_total'];
	$paid = $_POST['u_paid'];
	$remaining = $_POST['u_remaining'];
	$cash_return = $_POST['u_cash_return'];
	$status = $_POST["u_status"];
	$vehicleArray = $_POST['u_vehicleArray']; 
	$serviceArray = $_POST["u_serviceArray"];
	$amountArray = $_POST['u_amountArray'];
	$ItemTypeArray = $_POST['u_ItemTypeArray'];
	$quantityArray = $_POST["u_quantityArray"];

	$invoice_id = $_POST["u_invoice_id"];
	$customer_id = $_POST["u_customer_id"];

	$disc_amount = $total_amount - $net_total;
	$countItemArray = count($vehicleArray);
	
	$transaction = \Yii::$app->db->beginTransaction();
	try {

		$insert_invoice_head = Yii::$app->db->createCommand()->update('sale_invoice_head',[

		     'date' => $invoice_date,
		     'total_amount' => $total_amount,
		     'discount' => $disc_amount,
		     'net_total' => $net_total,
		     'paid_amount' => $paid,
		     'remaining_amount' => $remaining,
		     'cash_return' => $cash_return,
		     'status' => $status,
		    ],
		       ['customer_id' => $customer_id,'sale_inv_head_id' => $invoice_id ]

		    )->execute();

		for ($j=0; $j <$countItemArray ; $j++) {
			$itemType = $ItemTypeArray[$j];
			$quantity = $quantityArray[$j];

	    	if($itemType == "Product"){
	     		$product_id = $serviceArray[$j];

	    		$selectProduct = Yii::$app->db->createCommand("
				    SELECT *
				    FROM stock
				    WHERE name = '$product_id'
				    AND status = 'In-stock'
				    LIMIT $quantity
				    ")->queryAll();
	    		$count = count($selectProduct);

	    		for ($i=0; $i<$count; $i++) { 
	    			$stock_id = $selectProduct[$i]['stock_id'];

	    			$insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

					'sale_inv_head_id'  	=> $invoice_id,
					'customer_vehicle_id'   => $vehicleArray[$j],
					'item_id'    			=> $stock_id,
					'item_type'    			=> "Stock",
					'discount_per_service'  => $amountArray[$j],
					'created_by'			=> $user_id,
					])->execute();

		    		$examScheduleUpdate = Yii::$app->db->createCommand()->update('stock',[
						'status'		=> "Sold",	
						'updated_by'	=> $user_id
                        ],
                        ['stock_id' => $stock_id]
		            )->execute();
	    		}
	    	} //closing of quantity if 
	    	else {
		    	$insert_invoice_detail = Yii::$app->db->createCommand()->insert('sale_invoice_detail',[

					'sale_inv_head_id'  	=> $invoice_id,
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
	    
    	$transaction->commit();
	    echo Json::encode("[".$invoice_id."]");
	} // closing of try block 
	catch (Exception $e) {
		echo Json::encode("[".$e."]");
 	 $transaction->rollback();
	} // closing of catch block
} // closing of isset
		
?>