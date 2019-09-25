<?php 

	if(isset($_POST['stock_type'])){
	$stock_type = $_POST['stock_type'];

 	$stockType = Yii::$app->db->createCommand("SELECT *
 		FROM stock_type
 		WHERE stock_type_id = '$barcode'")->queryAll();
 	echo json_encode($stockType);
 	}

 ?>