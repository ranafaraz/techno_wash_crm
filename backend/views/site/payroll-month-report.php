<!DOCTYPE html>
<html>
<head>
	<title>PayRoll Report</title>
	<?php $this->title = 'PayRoll Report';?>

</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="box box-primary">
				<div class="box-header">
					<h2 style="text-align: center;">Employee Payroll Report</h2>
					<p style="text-align: center;background-color: lightgray;">EmpPayroll Report</p>
				</div><hr>
				<div class="box-body">
					<form method="POST">
						<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
						<div class="form-group">
							<label><i class="glyphicon glyphicon-calendar" style="color:#3C8DBC;"></i> Select Date:</label>
							<input type="month" name="report_date"   class="form-control" required >
						</div>
						<button class="btn btn-success btn-xs btn-block" type="submit" name="getEmp">View Report</button>
					</form>
				</div>
			</div>
		</div>
		<?php 
			if (isset($_POST["getEmp"])){
				$month = $_POST["report_date"];
				$month1 = date('m-Y',strtotime($month));
				$month2 = date('F-Y',strtotime($month));
				?>
				<div class="col-md-9">
				<div class="box box-primary">
					<div class="box-header">
						<h2 style="text-align: center;">Month:<?php echo $month2; ?> </h2>
						
					</div><hr>
					<div class="box-body">
						<?php 
						
						
							$payrollhead = Yii::$app->db->createCommand("SELECT eph.*,e.emp_name,e.monthly_salary FROM emp_payroll_head AS eph INNER JOIN employee AS e ON eph.emp_id = e.emp_id WHERE eph.payment_month = '$month1'
						")->queryAll();
							$countrow = count($payrollhead);
						?>
						<div class="table-responsive">
							<table class="table table-responsive">
								<thead>
									<tr>
										<th> Sr#</th>
										<th> Emp Name</th>
										<th> Monthly Salary</th>
										<th>Paid</th>
										<th> Status</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										for($i=0;$i<$countrow;$i++){  ?>
										<tr><?php $j=$i+1 ?>
											<td><?php echo $j;?></td>
											<td><?php echo $payrollhead[$i]['emp_name'];?></td>
											<td><?php echo $payrollhead[$i]['monthly_salary'];?></td>
											<td><?php echo $payrollhead[$i]['paid_amount'];?></td>
											<td><?php echo $payrollhead[$i]['status'];?></td>
										</tr>	
										<?php 
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		<?php	}
		?>
		</div>
</div>
</body>
</html>