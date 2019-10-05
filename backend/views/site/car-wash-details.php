<?php 
	$currentDate = date('Y-m-d');
	$serviceID = $_GET['serviceID'];

	$serviceName  = Yii::$app->db->createCommand("
    SELECT name
    FROM services
    WHERE services_id = '$serviceID'
    ")->queryAll();

	$vehicleTypes  = Yii::$app->db->createCommand("
    SELECT *
    FROM vehicle_type
    ")->queryAll();
    $countVehicleTypes = count($vehicleTypes);

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
			<h3 style="color:#3C8DBC;">
				<a href="./home" class="btn btn-success">
					<i class="glyphicon glyphicon-home"> HOME</i>
				</a>
			Service Category: <b style="color:#000000;"><?php echo $serviceName[0]['name']; ?></b></h3> 
		</div>
	</div>
	<div class="row">
	<div class="col-md-12">
		<div class="box box-default">
			<div class="box-body">
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		            	<?php 

		            		for ($i=0; $i <$countVehicleTypes ; $i++) { 
		            			$vehicleName = $vehicleTypes[$i]['name'];
		            			$vehicleTypeID = $vehicleTypes[$i]['vehical_type_id'];

		            			$carServiceDetails  = Yii::$app->db->createCommand("
									    SELECT sih.*,sid.*,cv.registration_no
									    FROM (((((sale_invoice_head as sih
									    INNER JOIN sale_invoice_detail as sid
									    ON sih.sale_inv_head_id = sid.sale_inv_head_id)
									    INNER JOIN customer_vehicles as cv
									    ON cv.customer_vehicle_id = sid.customer_vehicle_id)
									    INNER JOIN vehicle_type_sub_category as vst
									    ON vst.vehicle_typ_sub_id = cv.vehicle_typ_sub_id)
									    INNER JOIN car_manufacture as cm
									    ON cm.car_manufacture_id = vst.manufacture)
									    INNER JOIN vehicle_type as vt
									    ON vt.vehical_type_id = cm.vehical_type_id)
									    WHERE vt.vehical_type_id = '$vehicleTypeID'
									    AND CAST(sih.date as DATE) = '$currentDate'
							            AND sid.item_type = 'Service'
							            AND sid.item_id = '$serviceID'
									    ")->queryAll();

									    $countCarService = count($carServiceDetails);
		            	 ?>
		              <li class="">
		              	<a href="#<?php echo $i;?>" data-toggle="tab"><?php echo $vehicleName;?> <span class="badge" style="background-color:#3C8DBC;font-size:1em;"><?php echo $countCarService; ?></span></a>
		              </li>
		          	<?php } ?>
		            </ul>
		            <div class="tab-content" style="background-color:#EFEFEF;">
		            	<?php 

		            		for ($i=0; $i <$countVehicleTypes ; $i++) { 
		            			
		            			$vehicleName = $vehicleTypes[$i]['name'];
		            			$vehicleTypeID = $vehicleTypes[$i]['vehical_type_id'];

		            			$carServiceDetails  = Yii::$app->db->createCommand("
									    SELECT sih.*,sid.*,cv.registration_no
									    FROM (((((sale_invoice_head as sih
									    INNER JOIN sale_invoice_detail as sid
									    ON sih.sale_inv_head_id = sid.sale_inv_head_id)
									    INNER JOIN customer_vehicles as cv
									    ON cv.customer_vehicle_id = sid.customer_vehicle_id)
									    INNER JOIN vehicle_type_sub_category as vst
									    ON vst.vehicle_typ_sub_id = cv.vehicle_typ_sub_id)
									    INNER JOIN car_manufacture as cm
									    ON cm.car_manufacture_id = vst.manufacture)
									    INNER JOIN vehicle_type as vt
									    ON vt.vehical_type_id = cm.vehical_type_id)
									    WHERE vt.vehical_type_id = '$vehicleTypeID'
									    AND CAST(sih.date as DATE) = '$currentDate'
							            AND sid.item_type = 'Service'
							            AND sid.item_id = '$serviceID'
									    ")->queryAll();
							    //var_dump($carServiceDetails);
							    $countCarServiceDetails = count($carServiceDetails);
		            	?>
				            <div class="tab-pane" id="<?php echo $i;?>">
				                
				                 <p style="color:#3C8DBC;font-size:1.5em;"><?php echo $vehicleName;?></p>
				                 
				                <div class="row">
				                	<div class="col-md-12">
				                		<div class="box box-primary">
				                			<div class="box-body">
						                		<table class="table table-bordered">
						                			<thead style="background-color:#3C8DBC;color:white;">
						                				<tr>
						                					<th>Sr.#</th>
						                					<th>Customer Name</th>
						                					<th>Reg.#</th>
						                					<th>Amount</th>
						                				</tr>
						                			</thead>
						                			<tbody>
						                				<?php 
											                 for ($j=0; $j <$countCarServiceDetails ; $j++) {
											                $custID = $carServiceDetails[$j]['customer_id'];
											                $customerName  = Yii::$app->db->createCommand("
																	    SELECT customer_name
																	    FROM customer
																	    WHERE customer_id = '$custID'	
																	    ")->queryAll(); 

											                ?>
											                <tr>
											                	<td><?php echo $j+1; ?></td>
											                	<td><?php echo $customerName[0]['customer_name']; ?></td>
											                	<td>
											                		<?php echo $carServiceDetails[$j]['registration_no']; ?>
											                	</td>
											                	<td>
											                		<?php echo $carServiceDetails[$j]['discount_per_service']; ?>
											                	</td>
											                </tr>
											                <?php } ?>
						                			</tbody>
						                		</table>
					                		</div>
				                		</div>
				                	</div>
				                </div>
				            </div>
				              <!-- /.tab-pane -->
				        <?php 
				      	} // closing of for loop 
				      ?>
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