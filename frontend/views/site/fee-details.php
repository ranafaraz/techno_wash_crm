<?php 
	if (isset($_GET["std_b_form"])) {
		$std_b_form=$_GET["std_b_form"];
	}
	else{
		$std_b_form = Yii::$app->user->identity->username;
	}
  
    // Getting the student id from the Std personal info
    $stdPersonalInfo = Yii::$app->db->createCommand("SELECT std_id FROM std_personal_info WHERE std_b_form = '$std_b_form'")->queryAll();
  	
    $id =  $stdPersonalInfo[0]['std_id'];
    // Getting all the classes of the student
    // h is for std_enrollment_head and d is for std_enrollment details
    $stdClass=Yii::$app->db->createCommand("SELECT h.std_enroll_head_id,h.std_enroll_head_name FROM std_enrollment_head AS h INNER JOIN std_enrollment_detail AS d ON d.std_enroll_detail_head_id = h.std_enroll_head_id WHERE  d.std_enroll_detail_std_id='$id'")->queryAll();
    //$std_class is for no of classes in which student is enrolled
    $count_std_class=count($stdClass);
    
    
?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-success">
				<div class="box-header" style="text-align: center;">
					<h4>Month Wise Fee Report</h4>
				</div><hr>
				<div class="box-body">
					
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Sr.#</th>
								<th>Class</th>
							
							</tr>
						</thead>
						<tbody>
							<?php 
							// Fetching data from the above sql Query
								for ($i=0; $i <$count_std_class ; $i++) { 
										$class_head_id=$stdClass[$i]['std_enroll_head_id'];
							?>	
							<tr>
								<td><?php echo $i+1; ?></td>
								<td>
								<a href="./std-fee?class=<?php echo $class_head_id ?>&std_id=<?php echo $id ?>"> <?php echo $stdClass[$i]['std_enroll_head_name'] ; ?></a>
								</td>
								<td><a href="./std-fee?class=<?php echo $class_head_id ?>&std_id=<?php echo $id ?>" class=" btn btn-warning"> <i class="glyphicon glyphicon-eye-open"></i> View</a></td>
								
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>