<?php 
	$std_id=$_GET["std_id"];
	$class_head_id=$_GET["class"];
	// Getting the class_id session_id,section_id from the enrollment head
	$ClassDetail = Yii::$app->db->createCommand("SELECT class_name_id,session_id,section_id FROM std_enrollment_head WHERE std_enroll_head_id = '$class_head_id'")->queryAll();
	$class_id=$ClassDetail[0]['class_name_id'];
	$session_id=$ClassDetail[0]['session_id'];
	$section_id=$ClassDetail[0]['section_id'];
	$ClassDetail = Yii::$app->db->createCommand("SELECT fmd.month,fth.total_amount,fth.paid_amount,fth.remaining,fth.status,fth.voucher_no FROM fee_month_detail AS fmd INNER JOIN fee_transaction_head AS fth ON fth.voucher_no=fmd.voucher_no WHERE fth.std_id='$std_id' AND fth.class_name_id='$class_id' AND fth.session_id='$session_id' AND fth.section_id='$section_id'")->queryAll();
	// Count the no of the month the vouchers are submi
	$count_class_detail=count($ClassDetail);
	//echo $count_class_detail;
?>



<!DOCTYPE html>
<html>
<head>
	<title>Std Fee Details</title>
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
					<form action="std-fee"></form>
					<table class="table table-hover">
						<thead>
							<tr>
                              <th>Voucher No</th>
                              <th>Month</th>
                              <th>Issue Date</th>
                              <th> Due Date</th>
                              <th>Amount</th>                 
                              <th>Paid Amount</th>
                              <th>Remaining Amount</th>
                              <th>Status</th>
                            </tr>
						</thead>
						<tbody>
							<?php 
								for ($i=0; $i < $count_class_detail ; $i++) {
									// For getting the name of the month
									$voucher=$ClassDetail[$i]['month'];
                                    $month=date("F - Y",strtotime($voucher));
                                    if ($ClassDetail[$i]['status']=='Added to next month') {
                                    	$label='label label-info';
                                    }
                                    elseif ($ClassDetail[$i]['status']=='Paid') {
                                    	$label='label label-success';
                                    }
                                    elseif ($ClassDetail[$i]['status']=='Unpaid') {
                                    	$label='label label-danger';
                                    }
                                    elseif ($ClassDetail[$i]['status']=='Partially Paid') {
                                    	$label='label label-warning';
                                    }
									?>
									<tr>
										<td><?php echo $ClassDetail[$i]['voucher_no']; ?></td>
										<td><?php echo $month; ?></td>	
										<td>---------</td>
										<td>---------</td>
										<td><?php echo $ClassDetail[$i]['total_amount']; ?></td>
										<td><?php echo $ClassDetail[$i]['paid_amount']; ?></td>
										<td><?php echo $ClassDetail[$i]['remaining']; ?></td>
										<td><span class="<?php echo $label; ?>"><?php echo $ClassDetail[$i]['status']; ?></span></td>
										
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