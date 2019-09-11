<?php $id = Yii::$app->user->identity->id;
$user = Yii::$app->db->createCommand("SELECT *
		FROM  user
		WHERE id = '$id'
		")->queryAll();

	$branchId = $user[0]['branch_id']; 
	$branchName = Yii::$app->db->createCommand("SELECT branch_name
		FROM  branches
		WHERE branch_id = '$branchId'
		")->queryAll();

	//print_r($branchName);

 ?>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container-fluid">
		<div class="well well-sm" style="border-left:2px solid;border-radius:10px;">
		<h4 style="font-weight:bolder;"><i class="glyphicon glyphicon-hand-right"></i> User Profile</h4>
	</div>
	<div class="box box-primary col-md-12">
		<div class="box-header">
		
		</div>
		<div class="box-body">
			<table>
				<tr>
					<th>First Name: </th>
					<td> <?php echo $user[0]['first_name']; ?></td>
				</tr>
				<tr>
					<th>Last Name: </th>
					<td> <?php echo $user[0]['last_name']; ?></td>
				</tr>
				<tr>
					<th>User Name: </th>
					<td> <?php echo $user[0]['username']; ?></td>
				</tr>
				<tr>
					<th>Email: </th>
					<td> <?php echo $user[0]['email']; ?></td>
				</tr>
				<tr>
					<th>Branch: </th>
					<td> <?php echo $branchName[0]['branch_name']; ?></td>
				</tr>
				<tr>
					<th></th>
				</tr>
				<tr>
					<th></th>
				</tr>
			</table>
		</div>
	</div>
	</div>
</body>
</html>