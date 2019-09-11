<?php 


	$userId = Yii::$app->user->identity->id;
        //echo $userId;
    $userData = Yii::$app->db->createCommand("SELECT *
    FROM user
    WHERE id = '$userId'")->queryAll();
    $userInfo = $userData[0]['first_name'];

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
			<h2 class="well well-sm">Edit Profile</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-default">
				<div class="box-body">
					<form method="post" action="./edit-profile" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>First Name</label>
									<input type="text" name="first_name" class="form-control" value="<?php echo $userData[0]['first_name'];?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" value="<?php echo $userData[0]['last_name'];?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>User Name</label>
									<input type="text" name="user_name" class="form-control" value="<?php echo $userData[0]['username'];?>">
								</div>
							</div>
						</div>
						<!-- row 1 end -->
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Email</label>
									<input type="text" name="email" class="form-control" value="<?php echo $userData[0]['email'];?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Photo</label>
									<input type="file" name="photo" class="form-control">
								</div>
							</div>
						</div>
						<!-- row 2 end -->
						<div class="row">
							<div class="col-md-4">
								<button name="save" type="submit" class="btn btn-info btn-sm">Save Changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php 

	if(isset($_POST['save']))
	{
		$first_name 	= $_POST['first_name'];
		$last_name 		= $_POST['last_name'];
		$email 			= $_POST['email'];
		$user_name 		= $_POST['user_name'];
		$photo 			= $_POST['photo'];

		// $target_dir = "uploads/";
		// $target_file = $target_dir . basename($_FILES["photo"]["name"]);
		// $uploadOk = 1;
		// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// // Check if image file is a actual image or fake image
		// if(isset($_POST["submit"])) {
		//     $check = getimagesize($_FILES["photo"]["tmp_name"]);
		//     if($check !== false) {
		//         echo "File is an image - " . $check["mime"] . ".";
		//         $uploadOk = 1;
		//     } else {
		//         echo "File is not an image.";
		//         $uploadOk = 0;
		//     }
//}


	$transection = Yii::$app->db->beginTransaction();

	try {

		$profileUpdate = Yii::$app->db->createCommand()->update('user', [
		'first_name'		=> $first_name,
		'last_name'			=> $last_name,
		'email'				=> $email,
		'username'			=> $user_name,
		//'updated_by'		=> Yii::$app->user->identity->id,
		'updated_at'		=> new \yii\db\Expression('NOW()'),
        ],
        ['id' => $userId]
    	)->execute();
    	if ($profileUpdate) {
    		$transection->commit();
			Yii::$app->session->setFlash('success', "Profile successfully...!");
    	}
	} catch (Exception $e) {
		$transection->rollback();
		echo $e;
		Yii::$app->session->setFlash('warning', "Not updated. Try again!");
		
	}

}// isset close

 ?>