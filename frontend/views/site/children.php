<?php 

	$guardianCnic = Yii::$app->user->identity->username;
	$childrenIds = Yii::$app->db->createCommand("SELECT std_id FROM std_guardian_info WHERE guardian_cnic = '$guardianCnic'")->queryAll();
	$countChildrens = count($childrenIds);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
	<?php 
	for ($j=0; $j <$countChildrens ; $j++) { 
		$childrenID = $childrenIds[$j]['std_id'];
	$childrenData = Yii::$app->db->createCommand("SELECT * FROM std_personal_info WHERE std_id = '$childrenID'")->queryAll();
	$childPhoto = $childrenData[0]['std_photo'];
	$std_b_form = $childrenData[0]['std_b_form'];
	 ?>
		<div class="col-md-4">
			<div class="box box-default">
				<div class="box-header">
					<img class="profile-user-img img-responsive img-circle" src="<?php echo './backend/web/'.$childPhoto; ?>">
					<h4 class="text-center">
						<a href="./std-profile?std_b_form=<?php echo $std_b_form; ?>">
						<?php echo $childrenData[0]['std_name']; ?>
						</a>
					</h4>
					<p class="text-center"><?php echo $childrenData[0]['std_reg_no']; ?></p>
					<table class="table">
					<tr style="text-align: center">
						<td colspan="2"> <a href="./std-profile?std_b_form=<?php echo $std_b_form; ?>" class="btn btn-success btn-block"><i class="glyphicon glyphicon-user"> </i> Profile</a> </td>
					</tr>
					<tr>
						<td colspan="2"> <a href="./fee-details?std_b_form=<?php echo $std_b_form; ?>" class="btn btn-primary btn-block"><i class="fa fa-money"> </i> Fees</a> </td>
					</tr>
					<tr>
						<td colspan="2"> <a href="./std-profile?std_b_form=<?php echo $std_b_form; ?>" class="btn btn-warning btn-block"><i class="fa fa-book"> </i> Exams</a> </td>
					</tr>
					<tr>
						<td colspan="2"> <a href="./std-time-table-view?std_b_form=<?php echo $std_b_form; ?>" class="btn btn-block" style='background-color: #990099;color:white;'><i class="fa fa-calendar"> </i> Time Table</a> </td>
					</tr>
					<tr>
						<td colspan="2"> <a href="./std-profile?std_b_form=<?php echo $std_b_form; ?>" class="btn btn-info btn-block"><i class="fa fa-book"> </i> Homework</a> </td>
					</tr>
					<tr>
						<td colspan="2"> <a href="./std-profile?std_b_form=<?php echo $std_b_form; ?>" class="btn btn-danger btn-block"><i class="fa fa-check-square-o"> </i> Attendance</a> </td>
					</tr>
					</table>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</div>
</body>
</html>