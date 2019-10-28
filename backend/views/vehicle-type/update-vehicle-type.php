<?php  
$vehicleTypeSubId = $_GET['VehTypeSubId'];
$carmanufacture_id = $_GET['manufacture_id'];
$vehicleTypeID = $_GET['VehTypeID'];

$carManufactureData = Yii::$app->db->createCommand("
	SELECT *
	FROM car_manufacture
	")->queryAll();
$countcarManufacture = count($carManufactureData);

$vehicleSubTypeData = Yii::$app->db->createCommand("
	SELECT *
	FROM vehicle_type_sub_category
	WHERE vehicle_typ_sub_id = '$vehicleTypeSubId'
	")->queryAll();
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Update VehicleType</title>
 </head>
 <body>
 
 <div class="container">
 	<div class="row">
 		<div class="col-md-12" style="text-align: center;font-family:georgia;color: #367FA9; font-size: 32px;">
 			<span>Update Vehicle (<b><?=$vehicleSubTypeData[0]['name']?></b>)</span>
 		</div>	
 	</div>
 	<form method="POST" action="">
 	<div class="row" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

 		<div class="col-md-4">
 			<div class="form-group">
        		<label>Select Car Manufacturer</label>
        		<select class="form-control" name="carManufacture">
        			<option value="">Select car manufacturer</option>
        			<?php 
        			for ($i=0; $i <$countcarManufacture ; $i++) {
        			?>
        			<option <?php if ($carManufactureData[$i]['car_manufacture_id'] == $vehicleTypeID ) {
        				echo "selected";
        			} ?> value="<?php echo $carManufactureData[$i]['car_manufacture_id']; ?>"><?php echo $carManufactureData[$i]['manufacturer'];  ?></option>
        			<?php } ?>
        		</select>
    		</div>
 		</div>
 		<div class="col-md-4">
 			<div class="form-group">
        		<label>Model Name</label>
        		<input type="text" class="form-control" name="Model_Name" value="<?=$vehicleSubTypeData[0]['name']?>">
    		</div>
    		<div class="col-md-4">
    			<input type="hidden" name="vehicleTypeId" class="form-control" value="<?=$vehicleTypeID?>"> 
    			<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
    			<input type="hidden" name="vehicleSubId" class="form-control" value="<?=$vehicleTypeSubId?>">

    		</div>
 		</div>
 		
 	</div>
 	<div class="row">
		<div class="col-md-1" style="margin-left: 20px;">
			<div class="form-group">
		 	<a href="./vehicle-type-view?id=<?=$vehicleTypeID?>" class="btn btn-danger">
		      	<i class="glyphicon glyphicon-backward"> <b>Back</b></i>
			</a>
			</div>		
		</div> 
		<div class="col-md-3">
			<button type="submit" name="update_vehicle" id="update" class="btn btn-success"><i class="glyphicon glyphicon-open"></i> Update Vehicle</button>		
		</div>		
 	</div>
 	</form>
 
 </div>

 </body>
 </html>
<?php

  if(isset($_POST['update_vehicle']))
 {
   $vehicleTypeID  		= $_POST['vehicleTypeId'];
   $carManufactureID    = $_POST['carManufacture'];
   $Model_Name    		= $_POST['Model_Name'];
   $vehicleSubID    	= $_POST['vehicleSubId'];

   $id   =Yii::$app->user->identity->id;

     // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $update_vehicle_sub_data = Yii::$app->db->createCommand()->update('vehicle_type_sub_category',[
     'manufacture'   => $carManufactureID,
     'name' 		 => $Model_Name,
    ],
       ['vehicle_typ_sub_id' => $vehicleSubID]

    )->execute();


     // transaction commit
     $transaction->commit();
     \Yii::$app->response->redirect(['./vehicle-type-view', 'id' => $vehicleTypeID]);
        
     } // closing of try block 
     catch (Exception $e) {
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
}

 ?>