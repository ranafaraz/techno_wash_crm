<?php 
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\AuthItem;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
 // $lastId = Yii::$app->db->createCommand('SELECT id,username FROM user ORDER BY id DESC LIMIT 1')->queryAll(); 
 // $user_id=$lastId[0]['id'];
 // $user_name=$lastId[0]['username'];
 // echo $user_id, $user_name;
 // 
  $id = $_GET["id"];

  $lastId = Yii::$app->db->createCommand("SELECT username FROM user WHERE id='$id'")->queryAll();
  $user_name=$lastId[0]["username"];
  echo $user_name;
?>
  	<div class="container-fluid">
	<form method="post">
		<div class="row">
			<div class="col-md-6">
				<label>User Name</label>
				<input type="text" name="username" value="<?php echo $user_name ?>" readonly="" class="form-control">
			</div>
			<div class="col-md-6">
				<label>Type</label>
				<input type="text" name="type" value="1" class="form-control" required="">
			</div>	
		</div>
		<div class="row">
			<div class="col-md-6">
				<label>Auth Item</label>
		        <?php 
		        echo Select2::widget([
				    'name' => 'name',
				    'value' => '',

				    'data' => ArrayHelper::map(AuthItem::find()->all(),'name','name'),
				    'options' => ['multiple' => true, 'placeholder' => 'Select ...', 'required' => 'required']
				]);
		    	?>
			</div>
			
			<div class="col-md-6">
				<label for="description">Description of the User</label>
				<textarea name="description" class="form-control" rows="5" required=""></textarea>
			</div>
		</div>
		<div class="row">
			
			<br>
			<div class="col-md-6">
			<button type="submit" class="btn btn-success" name="submit"> Save</button>
			</div>
		</div>
	</form>
	<?php 
		if (isset($_POST["submit"])) {
			$username=$_POST["username"];
			$type=$_POST["type"];
			$name=$_POST["name"];
			$description=$_POST["description"];
			$count_assignment = count($name);
			// Checking the user in auth iotem table
			$check_user = Yii::$app->db->createCommand("SELECT name FROM auth_item WHERE name='$username'")->queryAll();
			if (empty($check_user)) {
				 $insert_user = Yii::$app->db->createCommand()->insert('auth_item',[
    			//'exam_category_id' 		=> $exam_category,
				'name'					=>$username,
				'type'					=>$type,
				'description'			=>$description,
				
			])->execute();
				for ($i=0; $i < $count_assignment; $i++) {
					// Getting one name from the array
					$name1=$name[$i]; 
					// Query to check the 
					$check_user_child = Yii::$app->db->createCommand("SELECT child FROM auth_item_child WHERE child='$name1'  AND parent='$username'")->queryAll();
					if (empty($check_user_child)) {
						$insert_user_child = Yii::$app->db->createCommand()->insert('auth_item_child',[
		  				//'exam_category_id' 		=> $exam_category,
						'parent'   => $username,
						'child'    => $name[$i],
						])->execute();
					}
				}
				$check_user_assign = Yii::$app->db->createCommand("SELECT user_id FROM auth_assingment WHERE user_id='$id'")->queryAll();
				if (empty($check_user_assign)) {
					$insert_user_child = Yii::$app->db->createCommand()->insert('auth_assignment',[
	  				//'exam_category_id' 		=> $exam_category,
					'item_name'   => $username,
					'user_id'    => $id,
					])->execute();	
				}
			}
			else{
				for ($i=0; $i < $count_assignment; $i++) {
					// Getting one name from the array
					$name1=$name[$i]; 
					// Query to check the 
					$check_user_child = Yii::$app->db->createCommand("SELECT child FROM auth_item_child WHERE child='$name1' AND parent='$username'")->queryAll();
					if (empty($check_user_child)) {
						$insert_user_child = Yii::$app->db->createCommand()->insert('auth_item_child',[
		  				//'exam_category_id' 		=> $exam_category,
						'parent'   => $username,
						'child'    => $name[$i],
						])->execute();
					}
				}
				$check_user_assign = Yii::$app->db->createCommand("SELECT user_id FROM auth_assignment WHERE user_id='$id'")->queryAll();
				if (empty($check_user_assign)) {
					$insert_user_child = Yii::$app->db->createCommand()->insert('auth_assignment',[
	  				//'exam_category_id' 		=> $exam_category,
					'item_name'   => $username,
					'user_id'    => $id,
					])->execute();	
				}
			}
		}
	?>

	
</div>

</body>
</html>

