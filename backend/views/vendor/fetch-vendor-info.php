<?php 
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
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
&& isset($_POST['bill_no'])
&& isset($_POST['purchase_date'])
&& isset($_POST['total_amount'])
&& isset($_POST['net_total'])
&& isset($_POST['paid'])
&& isset($_POST['remaining'])
&& isset($_POST['barcodeArray'])
&& isset($_POST['stockTypeArray'])
&& isset($_POST['manufacturerArray'])
&& isset($_POST['nameArray'])
&& isset($_POST['purchasePriceArray'])
&& isset($_POST['sellingPriceArray'])){
	//$narration 			= $_POST['narration'];
 	$user_id 				= $_POST["user_id"];
	$branch_id 				= $_POST['branch_id'];
	$vendorID				= $_POST["vendorID"];
	$bilty_no				= $_POST['bilty_no'];
	$bill_no				= $_POST['bill_no'];
	$purchase_date 			= $_POST['purchase_date'];
	$dispatch_date 			= $_POST['dispatch_date'];
	$receiving_date 		= $_POST['receiving_date'];
	$total_amount 			= $_POST["total_amount"];
	$net_total 				= $_POST['net_total'];
	$payment_type 			= $_POST['payment_type'];
	$paid 					= $_POST["paid"];
	$remaining 				= $_POST['remaining'];
	$cash_return 			= $_POST['cash_return'];
	$status 				= $_POST['status'];
	$orgProfit				= $_POST['orgProfit'];
	$barcodeArray 			= $_POST['barcodeArray'];
	$stockTypeArray 		= $_POST['stockTypeArray'];
	$manufacturerArray 		= $_POST['manufacturerArray'];
	$nameArray 				= $_POST['nameArray'];
	$stockStatusArray		= $_POST['stockStatusArray'];
	$expiryDateArray 		= $_POST['expiryDateArray'];
	$originalPriceArray 	= $_POST['originalPriceArray'];
	$purchasePriceArray 	= $_POST['purchasePriceArray'];
	$sellingPriceArray 		= $_POST['sellingPriceArray'];
	$quantityArray 			= $_POST['quantityArray'];
	if($net_total <= $total_amount){
		$disc_amount = $total_amount - $net_total;
	} else {
		$disc_amount = 0;
	}
	$countStockTypeArray = count($stockTypeArray);

	$transaction = \Yii::$app->db->beginTransaction();
	try {
		$purchase_invoice = Yii::$app->db->createCommand()->insert('purchase_invoice',[
			'branch_id' 		=> $branch_id,
			'vendor_id'   		=> $vendorID,
			'bilty_no'    		=> $bilty_no,
			'bill_no'    		=> $bill_no,
			'purchase_date'    	=> $purchase_date,
			'dispatch_date'    	=> $dispatch_date,
			'receiving_date'    => $receiving_date,
			'total_amount'    	=> $total_amount,
			'discount'    		=> $disc_amount,
			'net_total'    		=> $net_total,
			'profit'			=> $orgProfit,
			'paid_amount'    	=> $paid,
			'remaining_amount'  => $remaining,
			'cash_return'		=> $cash_return,
			'status'    		=> $status,
			'created_by'		=> $user_id,
		])->execute();
	
	 	if ($purchase_invoice) {
			$select_purchase_invoice = Yii::$app->db->createCommand("
			    SELECT 	purchase_invoice_id
			    FROM purchase_invoice
			    WHERE vendor_id	= '$vendorID'
			    AND branch_id 	= '$branch_id'
			    AND bill_no= '$bill_no'
				AND CAST(purchase_date as DATE) = '$purchase_date'
				AND	total_amount = '$total_amount'
				AND	discount = '$disc_amount'
				AND	net_total = '$net_total'
				AND	paid_amount	= '$paid'
				AND remaining_amount = '$remaining'
				AND	status = '$status'
		    ")->queryAll();
	
			$selectedPurchInvID = $select_purchase_invoice[0]['purchase_invoice_id'];

			$purchase_invoice_amount = Yii::$app->db->createCommand()->insert('purchase_invoice_amount_detail',[
				'purchase_invoice_id' => $selectedPurchInvID,
				'transaction_date'    => date('y-m-d'),
				'paid_amount'    	  => $paid,
				'created_by'		  => $user_id,
			])->execute();

			if ($purchase_invoice_amount) {
				$invoice_amount = Yii::$app->db->createCommand("
			    SELECT 	*
			    FROM purchase_invoice_amount_detail
			    WHERE purchase_invoice_id	= '$selectedPurchInvID'
			    ORDER BY p_inv_amount_detail DESC
			    ")->queryAll();
				$invoice_amountId = $invoice_amount[0]['p_inv_amount_detail'];

				$accountHead = 4;
				
				$transactionData = Yii::$app->db->createCommand()->insert('transactions',[
					'branch_id' => $branch_id,
					'type'		=> $payment_type,
					'account_head_id' => $accountHead,
					//'total_amount' => $net_total,
					'amount' => $paid,
					//'remaining' => $remaining,
					'transactions_date' => $purchase_date,
					'head_id' => $selectedPurchInvID,
					'ref_no' => $invoice_amountId,
					'ref_name' => "Purchase",
					'created_by' => $user_id,
				])->execute();
				
				for ($j=0; $j <$countStockTypeArray ; $j++) { 
					$qty = $quantityArray[$j];

					if($qty > 1){
						for ($i=0; $i <$qty ; $i++) { 
							$insert_stock = Yii::$app->db->createCommand()->insert('stock',[
							'stock_type_id'  	=> $stockTypeArray[$j],
							'purchase_invoice_id'=> $selectedPurchInvID,
							'manufacture_id'    => $manufacturerArray[$j],
							'barcode'    	  	=> $barcodeArray[$j],
							'name'  			=> $nameArray[$j],
							'stock_status'		=> $stockStatusArray[$j],
							'expiry_date'  		=> $expiryDateArray[$j],
							'original_price'  	=> $originalPriceArray[$j],
							'purchase_price'  	=> $purchasePriceArray[$j],
							'selling_price'  	=> $sellingPriceArray[$j],
							'status'  			=> "In-stock",
							'created_by'		=> $user_id,
							])->execute();
						}
					} else {
				    	$insert_stock = Yii::$app->db->createCommand()->insert('stock',[
							'stock_type_id'  	=> $stockTypeArray[$j],
							'purchase_invoice_id' => $selectedPurchInvID,
							'manufacture_id'    => $manufacturerArray[$j],
							'barcode'    		=> $barcodeArray[$j],
							'name'  			=> $nameArray[$j],
							'stock_status'		=> $stockStatusArray[$j],
							'expiry_date'  		=> $expiryDateArray[$j],
							'original_price'  	=> $originalPriceArray[$j],
							'purchase_price'  	=> $purchasePriceArray[$j],
							'selling_price'  	=> $sellingPriceArray[$j],
							'status'  			=> "In-stock",
							'created_by'		=> $user_id,
						])->execute();
				    }
				} // end of for loop			
		    	$transaction->commit();
			    echo json_encode("[".$selectedPurchInvID."]");
			} //if ($purchase_invoice_amount)
		} // end of if
	} // closing of try block 
	catch (Exception $e) {
		echo json_encode($e);
		// transaction rollback
        $transaction->rollback();
	} // closing of catch block
// 	 echo json_encode($vendorID);
// 	 echo json_encode($bill_no);
// 	 echo json_encode($purchase_date);
// 	 echo json_encode($total_amount);
// 	 echo json_encode($net_total);
// 	 echo json_encode($payment_type);
// 	 echo json_encode($paid);
// 	 echo json_encode($remaining);
// 	 echo json_encode($cash_return);
// 	 echo json_encode($status);
// 	 echo json_encode($orgProfit);
// 	 echo json_encode($barcodeArray);
// 	 echo json_encode($stockTypeArray);
// 	 echo json_encode($manufacturerArray);
// 	 echo json_encode($nameArray);
// 	 echo json_encode($stockStatusArray);
// 	 echo json_encode($expiryDateArray);
// 	 echo json_encode($originalPriceArray);
// 	 echo json_encode($purchasePriceArray);
// 	 echo json_encode($sellingPriceArray);
// 	 echo json_encode($quantityArray);
// 	 echo json_encode($disc_amount);
// 	 echo json_encode($countStockTypeArray);
}

 ?>