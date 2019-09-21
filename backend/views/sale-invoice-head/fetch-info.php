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
	    SELECT price
	    FROM services
	    WHERE services_id = $serviceID
	    ")->queryAll();

	   echo json_encode($services); 
 	}
	// else if(isset($_POST['session_Id'])){
	// $classId = $_POST['class_Id'];
	// $sessionId = $_POST['session_Id'];

 // 	$studentFeeDetail = Yii::$app->db->createCommand("SELECT admission_fee , tutuion_fee  FROM std_fee_pkg WHERE class_id = '$classId' AND session_id = '$sessionId'")->queryAll();
 // 	echo json_encode($studentFeeDetail);
	// } 
	// else {
	// 	$classId = $_POST['class_Id'];

	// 	$subjectsCombination = Yii::$app->db->createCommand("SELECT std_subject_id, std_subject_name FROM std_subjects WHERE class_id = '$classId'")->queryAll();
 // 	echo json_encode($subjectsCombination);
	// }

?>