<?php  
use yii\helpers\Html;
if(isset($_GET['VehTypeSubId'])){

  $vehicleTypeSubId = $_GET['VehTypeSubId'];
  // $carmanufacture_id = $_GET['manufacture_id'];
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
  <div class="container-fluid">
    <form method="post">
      <div class="row">
        <div class="col-md-4">
          <div class="box box-default" style="padding:10px;">
            <p style="font-weight:bolder;background-color:#d2d6de;padding:5px;text-align: center;color:#000000;font-size:15px;">Update Vehicle Model<br>( <?php echo $vehicleSubTypeData[0]['name'];?> )
            </p>
            <div class="form-group">
                <label>Model Name</label>
                <input type="text" class="form-control" name="Model_Name" value="<?=$vehicleSubTypeData[0]['name']?>">
            </div>
            <button type="submit" name="update_vehicle" id="update" class="btn btn-info btn-xs">
              
              <b> &nbsp;Update</b>
            </button>
           <a href="./vehicle-type-view?id=<?=$vehicleTypeID?>" class="btn btn-danger btn-xs">
            <i class="glyphicon glyphicon-backward"></i><b> &nbsp;Back</b>
            </a>
            <input type="hidden" name="vehicleTypeId" class="form-control" value="<?=$vehicleTypeID?>"> 
            <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
            <input type="hidden" name="vehicleSubId" class="form-control" value="<?=$vehicleTypeSubId?>">
          </div>
        </div>
      </div>
    </form>
  </div>
     </body>
     </html>

<?php
  }
if(isset($_POST['update_vehicle']))
{
   $vehicleTypeID  		= $_POST['vehicleTypeId'];
   $Model_Name    		= $_POST['Model_Name'];
   $vehicleSubID    	= $_POST['vehicleSubId'];

   $id   =Yii::$app->user->identity->id;

    // starting of transaction handling
    $transaction = \Yii::$app->db->beginTransaction();
    try {
      $update_vehicle_sub_data = Yii::$app->db->createCommand()->update('vehicle_type_sub_category',[
       'name' 		 => $Model_Name,
      ],
         ['vehicle_typ_sub_id' => $vehicleSubID]
      )->execute();
     // transaction commit
     $transaction->commit();
     \Yii::$app->response->redirect(['./vehicle-type-view', 'id' => $vehicleTypeID]);
        
    } // closing of try block 
    catch (Exception $e) {
      echo $e;
      // transaction rollback
      $transaction->rollback();
    } // closing of catch block
     // closing of transaction handling
}

