<?php 

	$branch_id = Yii::$app->user->identity->branch_id;
	$empInfo = Yii::$app->db->createCommand("SELECT * FROM emp_info WHERE emp_branch_id = '$branch_id'")->queryAll();
	$countEmp = count($empInfo);

 ?>
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
					<h2 style="text-align: center;">Attendance Report</h2>
					<p style="text-align: center;background-color:lightgray;">Monthly</p>
				</div><hr>
				<div class="box-body">
					<form method="POST" action="emp-att-report">
						<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
						<div class="form-group">
							<label><i class="glyphicon glyphicon-user" style="color:#3C8DBC;"></i> Select Employee</label>
							<select name="empId" class="form-control" required>
								<option value="">-- Select Employee --</option>
								<?php  

								for ($i=0; $i <$countEmp ; $i++) { 
									$empName = $empInfo[$i]['emp_name'];
								?>
								<option value="<?php echo $empInfo[$i]['emp_id']; ?>">
									<?php echo $empName; ?>
								</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label><i class="glyphicon glyphicon-calendar" style="color:#3C8DBC;"></i> Select Month</label>
							<input type="month" name="month_report" class="form-control" required>
						</div>
						<button class="btn btn-success btn-xs btn-block" type="submit" name="report"><i class="glyphicon glyphicon-eye-open"></i> View Report</button>
					</form>
				</div>
			</div>
		</div>
		<?php 

		if(isset($_POST['report'])){

			$emp_id = $_POST['empId'];
			$month_report = $_POST['month_report'];

			$empWorkingDays = Yii::$app->db->createCommand("SELECT attendance FROM emp_attendance WHERE emp_id = '$emp_id' AND  DATE_FORMAT(att_Date ,'%Y-%m') = '$month_report'")->queryAll();
			$countWorkingDays = count($empWorkingDays);

			$empPresentDays = Yii::$app->db->createCommand("SELECT attendance FROM emp_attendance WHERE emp_id = '$emp_id' AND  DATE_FORMAT(att_Date ,'%Y-%m') = '$month_report' AND attendance = 'P'")->queryAll();
			$countPresentDays = count($empPresentDays);

			$empAbsentDays = Yii::$app->db->createCommand("SELECT attendance FROM emp_attendance WHERE emp_id = '$emp_id' AND  DATE_FORMAT(att_Date ,'%Y-%m') = '$month_report'  AND attendance = 'A'")->queryAll();
			$countAbsentDays = count($empAbsentDays);

			$empLeaveDays = Yii::$app->db->createCommand("SELECT attendance FROM emp_attendance WHERE emp_id = '$emp_id' AND  DATE_FORMAT(att_Date ,'%Y-%m') = '$month_report'   AND attendance = 'L'")->queryAll();
			$countLeaveDays = count($empLeaveDays);

			$dateformat = date('d-m-Y',strtotime($month_report));
			$year = date('Y',strtotime($month_report));
			$month = date('m',strtotime($month_report));

			$dateObj   = DateTime::createFromFormat('!m', $month);
			$month_name = $dateObj->format('F');
			$days = cal_days_in_month(CAL_GREGORIAN, $month,$year);
			

 		?>
		<div class="col-md-9">
			<div class="box box-primary">
				<div class="box-header" style="text-align: center;">
					<h2 style="color:#3C8DBC;font-family:georgia;">Report For the Month (<?php echo $month_name; ?> )</h2><hr>
						<div class="col-md-12" style="font-family:verdana;">
							<p>
								<?php
								$empName = Yii::$app->db->createCommand("SELECT emp_name FROM emp_info WHERE emp_id = '$emp_id'")->queryAll();
								echo "<b>".$empName[0]['emp_name']."</b>";?>
							</p>
						</div>
						<div class="col-md-12" style="margin-bottom:0px;">
						</div>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<tr style="">
								<th style="background-color: lightgray;font-size:20px;text-align: center;border-radius:10px;">Statistics</th>
								<th>Working Days <span class="label label-primary"><?php echo $countWorkingDays; ?></span></th>
								<th>Present <span class="label label-success"><?php echo $countPresentDays; ?></span>
								</th>
								<th>Absents <span class="label label-danger"><?php echo $countAbsentDays; ?></span>
								</th>
								<th>Leaves <span class="label label-warning"><?php echo $countLeaveDays; ?></span>
								</th>
							</tr>
							<tr style="background-color:#3C8DBC;color:white;">
								<th>Sr.#</th>
								<th>Date</th>
								<th>Day</th>
								<th>Attendance</th>
								<th>Check In</th>
								<th>Check Out</th>
							</tr>
						</thead>
						<tbody>
							<?php 

							for($i = 1; $i<= $days; $i++){
								$var = $year."-".$month."-".$i;
							   	$day  = date('Y-m-d',strtotime($var));
							   	$dayName  = date('l',strtotime($var));
							   	$attReport = Yii::$app->db->createCommand("SELECT * FROM emp_attendance WHERE emp_id = '$emp_id' AND att_date = '$day'")->queryAll();
							   	$result = date("l", strtotime($day));

							   	 if ($dayName == "Sunday") {
							 ?>
							
							<tr style="background-color:#e5a9b1;">
								<td><?php echo $i; ?></td>
								<td>
									<?php 
									 echo date('d-m-Y',strtotime($day));
									?>
								</td>
								<td>
									<?php 
										echo $dayName;
									?>	
								</td>
								<td>
									<?php 
									if(empty($attReport)){
										echo "--";
									} else {
										echo $attReport[0]['attendance'];
									}
								 	?>
								 </td>
								<td><?php 
								 if(empty($attReport) || $attReport[0]['check_in'] == '00:00:00'){
										echo "--";
									} else {
										echo $attReport[0]['check_in'];
									}
								 	?>
								 </td>
								 <td><?php 
								 if(empty($attReport) || $attReport[0]['check_out'] == '00:00:00'){
										echo "--";
									} else {
										echo $attReport[0]['check_out'];
									}
								 	?>
								 </td>
							</tr>
							<?php } else { ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td>
									<?php 
									 echo date('d-m-Y',strtotime($day));
									?>
								</td>
								<td>
									<?php 
									echo $dayName;
									?>	
								</td>
								<td>
									<?php 
									if(empty($attReport)){
										echo "--";
									} else {
										echo $attReport[0]['attendance'];
									}

								 	?>
								 </td>
								 <td><?php 
								 if(empty($attReport) || $attReport[0]['check_in'] == '00:00:00'){
										echo "--";
									} else {
										echo $attReport[0]['check_in'];
									}
								 	?>
								 </td>
								 <td><?php 
								 if(empty($attReport) || $attReport[0]['check_out'] == '00:00:00'){
										echo "--";
									} else {
										echo $attReport[0]['check_out'];
									}
								 	?>
								 </td>
							</tr>
							<?php } } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
</body>
</html>