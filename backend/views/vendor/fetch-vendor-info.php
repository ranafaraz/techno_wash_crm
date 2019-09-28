<?php 

	if(isset($_POST['stock_type'])){
	$stock_type = $_POST['stock_type'];

 	$stockType = Yii::$app->db->createCommand("SELECT *
 		FROM stock_type
 		WHERE stock_type_id = '$stock_type'")->queryAll();
 	echo json_encode($stockType);
 	}
 	// manufacturer dependent dropdown
	if(isset($_POST['stockType'])){
	$stockTypeID = $_POST['stockType'];

 	$manufacturelists = Yii::$app->db->createCommand("SELECT *
	FROM manufacture
	WHERE stock_type_id = '$stockTypeID'")->queryAll();
 	echo json_encode($manufacturelists);
 	}
 	// product drop down
 	if(isset($_POST['manufactureType'])){
	$manufactureTypeID = $_POST['manufactureType'];

 	$productlists = Yii::$app->db->createCommand("SELECT *
	FROM products
	WHERE manufacture_id = '$manufactureTypeID'")->queryAll();
 	echo json_encode($productlists);
 	}

 	// product Name
 	if(isset($_POST['product_name'])){
	$product_nameID = $_POST['product_name'];

 	$productName = Yii::$app->db->createCommand("SELECT product_name
	FROM products
	WHERE product_id = '$product_nameID'")->queryAll();
 	echo json_encode($productName);
 	}



 	if(isset($_POST['manufacture_type'])){
	$manufacture_type = $_POST['manufacture_type'];

 	$manufactreName = Yii::$app->db->createCommand("SELECT *
 		FROM manufacture
 		WHERE manufacture_id = '$manufacture_type'")->queryAll();
 	echo json_encode($manufactreName);
 	}

 	if( isset($_POST['user_id'])

 		&& isset($_POST['vendorID'])
 		&& isset($_POST['bilty_no'])
 	 	&& isset($_POST['purchase_date'])
 	 	&& isset($_POST['dispatch_date']) 
 	 	&& isset($_POST['receiving_date'])
 	 	&& isset($_POST['total_amount'])
 	  	&& isset($_POST['net_total'])
 	  	&& isset($_POST['paid'])
 	  	&& isset($_POST['remaining'])
 	  	&& isset($_POST['barcodeArray'])
 	   	&& isset($_POST['stockTypeArray'])
 	   	&& isset($_POST['manufacturerArray'])
 	   	&& isset($_POST['nameArray'])
 	   	&& isset($_POST['expiryDateArray'])
 	   	&& isset($_POST['originalPriceArray'])
 	   	&& isset($_POST['purchasePriceArray'])
 	   	&& isset($_POST['sellingPriceArray']))
 	{

	 	$user_id 				= $_POST["user_id"];
		$vendorID				= $_POST["vendorID"];
		$bilty_no				= $_POST['bilty_no'];
		$purchase_date 			= $_POST['purchase_date'];
		$dispatch_date 			= $_POST['dispatch_date'];
		$receiving_date 		= $_POST['receiving_date'];
		$total_amount 			= $_POST["total_amount"];
		$net_total 				= $_POST['net_total']; 
		$paid 					= $_POST["paid"];
		$remaining 				= $_POST['remaining'];
		$status 				= $_POST['status'];
		$barcodeArray 			= $_POST['barcodeArray'];
		$stockTypeArray 		= $_POST['stockTypeArray'];
		$manufacturerArray 		= $_POST['manufacturerArray'];
		$nameArray 				= $_POST['nameArray'];
		$expiryDateArray 		= $_POST['expiryDateArray'];
		$originalPriceArray 	= $_POST['originalPriceArray'];
		$purchasePriceArray 	= $_POST['purchasePriceArray'];
		$sellingPriceArray 		= $_POST['sellingPriceArray'];

		$disc_amount = $total_amount - $net_total;
		$countStockTypeArray = count($stockTypeArray);

	// starting of transaction handling
	$transaction = \Yii::$app->db->beginTransaction();
	try {
		 $purchase_invoice = Yii::$app->db->createCommand()->insert('purchase_invoice',[

		'vendor_id'   		=> $vendorID,
		'bilty_no'    		=> $bilty_no,
		'purchase_date'    	=> $purchase_date,
		'dispatch_date'    	=> $dispatch_date,
		'receiving_date'    => $receiving_date,
		'total_amount'    	=> $total_amount,
		'discount'    		=> $disc_amount,
		'net_total'    		=> $net_total,
		'paid_amount'    	=> $paid,
		'remaining_amount'  => $remaining,
		'status'    		=> $status,
		'created_by'		=> $user_id,

	])->execute();
	 if ($purchase_invoice) {

		$select_purchase_invoice = Yii::$app->db->createCommand("
	    SELECT 	purchase_invoice_id
	    FROM purchase_invoice
	    WHERE vendor_id						= '$vendorID'
	    AND bilty_no						= '$bilty_no'
		AND CAST(purchase_date as DATE) 	= '$purchase_date'
		AND CAST(dispatch_date as DATE) 	= '$dispatch_date'
		AND CAST(receiving_date as DATE) 	= '$receiving_date'
		AND	total_amount					= '$total_amount'
		AND	discount						= '$disc_amount'
		AND	net_total						= '$net_total'
		AND	paid_amount					= '$paid'
		AND remaining_amount			= '$remaining'
		AND	status						= '$status'
	    ")->queryAll();
	
	$selectedPurchInvID = $select_purchase_invoice[0]['purchase_invoice_id'];

	for ($j=0; $j <$countStockTypeArray ; $j++) { 
	    	
	    	$insert_stock = Yii::$app->db->createCommand()->insert('stock',[

				'stock_type_id'  		=> $stockTypeArray[$j],
				'purchase_invoice_id'   => $selectedPurchInvID,
				'manufacture_id'    	=> $manufacturerArray[$j],
				'barcode'    			=> $barcodeArray[$j],
				'name'  				=> $nameArray[$j],
				'expiry_date'  			=> $expiryDateArray[$j],
				'original_price'  		=> $originalPriceArray[$j],
				'purchase_price'  		=> $purchasePriceArray[$j],
				'selling_price'  		=> $sellingPriceArray[$j],
				'status'  				=> "In-stock",
				'created_by'			=> $user_id,
				])->execute();
	    } // end of for loop
	    // transaction commit
    	$transaction->commit();
	    echo json_encode($insert_stock);
	} // end of if
    
	} // closing of try block 
	catch (Exception $e) {
		// transaction rollback
        $transaction->rollback();
	} // closing of catch block
	// closing of transaction handling

	
}

 ?>