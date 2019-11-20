
<?php if (isset($_GET['head_id'])) {

		$headID = $_GET['head_id'];
		$headData =Yii::$app->db->createCommand("SELECT * from emp_payroll_head 
			WHERE payroll_head_id = '$headID'")->queryAll();
		$empID = $headData[0]['emp_id'];

		$empData =Yii::$app->db->createCommand("SELECT * from employee 
			WHERE emp_id = '$empID'")->queryAll();
		$empTypeID = $empData[0]['emp_type_id'];

		$empTypeData =Yii::$app->db->createCommand("SELECT * from employee_types 
			WHERE emp_type_id = '$empTypeID'")->queryAll();

		$headdetailData =Yii::$app->db->createCommand("SELECT * from emp_payroll_detail 
			WHERE payroll_head_id = '$headID'")->queryAll();
		$countheaddetailData = count($headdetailData);
} ?>

<!DOCTYPE html>
<html>
<head>
	<title>Employee PayRoll</title>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="margin-top: -20px">
				<h2>
		      	<a href="./employee-detail-view?id=<?=$empID;?>" class="btn btn-success">
		      		<i class="glyphicon glyphicon-backward"> <b>Back</b></i>
				</a></h2>
				<div class="row">
					<div class="col-md-4 col-md-offset-4" style="background-color: grey;color: #fff;padding-bottom: 10px;">
					<h3 class="text-center">Employee PayRoll</h3>
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">

						<div class="row" style="padding: 10px 0px;">
							<div class="col-md-2">
								<span style="padding-right: 5px !important;"><b>Employee Name:</b></span>
							</div>
							<div class="col-md-3" style="border-bottom: 2px solid black;">
								<span><?=$empData[0]['emp_name'];?></span>
							</div>
							<div class="col-md-1">
								
							</div>
							<div class="col-md-2">
								<span><b>Designation:</b></span>
							</div>
							<div class="col-md-3" style="border-bottom: 2px solid black;">
								<span><?=$empTypeData[0]['emp_type_name'];?></span>
							</div>
						</div>

						<div class="row" style="padding: 10px 0px;">
							<div class="col-md-2">
								<span style="padding-right: 5px !important;"><b>Month & Year:</b></span>
							</div>
							<div class="col-md-3" style="border-bottom: 2px solid black;">
								<span><?=$headData[0]['payment_month'];?>-<?=$headData[0]['payment_year'];?></span>
							</div>
							<div class="col-md-1">
								
							</div>
							<div class="col-md-2">
								<span><b>Total Pay:</b></span>
							</div>
							<div class="col-md-3" style="border-bottom: 2px solid black;">
								<span><?=$headData[0]['total_calculated_pay'];?></span>
							</div>
						</div>

					</div>
				</div>
				<div class="table-responsive" style="margin-top: 20px;">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="background-color: #367FA9;color: #fff;">Sr.#</th>
							<th style="background-color: #367FA9;color: #fff;">Transaction Date</th>
							<th style="background-color: #367FA9;color: #fff;">Paid Amount</th>
							<th style="background-color: #367FA9;color: #fff;">Status</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
							for ($i=0; $i <$countheaddetailData ; $i++) { 

								?>
								<tr>
									<td><?php echo $i+1;?></td>
									<td><?php echo $headdetailData[$i]['transaction_date'];?></td>
									<td><?php echo $headdetailData[$i]['paid_amount'];?></td>
									<td><?php echo $headdetailData[$i]['status'];?></td>

								</tr>
						<?php	}

						?>
					</tbody>
				</table>
			  </div>
				
				<div class="row">
					<div class="col-md-4">
						
					</div>
					<div class="col-md-8">
						<div class="table-responsive">
							<table class="table table-sm table-bordered">
								<tbody>
									<tr>
										<th style="width: 25%;">Over Time:</th>
										<td style="width: 25%;"><?=$headData[0]['over_time'];?></td>
										<th style="width: 25%;">Over Time Pay:</th>
										<td style="width: 25%;"><?=$headData[0]['over_time_pay'];?></td>
									</tr>
									<tr>
										<th style="width: 25%;">Bonus:</th>
										<td style="width: 25%;"><?=$headData[0]['bonus'];?></td>
										<th style="width: 25%;">Tax Deduction:</th>
										<td style="width: 25%;"><?=$headData[0]['tax_deduction'];?></td>
									</tr>
									<tr>
										<th style="width: 25%;">Relaxation:</th>
										<td style="width: 25%;"><?=$headData[0]['relaxation'];?></td>
										<th style="width: 25%;">Net Total:</th>
										<td style="width: 25%;"><?=$headData[0]['net_total'];?></td>
									</tr>
									<tr>
										<th style="width: 25%;">Paid Amount:</th>
										<td style="width: 25%;"><?=$headData[0]['paid_amount'];?></td>
										<th style="width: 25%;">Remaining:</th>
										<td style="width: 25%;"><?=$headData[0]['remaining'];?></td>
									</tr>
									<tr>
										<th colspan="2" class="text-center" style="width: 50%;background-color: grey;color: #fff;">Status:</th>
										<td colspan="2" class="text-center" style="width: 50%; background-color: lightgray;"><?=$headData[0]['status'];?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</body>
</html>
