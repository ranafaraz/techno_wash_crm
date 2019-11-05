<?php 
if(isset($_POST['cnic'])){
	$cnic = $_POST['cnic'];
	$empCnic = Yii::$app->db->createCommand(" SELECT emp_id FROM emp_info WHERE emp_cnic = '$cnic' ")->queryAll();
	
	if(empty($empCnic)){
		$result = '[0]';
	} else {
		$result = '[1]';
	}
	echo json_encode($result); 
}
?>
