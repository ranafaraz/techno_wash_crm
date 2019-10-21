<?php 
use common\models\Customer; 
use common\models\Branches;
use yii\helpers\Html;

$vehicleTypeID = $_GET['id'];


if(isset($_POST['insert_model']))
 { 
	$carmanufactureId  = $_POST['carmanufacture_id'];
	$modelName  = $_POST['model_name'];
	$user_id   =Yii::$app->user->identity->id;
	$count = count($modelName);
	echo $count ;
	die();
	for($i=0; $i<$count; $i++){
		if(!empty($modelName[$i])){
			$car_manufac = $carmanufactureId[$i];
			$model = $modelName[$i];
			 // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $insert_model = Yii::$app->db->createCommand()->insert('vehicle_type_sub_category',[
     'manufacture'      => $car_manufac,
     'name'      		=> $model,
     'created_at' 		=> new \yii\db\Expression('NOW()'),
     'updated_at' 		=> '0',
     'created_by'       => $user_id,
	 'updated_by' 		=> '0',
    ])->execute();
     // transaction commit
     $transaction->commit();
    Yii::$app->session->setFlash('success', "Model added successfuly");
        
     } // closing of try block 
     catch (Exception $e) {
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
		}
	}
	
	
}

// getting vehicle Type data
$vehicleTypeData = Yii::$app->db->createCommand("
SELECT *
FROM  vehicle_type
WHERE vehical_type_id = $vehicleTypeID
")->queryAll();

// getting car manufactures data
$carmanufactureData = Yii::$app->db->createCommand("
SELECT *
FROM  car_manufacture
WHERE vehical_type_id = $vehicleTypeID
")->queryAll();
$countcarmanufactureData = count($carmanufactureData);




// $this->title = 'Customer Profile';
// $this->params['breadcrumbs'][] = $this->title;

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<form action="./vehicle-type-view?id=1" method="POST">
<div class="container-fluid">
  	<div class="row">
	    <div class="col-md-9" style="margin-top: -20px">
	      <h2 style="color:#3C8DBC;"><?php echo "Vehicle Type: ".$vehicleTypeData[0]['name']; ?>
	      	<!-- <a href="./update-stock" class="btn btn-info btn-xs" style="">
					<i class="glyphicon glyphicon-edit"></i>  Update Stock
				</a> -->
	      </h2>
	    </div>
  	</div>
  	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="nav-tabs-custom">
			            <ul class="nav nav-tabs">
			            	<?php 
									for ($i=0; $i <$countcarmanufactureData ; $i++) { 
									$carmanufactureName = $carmanufactureData[$i]['manufacturer'];
									$carmanufactureID = $carmanufactureData[$i]['car_manufacture_id'];
									$vehicleSubData = Yii::$app->db->createCommand("
									SELECT *
									FROM  vehicle_type_sub_category
									WHERE manufacture = $carmanufactureID
									")->queryAll();

									$countvehicleSub = count($vehicleSubData);
							?>
				            <li class="">
				              	<a href="#<?php echo $carmanufactureName; ?>" data-toggle="tab">
				              		<?php echo $carmanufactureName; ?>&nbsp;<span class="badge"><?=$countvehicleSub;?></span>
				              	</a>
				            </li>
			            	<?php } ?>
			            </ul>
			            <div class="tab-content" style="background-color:#EFEFEF;">
			            	<?php 
								for ($i=0; $i <$countcarmanufactureData; $i++) { 

								$carmanufactureID = $carmanufactureData[$i]['car_manufacture_id'];
								$carmanufactureName = $carmanufactureData[$i]['manufacturer'];
								
								//getting vehicle type sub category
								$vehicleSubData = Yii::$app->db->createCommand("
								SELECT *
								FROM  vehicle_type_sub_category
								WHERE manufacture = $carmanufactureID
								")->queryAll();

								$countvehicleSub = count($vehicleSubData);

							?>
					        <div class="tab-pane" id="<?php echo $carmanufactureName;?>">
					            <div class="row">
					               	<div class="col-md-4">
					               		<p style="color:#3C8DBC;font-size:20px;">		<?php echo $carmanufactureName; ?>
					               		</p>
					               	</div>
				               		<div class="col-md-2">
				               			<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>"> 
				               			<input type="hidden" name="carmanufacture_id[]" id="carmanufacture_id" class="form-control" value="<?php echo $carmanufactureID; ?>">

				               			<label class="pull-right" style="margin-top: 6px;">Model Name:</label>
				               		</div>
					               	<div class="col-md-4">
					               		<div class="form-group">
											<input type="text" name="model_name[]" id="model_name" class="form-control">
										</div>
					               	</div>
					               	<div class="col-md-2">
					               		<button type="submit" name="insert_model" id="insert_btn" class="btn btn-success glyphicon glyphicon-plus"> Add Model</button>
					               	</div>
					            </div>
					            <div class="row">
					               	<div class="col-md-12">
					               		<table class="table table-bordered">
					               			<thead>
					               				<tr style="background-color: #3C8DBC;color: #fff;">
					               					<th>Sr.#</th>
					               					<th>Model Name</th>
					               				</tr>
					               			</thead>
					               			<?php 
												for ($j=0; $j <$countvehicleSub ; $j++) { 

											?>
					               			<tbody>
					               				<tr>
					               					<td><?=$j+1;?></td>
					               					<td style="background-color: #fff;"><?=$vehicleSubData[$j]['name'];?></td>
					               				</tr>
					               			</tbody>
					               			<?php } ?>
					               		</table>
					               	</div>
					            </div>
					        </div>
					        <!-- /.tab-pane -->
			            	
			            	<?php } ?>  
			            	</div>
			            	<!-- /.tab-content -->
	      				</div>
	      			<!-- /.nav-tabs-custom -->
				</div>
			</div>
		</div>
	</div>
</div>
</form>
</body>
</html>

