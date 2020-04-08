<?php 

	// getting product prices on product_name change
	if(isset($_POST['product_name'])){
		$product_name = $_POST['product_name'];

	 	$stockInfo = Yii::$app->db->createCommand("SELECT DISTINCT(s.purchase_price)
	 	FROM stock as s
	 	WHERE s.name = '$product_name'
	 	AND status = 'In-stock'")->queryAll();

		echo json_encode($stockInfo);
	}
	// getting available products qty on change of product price
	if(isset($_POST['purchase_price'])){
		$productName = $_POST['productName'];
		$purchase_price = $_POST['purchase_price'];

		$stock = Yii::$app->db->createCommand("SELECT name
	 	FROM stock
	 	WHERE name = '$productName'
	 	AND purchase_price = '$purchase_price'
	 	AND status = 'In-stock'")->queryAll();

	 	$countStk = count($stock);

		echo json_encode("[".$countStk."]");
	}
	// getting product info on barcode change
	if(isset($_POST['barcode'])){
		$ID = array();

		$barcode = $_POST['barcode'];

	 	$stockInfo = Yii::$app->db->createCommand("SELECT *
	 	FROM stock
	 	WHERE barcode = '$barcode'
	 	AND status = 'In-stock'")->queryAll();
	 	$stock_id 		= $stockInfo[0]['stock_id'];
	 	$stockID 		= $stockInfo[0]['stock_type_id'];
	 	$manufactID 	= $stockInfo[0]['manufacture_id'];
	 	$productID 		= $stockInfo[0]['name'];
	 	$expiry_date 	= $stockInfo[0]['expiry_date'];
	 	$original_price = $stockInfo[0]['original_price'];
	 	$purchase_price = $stockInfo[0]['purchase_price'];
	 	$selling_price 	= $stockInfo[0]['selling_price'];
	 	$status 		= $stockInfo[0]['status'];

	 	$stockTypeName = Yii::$app->db->createCommand("SELECT name
	 	FROM stock_type
	 	WHERE stock_type_id = '$stockID'")->queryAll();
	 	$stockName = $stockTypeName[0]['name'];

	 	$manufactureName = Yii::$app->db->createCommand("SELECT name
	 	FROM manufacture
	 	WHERE manufacture_id = '$manufactID'")->queryAll();
	 	$manufactName = $manufactureName[0]['name'];

	 	$productName = Yii::$app->db->createCommand("SELECT  product_name
	 	FROM products
	 	WHERE product_id = '$productID'")->queryAll();
	 	$productName = $productName[0]['product_name'];


	 	array_push($ID,$stockID,$manufactID,$productID,$stockName,$manufactName,$productName,$expiry_date,$original_price,$purchase_price,$selling_price,$status,$stock_id);
		echo json_encode($ID);
 	}

 	if(isset($_POST['pn'])){
		$ID = array();

		$pn = $_POST['pn'];
		$pp = $_POST['pp'];

	 	$stockInfo = Yii::$app->db->createCommand("SELECT *
	 	FROM stock
	 	WHERE name = '$pn'
	 	AND purchase_price = '$pp'
	 	AND status = 'In-stock'")->queryAll();

	 	$stock_id 		= $stockInfo[0]['stock_id'];
	 	$stockID 		= $stockInfo[0]['stock_type_id'];
	 	$manufactID 	= $stockInfo[0]['manufacture_id'];
	 	$productID 		= $stockInfo[0]['name'];
	 	$expiry_date 	= $stockInfo[0]['expiry_date'];
	 	$original_price = $stockInfo[0]['original_price'];
	 	$purchase_price = $stockInfo[0]['purchase_price'];
	 	$selling_price 	= $stockInfo[0]['selling_price'];
	 	$status 		= $stockInfo[0]['status'];

	 	$stockTypeName = Yii::$app->db->createCommand("SELECT name
	 	FROM stock_type
	 	WHERE stock_type_id = '$stockID'")->queryAll();
	 	$stockName = $stockTypeName[0]['name'];

	 	$manufactureName = Yii::$app->db->createCommand("SELECT name
	 	FROM manufacture
	 	WHERE manufacture_id = '$manufactID'")->queryAll();
	 	$manufactName = $manufactureName[0]['name'];

	 	$productName = Yii::$app->db->createCommand("SELECT  product_name
	 	FROM products
	 	WHERE product_id = '$productID'")->queryAll();
	 	$productName = $productName[0]['product_name'];


	 	array_push($ID,$stockID,$manufactID,$productID,$stockName,$manufactName,$productName,$expiry_date,$original_price,$purchase_price,$selling_price,$status,$stock_id);
		echo json_encode($ID);
 	}


 	if (isset($_POST['qty'])) {
 		
 		//$stock_id 			= $_POST['stock_id'];
	 	$stock_type_id 		= $_POST['stock_type_id'];
	 	$manufacture_id 	= $_POST['manufacture_id'];
	 	$product_id 		= $_POST['product_id'];
	 	$barcode 			= $_POST['barcode'];
	 	$expiry_date 		= $_POST['expiry_date'];
	 	$original_price 	= $_POST['original_price'];
	 	$purchasing_price 	= $_POST['purchasing_price'];
	 	$selling_price 		= $_POST['selling_price'];
	 	$status 			= $_POST['status'];
	 	$qty 			= $_POST['qty'];
	 	$id =  Yii::$app->user->identity->id;

	 	 // of transaction handling
	    $transaction = \Yii::$app->db->beginTransaction();
	    try {

	    	if(!empty($barcode)){
	    		$stock_id = $_POST['stock_id'];
	    		$stock = Yii::$app->db->createCommand()->update('stock',[
				     // 'expiry_date'     => $expiry_date,
				     // 'original_price'  => $original_price,
				     // 'purchase_price' => $purchasing_price,
				     // 'selling_price'   => $selling_price,
				     'status'   	   => $status,
				     'updated_by'      => $id,
				    ],
		       		['stock_id' => $stock_id]
		    	)->execute();
	    	}
	    	else{
	    		$STOCK = Yii::$app->db->createCommand("SELECT stock_id
			 	FROM stock
			 	WHERE name = '$product_id'
			 	AND purchase_price = '$purchasing_price'
			 	AND status = 'In-stock'
			 	LIMIT $qty")
			 	->queryAll();
			 	foreach ($STOCK as $key => $value) {
			 		$stock_id = $value['stock_id'];
			 		$stock = Yii::$app->db->createCommand()->update('stock',[
					     // 'expiry_date'     => $expiry_date,
					     // 'original_price'  => $original_price,
					     // 'purchase_price' => $purchasing_price,
					     // 'selling_price'   => $selling_price,
					     'status'   	   => $status,
					     'updated_by'      => $id,
					    ],
			       		['stock_id' => $stock_id]
		    		)->execute();
			 	}
			 	
	    		
	    	} // closing of else

	     // transaction commit
	    $transaction->commit();

	    echo json_encode($stock);
	        
	    } // closing of try block 
	    catch (Exception $e) {
	      // transaction rollback
	         $transaction->rollback();
	    } // closing of catch block
	     // closing of transaction handling
 	} // stock update


?>

