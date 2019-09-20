<?php 

	$customerId = $_GET['id'];

	$customerData = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = '$customerId'
    ")->queryAll();
    $branch_id = $customerData[0]['branch_id'];
    $customer_name = $customerData[0]['customer_name'];
    $customer_gender = $customerData[0]['customer_gender'];
    $customer_cnic = $customerData[0]['customer_cnic'];
    $customer_address = $customerData[0]['customer_address'];
    $customer_contact_no = $customerData[0]['customer_contact_no'];
    $customer_registration_date = $customerData[0]['customer_registration_date'];
    $customer_age = $customerData[0]['customer_age'];
    $customer_email = $customerData[0]['customer_email'];
    $customer_image = $customerData[0]['customer_image'];
    $customer_occupation = $customerData[0]['customer_occupation'];
    $created_by = $customerData[0]['created_by'];
    $updated_by = $customerData[0]['updated_by'];
    $updated_at = $customerData[0]['updated_at'];
    $created_at = $customerData[0]['created_at'];

    // getting vehicle reg no
	$vehicleData = Yii::$app->db->createCommand("
    SELECT *
    FROM customer_vehicles
    WHERE customer_id = '$customerId'
    ")->queryAll();
    

    $countcusVehicle = count($vehicleData);

    $branchData = Yii::$app->db->createCommand("
    SELECT *
    FROM branches
    WHERE branch_id = '$branch_id'
    ")->queryAll();
    $branch_name = $branchData[0]['branch_name'];

    
?>

<?php

    // query to get the username by created_by (id) from table user
    $createdBy = Yii::$app->db->createCommand("SELECT username FROM user WHERE id = '$created_by'")->queryAll();
    if (!empty($createdBy)) {
        $createdBy = $createdBy[0]['username'];
        // $createdBy = $createdBy;
    }

    // query to get the username by updated_by (id) from table user
    $updatedBy = Yii::$app->db->createCommand("SELECT username FROM user WHERE id = '$updated_by'")->queryAll();
    if (!empty($updatedBy)) {
        $updatedBy = $updatedBy[0]['username'];
        //$updatedBy = "<span class='label label-default'>$updatedBy</span>";
    }
    else{
        $updatedBy = "<span class='label label-danger'>Not Updated</span>";
    }
    
    ?>

    
<!DOCTYPE html>
<html>
<head>
	<title></title>
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
			            <div class="tab-content">
					            <div class="active tab-pane" id="customer">
					            	<div class="row">
					            		<div class="col-md-11">
					            			<h3 class="text-info">Customer Details</h3>
					            		</div>
					            		<div class="col-md-1">
					            			<a href="./customer-update?id=<?php echo $customerId;?>" class="btn btn-info">
					            				<i class="glyphicon glyphicon-edit"></i> Edit
					            			</a>
					            		</div>
					            	</div>
					            	<div class="row" style="margin-bottom:10px;">
					            		<div class="col-md-12">
					            			<table class="table table-bordered">
					            				<thead style="background-color: #B81C1F;color:white;">
					            					<tr>
					            						<th class="t-cen">
			            								<?php
								            				echo "Customer Name: ".$customer_name;
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
					            						<th class="bg-color">Branch Name:</th>
					            						<th class="t-cen">
					            							<?php echo $branch_name; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Customer Gender:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_gender; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Customer CNIC:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_cnic; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Customer Address:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_address; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Customer Contact No:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_contact_no; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Customer Registration Date:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_registration_date; ?>
					            						</th>
					            					</tr>
					            				</thead>
					            			</table>
					            		</div>
					            		<div class="col-md-6">
					            			<table class="table table-bordered">
					            				<thead>
					            					<tr>
					            						<th class="bg-color">Customer Age:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_age; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Customer Email:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_email; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Customer Occupation:</th>
					            						<th class="t-cen">
					            							<?php echo $customer_occupation; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Created By:</th>
					            						<th class="t-cen">
					            							<?php echo $createdBy; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Updated By:</th>
					            						<th class="t-cen">
					            							<?php echo $updatedBy; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color">Created At:</th>
					            						<th class="t-cen">
					            							<?php echo $created_at; ?>
					            						</th>
					            					</tr>          					
					            					<tr>
					            						<th class="bg-color">Updated At:</th>
					            						<th class="t-cen">
					            							<?php echo $updated_at; ?>
					            						</th>
					            					</tr>
					            				</thead>
					            			</table>
					            		</div>
					            	</div>  
					            </div>
					              <!-- /.tab-pane -->
					            <div class="tab-pane" id="customerVehicle">
					              	<div class="row">
					            		<div class="col-md-11">
					            			<h3 class="text-info">Customer Vehicles Details</h3>
					            		</div>
					            		<div class="col-md-1">
					            			<a href="./customer-vehicle-update?id=<?php echo $customerId;?>" class="btn btn-info">
					            				<i class="glyphicon glyphicon-edit"></i> Edit
					            			</a>
					            		</div>
					            	</div>
					            	<div class="row">
					            		<div class="col-md-6">
					            			<table class="table table-bordered">
					            				<thead style="background-color: #B81C1F;color:white;">
					            					<tr>
					            						<th class="t-cen">Sr #.</th>
					            						<th class="t-cen">Customer Name</th>
					            						<th class="t-cen">Vehicle Sub Type</th>
					            						<th class="t-cen">Registration No</th>
					            						<th class="t-cen">Vehicle Color</th>
					            						<th class="t-cen">Vehicle Image</th>
					            						<th class="t-cen">Created At
					            						<th class="t-cen">Updated At</th>
					            						<th class="t-cen">Created By</th>
					            						<th class="t-cen">Updated By</th>
					            					</tr>
					            				</thead>
					            				<tbody>
					            					<?php 

					            						for ($i=0; $i <$countcusVehicle ; $i++) { 
					            							$cusID = $vehicleData[$i]['customer_id'];
					            							// getting route employe names
															$cusData = Yii::$app->db->createCommand("
														    SELECT *
														    FROM customer
														    WHERE customer_id = '$cusID'
														    ")->queryAll();
														    $vehicleSubTypId = $vehicleData[$i]['vehicle_typ_sub_id'];

														    // getting route employe types
															$vehicleSubType = Yii::$app->db->createCommand("
														    SELECT *
														    FROM vehicle_type_sub_category
														    WHERE vehicle_typ_sub_id = '$vehicleSubTypId'
														    ")->queryAll();

					            							?>
					            							
					            						<tr>
					            							<td><?php echo $i+1; ?></td>
					            							<td><?php echo $cusData[0]['customer_name']; ?></td>
					            							<td><?php echo $vehicleSubType[0]['name']; ?></td>
					            							<td><?php echo $vehicleData[$i]['registration_no']; ?></td>
					            							<td><?php echo $vehicleData[$i]['color']; ?></td>
					            							<td><?php echo $vehicleData[$i]['image']; ?></td>
					            							<td><?php echo $vehicleData[$i]['created_by']; ?></td>
					            							<td><?php echo $vehicleData[$i]['updated_by']; ?></td>
					            							<td><?php echo $vehicleData[$i]['created_by']; ?></td>
					            							<td><?php echo $vehicleData[$i]['updated_by']; ?></td>
					            						</tr>	
					            					
					            					<?php } ?>
					            				</tbody>
					            			</table>
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