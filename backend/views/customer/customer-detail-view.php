<?php
 
use common\models\Customer; 
use common\models\Branches;

	$customerId = $_GET['id'];

	$customerData = Customer::find()->where(['customer_id' => $customerId])->one();
	$branchId = $customerData->branch_id;


    $vehicleData = Yii::$app->db->createCommand("SELECT * FROM customer_vehicles WHERE customer_id = '$customerId'")->queryAll();
    

    $countcusVehicle = count($vehicleData);

    $branchData = Branches::find()->where(['branch_id' => $branchId])->one();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Details</title>
	<style type="text/css">
		body{
			font-family:arial;
		}
		.bg-color{
			background-color:lightgray;
		}
		.t-cen{
			text-align: center;
		}
	</style>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-body" style="padding:20px;">
					<div class="nav-tabs-custom">
			            <ul class="nav nav-tabs">
			              <li class="active">
			              	<a href="#customer" data-toggle="tab">Customer</a>
			              </li>
			              <li><a href="#customer_vehicles" data-toggle="tab">Customer Vehicles</a></li>
			            </ul>
			            <div class="tab-content" style="background-color: #efefef;">
					            <div class="active tab-pane" id="customer">
					            	<div class="row">
					            		<div class="col-md-11">
					            			<h3 class="text-info">Customer Details</h3>
					            		</div>
					            		<div class="col-md-1">
					            			 <a href="./customer-update?id=<?php echo $customerId;?>" class="btn btn-info" style="float:right; margin-right: 3px;"> 
					            				<i class="glyphicon glyphicon-edit"></i> Edit
					            			</a>
					            		</div>
					            	</div>
					            	<div class="row" style="margin-bottom:10px;">
					            		<div class="col-md-12">
					            			<table class="table table-bordered">
					            				<thead style="background-color: #367FA9;color:white;">
					            					<tr>
					            						<th class="t-cen">
			            								<?php
								            				echo "Customer Name: <b style='font-size:17px; font-family:georgia;'>".$customerData->customer_name."</b>";
			            				 				?>
					            						</th>
					            					</tr>
					            				</thead>
					            			</table>
					            		</div>
					            	</div>
					            	<div class="row">
					            		<div class="col-md-6">
					            			<table class="table table-bordered">
					            				<thead>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Branch Name:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $branchData->branch_name; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Gender:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_gender; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">CNIC #:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_cnic; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Address:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_address; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Contact No:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_contact_no; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Registration Date:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_registration_date; ?>
					            						</th>
					            					</tr>
					            				</thead>
					            			</table>
					            		</div>
					            		<div class="col-md-6">
					            			<table class="table table-bordered">
					            				<thead>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Age:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_age; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Email:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_email; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Occupation:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $customerData->customer_occupation; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="text-center bg-color" style="vertical-align:middle;">Image:</th>
					            						<th style="background-color: white;vertical-align:middle;">
					            							<img src="<?php echo $customerData->customer_image; ?>" class="img-rounded" alt="Image" style="width:150px; height:120px;"/>
					            						</th>
					            					</tr>
					            				</thead>
					            			</table>
					            		</div>
					            	</div>  
					            </div>
					              <!-- /.tab-pane -->
					            <div class="tab-pane" id="customer_vehicles">
					              	<div class="row">
					            		<div class="col-md-11">
					            			<h3 class="text-info">Customer Vehicles Details</h3>
					            		</div>
					            		<div class="col-md-1">
					            			<a href="./customer-vehicles-create?id=<?php echo $customerId;?>" class="btn btn-success" style="float:right; margin-right: 3px;">
					            				<i class="glyphicon glyphicon-plus"></i> Insert
					            			</a>
					            		</div>
					            	</div>
					            	<div class="row">
					            		<div class="col-md-12">
					            			<div class="table-responsive">           			
					            			<table class="table table-bordered table-striped">
					            				<thead style="background-color: #367FA9;color:white;">
					            					<tr>
					            						<th class="t-cen">Sr #.</th>
					            						<th class="t-cen">Customer Name</th>
					            						<th class="t-cen">Vehicle Sub Type</th>
					            						<th class="t-cen">Registration No</th>
					            						<th class="t-cen">Vehicle Color</th>
					            						<th class="t-cen">Vehicle Image</th>
					            						<th class="t-cen">Action</th>
					            					</tr>
					            				</thead>
					            				<tbody>
					            					<?php 

					            						for ($i=0; $i <$countcusVehicle ; $i++) {

														    $vehicleSubTypId = $vehicleData[$i]['vehicle_typ_sub_id'];

														    
															$vehicleSubType = Yii::$app->db->createCommand("
														    SELECT *
														    FROM vehicle_type_sub_category
														    WHERE vehicle_typ_sub_id = '$vehicleSubTypId'
														    ")->queryAll();

					            							?>
					            							
					            						<tr>
					            							<td style="vertical-align:middle;"><?php echo $i+1; ?></td>
					            							<td style="vertical-align:middle;"><?php echo $customerData->customer_name; ?></td>
					            							<td style="vertical-align:middle;"><?php echo $vehicleSubType[0]['name']; ?></td>
					            							<td style="vertical-align:middle;"><?php echo $vehicleData[$i]['registration_no']; ?></td>
					            							<td style="vertical-align:middle;"><?php echo $vehicleData[$i]['color']; ?></td>
					            							<td class="text-center" style="vertical-align:middle;"><img src="<?php echo $vehicleData[$i]['image']; ?>" class="img-thumbnail" alt="Image" style="width:150px; height:100px;"/></td>
					            							<td class="text-center" style="vertical-align:middle;"><a href="customer-vehicles-update?id=<?php echo $vehicleData[$i]['customer_vehicle_id'] ?>" title="Edit" class="label label-info"><i class="glyphicon glyphicon-edit"></i> Edit</a></td>
					            						</tr>	
					            					
					            					<?php } ?>
					            				</tbody>
					            			</table>
					            			</div>
					            		</div>
					            	</div>
					            </div>
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
<!-- container close -->
</body>
</html>