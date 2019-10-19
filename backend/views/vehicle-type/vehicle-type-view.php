<?php 
use common\models\Customer; 
use common\models\Branches;
use yii\helpers\Html;

$vehicleTypeID = $_GET['id'];

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
									for ($i=0; $i <$countcarmanufactureData ; $i++) { 

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
					            <div class="tab-pane" id="<?php echo $carmanufactureName; ?>">
					               <div class="row">
					               	<div class="col-md-8">
					               		 <p style="color:#3C8DBC;font-size:20px;"><?php echo $carmanufactureName; ?>
					               		 </p>
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
												for ($i=0; $i <$countvehicleSub ; $i++) { 

											?>
					               			
					               			<tbody>
					               				<tr>
					               					<td><?=$i+1;?></td>
					               					<td style="background-color: #fff;"><?=$vehicleSubData[$i]['name'];?></td>
					               				</tr>
					               			</tbody>
					               		<?php } ?>
					               		</table>
					               	</div>
					               </div>
					            </div>
			            <?php } ?>
					              <!-- /.tab-pane -->
			            </div>
			            <!-- /.tab-content -->
	      		</div>
	      			<!-- /.nav-tabs-custom -->
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
