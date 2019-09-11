<?php 

	$branch_id = Yii::$app->user->identity->branch_id;
	// $empInfo = Yii::$app->db->createCommand("SELECT * FROM emp_info WHERE emp_branch_id = '$branch_id'")->queryAll();
	// $countEmp = count($empInfo);

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
        <!-- back button start -->
         <ol class="breadcrumb">
            <li><a class="btn btn-primary btn-xs" href="./employee-portfolio"><i class="fa fa-backward"></i> Back</a></li>
          </ol>
        <!-- back button close -->
      </div>
  	</div>
	<div class="row">
		
		<?php 

		if(isset($_GET['empID'])){

			$emp_id = $_GET['empID'];
			$month 	= $_GET['month'];
			$year 	= $_GET['year'];

			$empWorkingDays = Yii::$app->db->createCommand("SELECT * FROM emp_attendance
				WHERE branch_id = '$branch_id'
				AND emp_id = '$emp_id'
				AND MONTH(att_date) = '$month'
				AND YEAR(att_date) = '$year'")->queryAll();
			$countWorkingDays = count($empWorkingDays);

			$empPresentDays = Yii::$app->db->createCommand("SELECT * FROM emp_attendance
				WHERE branch_id = '$branch_id'
				AND emp_id = '$emp_id'
				AND MONTH(att_date) = '$month'
				AND YEAR(att_date) = '$year'
				AND attendance = 'P'")->queryAll();
			$countPresentDays = count($empPresentDays);

			$empAbsentDays = Yii::$app->db->createCommand("SELECT * FROM emp_attendance
				WHERE branch_id = '$branch_id'
				AND emp_id = '$emp_id'
				AND MONTH(att_date) = '$month'
				AND YEAR(att_date) = '$year'
				AND attendance = 'A'")->queryAll();
			$countAbsentDays = count($empAbsentDays);

			$empLeaveDays = Yii::$app->db->createCommand("SELECT * FROM emp_attendance
				WHERE branch_id = '$branch_id'
				AND emp_id = '$emp_id'
				AND MONTH(att_date) = '$month'
				AND YEAR(att_date) = '$year'
				AND attendance = 'L'")->queryAll();
			$countLeaveDays = count($empLeaveDays);

			// $dateformat = date('d-m-Y',strtotime($month_report));
			// $year = date('Y',strtotime($month_report));
			// $month = date('m',strtotime($month_report));

			$dateObj   = DateTime::createFromFormat('!m', $month);
			$month_name = $dateObj->format('F');
			$days = cal_days_in_month(CAL_GREGORIAN, $month,$year);
			

 		?>
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header" style="text-align: center;">
					<h2 style="color:#3C8DBC;font-family:georgia;">Attendance Report [ For the Month (<?php echo $month_name; ?> ) ]</h2><hr>
					<p style="background-color:lightgray;padding:10px;font-size:20px;">
						<?php
						$empName = Yii::$app->db->createCommand("SELECT emp_name FROM emp_info WHERE emp_id = '$emp_id'")->queryAll();
						echo "<b>".$empName[0]['emp_name']."</b>";?>
					</p>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="background-color:#efdcc2;">Working Days 
										</th>
										<td align="center">
											<span class="label label-primary"><?php echo $countWorkingDays; ?>
											</span>
										</td>
									</tr>
									<tr>
										<th style="background-color:#efdcc2;">Present Days 
										</th>
										<td align="center">
											<span class="label label-success"><?php echo $countPresentDays; ?>
											</span>
										</td>
									</tr>
								</thead>
							</table>	
						</div>
						<div class="col-md-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="background-color:#efdcc2;">Absent Days 
										</th>
										<td align="center">
											<span class="label label-danger"><?php echo $countAbsentDays; ?>
											</span>
										</td>
									</tr>
									<tr>
										<th style="background-color:#efdcc2;">Leave Days 
										</th>
										<td align="center">
											<span class="label label-warning"><?php echo $countLeaveDays; ?>
											</span>
										</td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="table-responsive">
					<table class="table table-hover">
						<thead>
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
		</div>
		<?php } ?>
	</div>
</div>
</body>
</html>