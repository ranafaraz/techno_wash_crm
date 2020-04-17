<?php 
	if(isset($_GET['stockTypeID'])){

	$stockTypeID = $_GET['stockTypeID'];

	// getting stock Type name
	$stockTypeName = Yii::$app->db->createCommand("
	SELECT *
	FROM  stock_type
	WHERE stock_type_id = $stockTypeID
	")->queryAll();
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
					<p style="font-weight:bolder;background-color:#d2d6de;padding:5px;text-align: center;color:#000000;font-size:15px;">Update Stock Type<br>( <?php echo $stockTypeName[0]['name'];?> )
					</p>
					<div class="form-group">
						<label>Stock Type</label>
						<input type="text" name="stockType" class="form-control" value="<?php echo $stockTypeName[0]['name'];?>">
						<label>Description</label>
						<input type="text" name="description" class="form-control" value="<?php echo $stockTypeName[0]['description'];?>">
						<input type="hidden" name="stkID" value="<?php echo $stockTypeName[0]['stock_type_id'];?>">
					</div>
					<button name="update_stoktype" class="btn btn-info btn-xs">
						<i class="glyphicon glyphicon-edit"></i><b> &nbsp;Update</b>
					</button>
					<a href="./stock-type-view?id=<?php echo $stockTypeID;?>" class="btn btn-danger btn-xs">
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

	if(isset($_POST['update_stoktype'])){
		$stockType   = $_POST['stockType'];
		$description = $_POST['description'];
		$stkID 		 = $_POST['stkID'];

		// starting of transaction handling
		$transaction = \Yii::$app->db->beginTransaction();
		try {
			$updateStockType = Yii::$app->db->createCommand()->update('stock_type',[
		     'name'      		=> $stockType,
		     'description'     => $description,
		     'updated_at' 				=> new \yii\db\Expression('NOW()'),
		     'updated_by'       		=> Yii::$app->user->identity->id,
	    ],['stock_type_id' => $stkID])->execute();
        // transaction commit
        $transaction->commit();
        \Yii::$app->response->redirect(['./stock-type-view','id' => $stkID]);
		} // closing of try block 
		catch (Exception $e) {
			// transaction rollback
            $transaction->rollback();
		} // closing of catch block
		// closing of transaction handling
	}

?>

<?php 
	// isset for manufacture update

	if(isset($_GET['manufactureID'])){

		$manufactureID = $_GET['manufactureID'];
		$stkTypId = $_GET['stkTypId'];

		// getting manufactures name
		$manufactureData = Yii::$app->db->createCommand("
		SELECT *
		FROM  manufacture
		WHERE manufacture_id = $manufactureID
		")->queryAll();
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
					<p style="font-weight:bolder;background-color:#d2d6de;padding:5px;text-align: center;color:#000000;font-size:15px;">Update Manufacture<br>( <?php echo $manufactureData[0]['name'];?> )
					</p>
					<div class="form-group">
						<label>Manufacture</label>
						<input type="text" name="manufacture_name" class="form-control" value="<?php echo $manufactureData[0]['name'];?>">
						<label>Description</label>
						<input type="text" name="manufact_description" class="form-control" value="<?php echo $manufactureData[0]['description'];?>">
						<input type="hidden" name="mID" value="<?php echo $manufactureData[0]['manufacture_id'];?>">
						<input type="hidden" name="stkTypId" value="<?php echo $stkTypId;?>">
					</div>
					<button name="update_manufacture" class="btn btn-info btn-xs">
						<i class="glyphicon glyphicon-edit"></i><b> &nbsp;Update</b>
					</button>
					<a href="./stock-type-view?id=<?php echo $stkTypId;?>" class="btn btn-danger btn-xs">
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
if(isset($_POST['update_manufacture'])){
		$manufacture_name   = $_POST['manufacture_name'];
		$manufact_description = $_POST['manufact_description'];
		$mID = $_POST['mID'];
		$stkTypId = $_POST['stkTypId'];
		// starting of transaction handling
		$transaction = \Yii::$app->db->beginTransaction();
		try {
			$updateManufacture = Yii::$app->db->createCommand()->update('manufacture',[
		     'name'      		=> $manufacture_name,
		     'description'     => $manufact_description,
		     'updated_at' 				=> new \yii\db\Expression('NOW()'),
		     'updated_by'       		=> Yii::$app->user->identity->id,
	    ],['manufacture_id' => $mID])->execute();
        // transaction commit
        $transaction->commit();
        \Yii::$app->response->redirect(['./stock-type-view','id' => $stkTypId]);
		} // closing of try block 
		catch (Exception $e) {
			// transaction rollback
            $transaction->rollback();
		} // closing of catch block
		// closing of transaction handling
	} 
?>

<?php 
	// isset for product update

	if(isset($_GET['productID'])){

		$productID 	= $_GET['productID'];
		$stID 		= $_GET['stID'];
		$mID 		= $_GET['mID'];

		$productData = Yii::$app->db->createCommand("
		SELECT *
		FROM  products
		WHERE product_id = $productID
		")->queryAll();
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
					<p style="font-weight:bolder;background-color:#d2d6de;padding:5px;text-align: center;color:#000000;font-size:15px;">
						Update Product<br>( <?php echo $productData[0]['product_name'];?> )
					</p>
					<div class="form-group">
						<label>Product</label>
						<input type="text" name="product_name" class="form-control" value="<?php echo $productData[0]['product_name'];?>">
						<label>Description</label>
						<input type="text" name="product_description" class="form-control" value="<?php echo $productData[0]['description'];?>">
						<input type="hidden" name="prodID" value="<?php echo $productData[0]['product_id'];?>">
						<input type="hidden" name="Stock_type_id" value="<?php echo $stID;?>">
					</div>
					<button name="update_product" class="btn btn-info btn-xs">
						<i class="glyphicon glyphicon-edit"></i><b> &nbsp;Update</b>
					</button>
					<a href="./stock-type-view?id=<?php echo $stID;?>" class="btn btn-danger btn-xs">
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
if(isset($_POST['update_product'])){

		$product_name  		 	= $_POST['product_name'];
		$product_description 	= $_POST['product_description'];
		$prodID 				= $_POST['prodID'];
		$Stock_type_id 			= $_POST['Stock_type_id'];

		// starting of transaction handling
		$transaction = \Yii::$app->db->beginTransaction();
		try {
			$updateProduct = Yii::$app->db->createCommand()->update('products',[
		     'product_name'      		=> $product_name,
		     'description'     => $product_description,
		     'updated_at' 				=> new \yii\db\Expression('NOW()'),
		     'updated_by'       		=> Yii::$app->user->identity->id,
	    ],['product_id' => $prodID])->execute();
        // transaction commit
        $transaction->commit();
        \Yii::$app->response->redirect(['./stock-type-view','id' => $Stock_type_id]);
		} // closing of try block 
		catch (Exception $e) {
			// transaction rollback
            $transaction->rollback();
		} // closing of catch block
		// closing of transaction handling
	} 
?>