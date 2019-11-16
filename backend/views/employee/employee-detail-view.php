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
			              <li >
			              	<a href="#Employee_payroll" data-toggle="tab">Employee PayRoll</a>
			              </li>
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
					            						<th class="bg-color" style="padding: 12px;">Email:</th>
					            						<th class="t-cen" style="background-color: white;">
					            							<?php echo $EmployeeData->emp_email; ?>
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
					            <div class="tab-content" id="Employee_payroll">
					            <?php 
					            
					            	$payroll_head =Yii::$app->db->createCommand("SELECT * from emp_payroll_head WHERE emp_id = '$employeeId'")->queryAll();
					            $payrollhead = count($payroll_head);
					            
					            ?>
					             <div class="row">
					             	<div class="col-md-12">
					             		<div class="table-responsive">
					             			
					             		
					             		<table class="table table-responsive ">
					             			<thead>
					             				<tr>
					             					<th>Sr No</th>
					             					<th>Transection Date</th>
					             					<th>Amount</th>
					             				</tr>
					             			</thead>
					             			<tbody>
					             				 <?php			
					             				 	for ($i=0; $i <$payrollhead ; $i++) { 
					            					$head_id = $payroll_head[$i]['payroll_head_id'];
					            					$payroll_detail =Yii::$app->db->createCommand("SELECT * from emp_payroll_detail WHERE payroll_head_id = '$head_id'")->queryAll();
					            					$payrolldetail = count($payroll_detail);
					            					for ($j=0; $j < $payrolldetail;  $j++) { 
					            						
					            						?>
					            						<tr>
					            							<td> <?php echo $j; ?></td>
					            							<td><?php echo $payroll_detail[$j]['transaction_date']; ?></td>
					            							<td><?php echo $payroll_detail[$j]['paid_amount'];  ?></td>
					            							
					            						</tr>
					            			<?php		}
					          
					             				
					             			 } ?>
											</tbody>
					             			</tbody>
					             		</table>
					             		</div>
					             	</div>
					             </div>
					            </div>
					            
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