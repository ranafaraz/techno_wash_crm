<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="box box-primary">
				<div class="box-header">
					<h2 style="text-align: center;">Employee Attendance</h2>
					<p style="text-align: center;background-color: lightgray;">For Absent Employee</p>
				</div><hr>
				<div class="box-body">
					<form method="POST">
						<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
						<div class="form-group">
							<label><i class="glyphicon glyphicon-calendar" style="color:#3C8DBC;"></i> Select Date:</label>
							<input type="date" name="date"   class="form-control" required >
						</div>
						<button class="btn btn-success btn-xs btn-block" type="submit" name="getEmp">View Report</button>
					</form>
				</div>
			</div>
		</div>
<?php 
	if(isset($_POST['getEmp'])){

		$date = $_POST['date'];

		$year = date('Y',strtotime($date));
		$month = date('M',strtotime($date));
		$day = date('l',strtotime($date));
		$dateformat = date('d-m-Y',strtotime($date));

		$branch_id = Yii::$app->user->identity->branch_id;

		$empAttId = array();
		$empIds = Yii::$app->db->createCommand("SELECT emp_id FROM emp_attendance WHERE att_date = '$date' AND branch_id = '$branch_id'")->queryAll();

		foreach ($empIds as $key => $value) {
			$empAttId[$key] = $value['emp_id'];
		}

		$empInfoId = array();
		$empIds_2 = Yii::$app->db->createCommand("SELECT emp_id FROM employee WHERE branch_id = '$branch_id'")->queryAll();
		foreach ($empIds_2 as $key => $value) {
			$empInfoId[$key] = $value['emp_id'];
		}
		$result = array();
		$result=array_diff($empInfoId,$empAttId);
		$resultCount = count($result);
		?>
	<div class="col-md-9">
		<?php 
		if (empty($result)) { ?>
			
				 <div class="alert alert-success">
  					Attendance already marked...!!!
				</div>		
		<?php }
		else{
		 ?>
		<div class="box box-primary">
			<div class="box-header" style="padding:0px;">
			 	<div class="row">
			 		<div class="col-md-12" style="text-align: center;">
			 			<h4>Date</h4>
			 			<p><?php echo $dateformat." "."(".$day.")";?></p>
			 		</div>
			 	</div>
			</div>
			<div class="box-body">
				<form method="POST" action="final-attendance">
					<table class="table table-hover">
						<thead>
							<tr style="background-color:lightgray;">
								<th>Sr.#</th>
								<th>Name</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$sr = 0;
								foreach ($result as $key => $value) {
								 	$empName = Yii::$app->db->createCommand("SELECT emp_name FROM employee
								 	WHERE emp_id = '$value'")->queryAll();
							 ?>
							<tr>
								<td><?php echo $sr+1; 
									$sr++;
								?></td>
								<td><?php echo $empName[0]['emp_name']; ?></td>
								<td>Not Updated</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
					<input type="hidden" name="date" value="<?php echo $date; ?>">
					<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">
					<?php 

					foreach ($result as $key => $valu) { ?>

						<input type="hidden" name="absent[]" value="<?php echo $valu; ?>">
					<?php } ?>
					<hr>
					<div class="row">
						<div class="col-md-2">
							<label>Comment</label>
						</div>
						<div class="col-md-6">
							<textarea name="comment" class="form-control">
							</textarea>
						</div>
						<div class="col-md-2">
							<button name="absent_emp" type="submit" class="btn btn-danger btn-sm" style="float: right;"><i class="glyphicon glyphicon-check"></i> Mark Absent</button>
						</div>
						<div class="col-md-2">
							<button name="holiday" type="submit" class="btn btn-success btn-sm" style="float: right;"><i class="glyphicon glyphicon-check"></i> Mark Holiday</button>
						</div>
					</div>
					
					
				</form>
			</div>
		</div>
	<?php } // closing of alert div ?>
	</div>
	<?php }  ?>
	<?php 


	if(isset($_POST['absent_emp']))
	{
		$absentDate = $_POST['date'];
		$employee_id = $_POST['absent'];
		$branch_id = $_POST['branch_id'];
		$comment = $_POST['comment'];
		$countEmployee_id = count($employee_id);

		$transection = Yii::$app->db->beginTransaction();
		try
		{

			for ($i=0; $i <$countEmployee_id ; $i++) { 
			$emp_absent = Yii::$app->db->createCommand()->insert('emp_attendance',[
						'branch_id'		=> $branch_id,		
            			'emp_id' 		=> $employee_id[$i],
						'att_date' 		=> $absentDate,
						'check_in' 		=> '00:00:00',
						'check_out'		=> '00:00:00' ,
						'attendance'	=> 'A',
						'comments'      => $comment,
						'created_at'	=> new \yii\db\Expression('NOW()'),
						'created_by'	=> Yii::$app->user->identity->id, 
					])->execute();
			}
		if($emp_absent){
			$transection->commit();
			Yii::$app->session->setFlash('success', "Absentees marked successfully...!!!");
			}
		} // closing of try
		catch(Exception $e){
			$transection->rollback();
			Yii::$app->session->setFlash('danger', "Not marked...Try again...!!!");
		} // closing of catch

	} // closing ifset for absent
	
	if(isset($_POST['holiday']))
	{
		$absentDate = $_POST['date'];
		$employee_id = $_POST['absent'];
		$branch_id = $_POST['branch_id'];
		$comment = $_POST['comment'];
		$countEmployee_id = count($employee_id);

		$transection = Yii::$app->db->beginTransaction();
		try
		{
			for ($i=0; $i <$countEmployee_id ; $i++) { 
			$emp_absent = Yii::$app->db->createCommand()->insert('emp_attendance',[
						'branch_id'		=> $branch_id,		
            			'emp_id' 		=> $employee_id[$i],
						'att_date' 		=> $absentDate,
						'check_in' 		=> '00:00:00',
						'check_out'		=> '00:00:00' ,
						'attendance'	=> 'H',
						'comments'      => $comment,
						'created_at'	=> new \yii\db\Expression('NOW()'),
						'created_by'	=> Yii::$app->user->identity->id, 
					])->execute();
			}
			if($emp_absent){
				$transection->commit();
				Yii::$app->session->setFlash('success', "Holiday marked successfully...!!!");
			}
		} // closing of try
		catch(Exception $e){
			$transection->rollback();
			Yii::$app->session->setFlash('danger', "Not marked...Try again...!!!");
		} // closing of catch
	} // closing ifset for holiday
?>
	</div>
</div>
</body>
</html>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

var timeout = 1500; // in miliseconds (3*1000)

$('.alert').delay(timeout).fadeOut(2000);
// $(function() {
// // setTimeout() function will be fired after page is loaded
// // it will wait for 5 sec. and then will fire
// // $("#successMessage").hide() function
    
//     $(".hide-it").hide(5000);

// });
</script>