?>
<?php

  if(isset($_GET['vdetail'])){

    $vdetail    = $_GET['vdetail'];
    $carmanu    = $_GET['carmanu'];
    $vehtyp     = $_GET['vehtyp'];
    $custVehid  = $_GET['custVehid'];

    // quert to fetch all vehicle type against vehicel  type id
    $selectedvehType = Yii::$app->db->createCommand("
    SELECT *
    FROM vehicle_type
    WHERE vehical_type_id = $vehtyp
    ")->queryAll();

    // quert to fetch all vehicle type 
    $vehTypeData = Yii::$app->db->createCommand("
    SELECT *
    FROM vehicle_type
    WHERE vehical_type_id != $vehtyp
    ")->queryAll();
    $countvehTypeData = count($vehTypeData);

    // quert to fetch all car manufactures against specific manufacture id
    $selectedCarManu = Yii::$app->db->createCommand("
    SELECT *
    FROM car_manufacture
    WHERE car_manufacture_id = $carmanu
    ")->queryAll();

    // quert to fetch all car manufactures
    $carManuData = Yii::$app->db->createCommand("
    SELECT *
    FROM car_manufacture
    WHERE car_manufacture_id != $carmanu
    ")->queryAll();
    $countcarManuData = count($carManuData);

    // quert to fetch all car models against specific vehicle detail id
    $selectedVehDetail = Yii::$app->db->createCommand("
    SELECT *
    FROM vehicle_type_sub_category
    WHERE vehicle_typ_sub_id = $vdetail
    ")->queryAll();

     // quert to fetch all car models
    $VehDetailData = Yii::$app->db->createCommand("
    SELECT *
    FROM vehicle_type_sub_category
    WHERE vehicle_typ_sub_id != $vdetail
    ")->queryAll();
    $countVehDetailData = count($VehDetailData);
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<div class="container-fluid">
  <form method="post" action="">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <h2 style="border-bottom:2px solid;text-align: center;padding-bottom:10px;">Update Vehical Data</h2>
        <div class="form-group">
          <label>Vehicle Type</label>
          <select class="form-control" name="vehicalTypeId" style="width: 85%;">
          <?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['vehical-type-create'],
                    ['role'=>'modal-remote','title'=> 'Create new Vehicle Types','class'=>'btn btn-success btn-xs']) ?>
            <option value="<?php echo $selectedvehType[0]['vehical_type_id'];?>">
              <?php echo $selectedvehType[0]['name']; ?>
            </option>
            <?php 
              for ($i=0; $i <$countvehTypeData ; $i++) { 
            ?>
            <option value="<?php echo $vehTypeData[$i]['vehical_type_id'];?>">
              <?php echo $vehTypeData[$i]['name']; ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group" style="text-align: right;margin-top:-50px; ">
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['./vehicle-type/create','carmanu'=>$carmanu, 'vdetail'=>$vdetail, 'custVehid'=>$custVehid],
                  ['role'=>'modal-remote','title'=> 'Create new Vehicle Types','class'=>'btn btn-success']) ?>
        </div>
        <div class="form-group">
          <label>Manufacture</label>
          <select class="form-control" name="manufactureID" style="width: 85%;">
            <option value="<?php echo $selectedCarManu[0]['car_manufacture_id'];?>">
              <?php echo $selectedCarManu[0]['manufacturer']; ?>
            </option>
            <?php 
              for ($c=0; $c <$countcarManuData ; $c++) { 
            ?>
            <option value="<?php echo $carManuData[$c]['car_manufacture_id'];?>">
              <?php echo $carManuData[$c]['manufacturer']; ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group" style="text-align: right;margin-top:-50px; ">
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['./car-manufacture/create','vehtyp'=>$vehtyp, 'vdetail'=>$vdetail, 'custVehid'=>$custVehid],
                  ['role'=>'modal-remote','title'=> 'Create new Car Manufacture','class'=>'btn btn-success']) ?>
        </div>
        <div class="form-group">
          <label>Model</label>
          <select class="form-control" name="modelId" style="width: 85%;">
             <option value="<?php echo $selectedVehDetail[0]['vehicle_typ_sub_id'];?>">
              <?php echo $selectedVehDetail[0]['name']; ?>
            </option>
            <?php 
              for ($m=0; $m <$countVehDetailData ; $m++) { 
            ?>
            <option value="<?php echo $VehDetailData[$m]['vehicle_typ_sub_id'];?>">
              <?php echo $VehDetailData[$m]['name']; ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group" style="text-align: right;margin-top:-50px; ">
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['./vehicle-type-sub-category/create','vehtyp'=>$vehtyp, 'carmanu'=>$carmanu, 'custVehid'=>$custVehid],
                  ['role'=>'modal-remote','title'=> 'Create new Model','class'=>'btn btn-success']) ?>
        </div>
        <button class="btn btn-xs btn-info" name="carUpdate">Update Car</button>
        <a href="./sale-invoice-view" class="btn btn-xs btn-danger">Back</a>
      </div>
    </div>
  </form>
</div>
</body>
</html>
<?php } 
  if(isset($_POST['carUpdate']))
{
   $vehicalTypeId = $_POST['vehicalTypeId'];
   $manufactureID = $_POST['manufactureID'];
   $modelId       = $_POST['modelId'];
   $id            =Yii::$app->user->identity->id;

   $CheckVehData = Yii::$app->db->createCommand("
   SELECT sub_cat_head_id
   FROM vehicle_type_sub_cat_head
   WHERE vehicle_type_id = $vehicalTypeId
   AND manufacture = $manufactureID
   ")->queryAll();

    // starting of transaction handling
    $transaction = \Yii::$app->db->beginTransaction();
    try {

      if(empty($CheckVehData)){

        $vehicleHead = Yii::$app->db->createCommand()->insert('vehicle_type_sub_cat_head',[
        //'branch_id'       => $branch_id,
        'vehicle_type_id' => $vehicalTypeId,
        'manufacture'     => $manufactureID,
        'created_at'      => new \yii\db\Expression('NOW()'),
        'created_by'      => $id,
        ])->execute();

        if ($vehicleHead) {
            $getvehicleHead = Yii::$app->db->createCommand("
            SELECT sub_cat_head_id
            FROM vehicle_type_sub_cat_head
            WHERE vehicle_type_id = $vehicalTypeId
            AND manufacture = $manufactureID
            ")->queryAll();
            $vHId = $getvehicleHead[0]['sub_cat_head_id'];

            $vehDEtail = Yii::$app->db->createCommand()->update('vehicle_type_sub_category',[
              //'branch_id'       => $branch_id,
              'sub_type_head_id' => $vHId,
              'updated_at'      => new \yii\db\Expression('NOW()'),
              'updated_by'      => $id,
              ],
              ['vehicle_typ_sub_id' => $modelId]
            )->execute();

            $customerVehicles = Yii::$app->db->createCommand()->update('customer_vehicles',[
              //'branch_id'       => $branch_id,
              'vehicle_typ_sub_id' => $modelId,
              'updated_at'      => new \yii\db\Expression('NOW()'),
              'updated_by'      => $id,
              ],
              ['customer_vehicle_id' => $custVehid]
            )->execute();
        }
      }
      else{
            $GetvehicleHead = Yii::$app->db->createCommand("
            SELECT sub_cat_head_id
            FROM vehicle_type_sub_cat_head
            WHERE vehicle_type_id = $vehicalTypeId
            AND manufacture = $manufactureID
            ")->queryAll();
            $VHID = $GetvehicleHead[0]['sub_cat_head_id'];

            $vehDEtail = Yii::$app->db->createCommand()->update('vehicle_type_sub_category',[
              //'branch_id'       => $branch_id,
              'sub_type_head_id' => $VHID,
              'updated_at'      => new \yii\db\Expression('NOW()'),
              'updated_by'      => $id,
              ],
              ['vehicle_typ_sub_id' => $modelId]
            )->execute();

            $customerVehicles = Yii::$app->db->createCommand()->update('customer_vehicles',[
              //'branch_id'       => $branch_id,
              'vehicle_typ_sub_id' => $modelId,
              'updated_at'      => new \yii\db\Expression('NOW()'),
              'updated_by'      => $id,
              ],
              ['customer_vehicle_id' => $custVehid]
            )->execute();  
      }
     // transaction commit
     $transaction->commit();
     \Yii::$app->response->redirect(['./sale-invoice-view']);
        
    } // closing of try block 
    catch (Exception $e) {
      echo $e;
      // transaction rollback
      $transaction->rollback();
    } // closing of catch block
     // closing of transaction handling
}

?>

<?php 

  // isset for vehicle type update

  if(isset($_GET['vehicleTypeID'])){

  $vehicleTypeID = $_GET['vehicleTypeID'];

  // getting vehicle Type data
  $vehicleTypeData = Yii::$app->db->createCommand("
  SELECT *
  FROM  vehicle_type
  WHERE vehical_type_id = $vehicleTypeID
  ")->queryAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <div class="container-fluid">
    <form method="post">
    <div class="row">
      <div class="col-md-4">
        <div class="box box-default" style="padding:10px;">
          <p style="font-weight:bolder;background-color:#d2d6de;padding:5px;text-align: center;color:#000000;font-size:15px;">Update Vehicle Type<br>( <?php echo $vehicleTypeData[0]['name'];?> )
          </p>
          <div class="form-group">
            <label>Vehicle Type</label>
            <input type="text" name="vehicleType" class="form-control" value="<?php echo $vehicleTypeData[0]['name'];?>">
            <label>Description</label>
            <input type="text" name="description" class="form-control" value="<?php echo $vehicleTypeData[0]['description'];?>">
            <input type="hidden" name="vtypid" value="<?php echo $vehicleTypeData[0]['vehical_type_id'];?>">
          </div>
          <button name="update_vehicleType" class="btn btn-info btn-xs">
            <i class="glyphicon glyphicon-edit"></i><b> &nbsp;Update</b>
          </button>
          <a href="./vehicle-type-view?id=<?php echo $vehicleTypeID;?>" class="btn btn-danger btn-xs">
                <i class="glyphicon glyphicon-backward"></i><b> &nbsp;Back</b>
          </a>
        </div>
      </div>
    </div>
    </form>
  </div>
</body>
</html>
<?php } 

  if(isset($_POST['update_vehicleType'])){
    $vehicleType   = $_POST['vehicleType'];
    $description = $_POST['description'];
    $vtypid     = $_POST['vtypid'];

    // starting of transaction handling
    $transaction = \Yii::$app->db->beginTransaction();
    try {
      $updateStockType = Yii::$app->db->createCommand()->update('vehicle_type',[
         'name'         => $vehicleType,
         'description'     => $description,
         'updated_at'         => new \yii\db\Expression('NOW()'),
         'updated_by'           => Yii::$app->user->identity->id,
      ],['vehical_type_id' => $vtypid])->execute();
        // transaction commit
        $transaction->commit();
        \Yii::$app->response->redirect(['./vehicle-type-view','id' => $vtypid]);
    } // closing of try block 
    catch (Exception $e) {
      // transaction rollback
            $transaction->rollback();
    } // closing of catch block
    // closing of transaction handling
  }

?>