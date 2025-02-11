<?php
 
use common\models\Employee; 
use common\models\EmployeeTypes; 
use common\models\Branches;

	$employeeId = $_GET['id'];

	$EmployeeData = Employee::find()->where(['emp_id' => $employeeId])->one();
	$branchId = $EmployeeData->branch_id;  
	$empTypeId = $EmployeeData->emp_type_id;  
    $branchData = Branches::find()->where(['branch_id' => $branchId])->one();

    $empTypeData = EmployeeTypes::find()->where(['emp_type_id' => $empTypeId])->one();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Employee Details</title>
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
			<div class="box box-primary">
				<div class="box-body" style="padding:20px;">
					<div class="nav-tabs-custom">
			            <ul class="nav nav-tabs">
			              <li class="active">
			              	<a href="#Employee" data-toggle="tab">Employee Profile</a>
			              </li>
			              <li><a href="#Employee_salary" data-toggle="tab">Employee Salary</a></li>
			            </ul>
			            <div class="tab-content" style="background-color: #efefef;">
					            <div class="active tab-pane" id="Employee">
					            	<div class="row">
					            		<div class="col-md-11">
					            			<h3 class="text-info">Employee Details</h3>
					            		</div>
					            		<div class="col-md-1">
					            			 <a href="./employee-update?id=<?php echo $employeeId;?>" class="btn btn-info" style="float:right; margin-right: 3px;"> 
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
								            				echo "Employee Name: <i><b style='font-size:17px; font-family:georgia;'>".$EmployeeData->emp_name."</b></i>";
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
					            						<th class="bg-color" style="padding: 12px;">Job Position:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $empTypeData->emp_type_name; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Joining Date:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_joining_date; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Learning Date:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_learning_date; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Father Name:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_father_name; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Father Position:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_father_position; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">CNIC#:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_cnic; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Contact No#:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_contact; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Emergency Contact:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_emergency_contact; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Emergency Contact Relation:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_emergency_contact_relation; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Email:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_email; ?>
					            						</th>
					            					</tr>
					            					
					            						<tr>
					            						<th class="bg-color" style="padding: 12px;">Nationality:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_nationality; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Passport No#:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_passport_no; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Passport Expiry Date:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->passport_expiry_date; ?>
					            						</th>
					            					</tr>			            					
					            				</thead>
					            			</table>
					            		</div>
					            		<div class="col-md-6">
					            			<table class="table table-bordered">
					            				<thead>
					            					<tr>
					            						<th class="text-center bg-color" style="vertical-align:middle;width: 200px;">Image:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<img src="<?php echo $EmployeeData->emp_image; ?>" class="img-rounded" alt="Image" style="width:150px; height:140px;"/>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Gender:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_gender; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Marital Status:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_marital_status; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Age:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_dob; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Birth Place:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_birth_place; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Religion:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_religion; ?>
					            						</th>
					            					</tr>	
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Blood Group:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_blood_group; ?>
					            						</th>
					            					</tr>		            					
					            					
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Residence:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_residence; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Present Address:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_present_address; ?>
					            						</th>
					            					</tr>
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Permanent Address:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_permanent_address; ?>
					            						</th>
					            					</tr>
					            					
					            					<tr>
					            						<th class="bg-color" style="padding: 12px;">Status:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_status; ?>
					            						</th>
					            					</tr>
					            					
					            				</thead>
					            			</table>
					            		</div>
					            	</div>  
					            </div>
					              <!-- /.tab-pane -->
					             <div class="tab-pane" id="Employee_salary">
					              	<div class="row">
					            		<div class="col-md-11">
					            			<h3 class="text-info">Employee Salary Details</h3>
					            		</div>
					            		<div class="col-md-1">
					            		</div>
					            	</div>
					            	<div class="row">
					            		<div class="col-md-12">
					            			<div class="table-responsive">           			
					            			<table class="table table-bordered table-striped">
					            				<thead style="background-color: #367FA9;color:white;">
					            					<tr>
					            						<th class="t-cen">Employee Name</th>
					            						<th class="t-cen">Employee CNIC</th>
					            						<th class="t-cen">Employee Salary</th>
					            						<th class="t-cen">Action</th>
					            					</tr>
					            				</thead>
					            				<tbody>
					            							
					            						<tr>
					            							<td class="t-cen" style="vertical-align:middle;"><?php echo $EmployeeData->emp_name; ?></td>
					            							<td class="t-cen" style="vertical-align:middle;"><?php echo $EmployeeData->emp_cnic; ?></td>
					            							<td class="t-cen" style="vertical-align:middle;"><?php echo $EmployeeData->salary_id; ?></td>
					            							<td class="t-cen" class="text-center" style="vertical-align:middle;"><a href="Employee-update?id=" title="Edit" class="label label-info"><i class="glyphicon glyphicon-edit"></i> Edit</a></td>
					            						</tr>	
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