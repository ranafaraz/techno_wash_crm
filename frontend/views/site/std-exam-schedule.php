<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<h2 style="text-align: center;font-family: georgia;box-shadow: 1px 1px 1px 1px;">
							<?php// echo $examCategoryName[0]['category_name']; ?>Annual Examination (<?php echo date('Y'); ?>)
							</h2>
							<br>
							<p style="text-align: center;font-weight: bold;font-size: 20px;">Date Sheet</p><br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4" style="border-right:1px solid;text-align: center;">
							<table class="table">
									<tr>
										<b>Exam Time</b><br>
										<center>
											<?php
											 echo "09:00 AM"; 
											echo date('h:i:A',strtotime($examCriteriaData[0]['exam_start_time']));
											?>
											<b>TO</b>&nbsp;<?php
											echo "09:00 AM"; 
											echo date('h:i:A',strtotime($examCriteriaData[0]['exam_end_time']));
											?>
										</center>
									</tr>
							</table>
						</div>
						<div class="col-md-4" style="border-right:1px solid;text-align: center;">
							<table class="table">
									<tr>
										<b>Exam Room</b><br>
										<center>
											<?php 
											echo "Room-2";
											echo $examCriteriaData[0]['exam_room']; ?>
										</center>
									</tr>
							</table>
						</div>
						<div class="col-md-4" style="text-align: center;">
							<table class="table">
									<tr>
										<b>Class Name</b>
										<center>
											<?php 
											echo "5th";
											echo $className[0]['std_enroll_head_name']; ?>
										</center>
									</tr>
							</table>
						</div>
					</div><hr>
						<div class="row">
							<div class="col-md-6">
								<p style="font-weight: bold;"><?php// echo $examCategoryName[0]['category_name']." Schedule ".($i+1); ?>  
							</p>
							</div>
							<div class="col-md-6">
							<p style="float: right;font-weight: bold;">
								<?php 	

							//echo date('d-M-Y',strtotime($examCriteriaData[$i]['exam_start_date']))." To ".
							//date('d-M-Y',strtotime($examCriteriaData[$i]['exam_end_date']));?>
							</p>
							</div>
						</div>
						<div class="row">
						<div class="col-md-12">
							<table class="table table-hover">
								<thead>
									<tr style="background-color: #337AB7;color: white;">
										<th class="text-center">Date</th>
										<th class="text-center">Day</th>
										<th class="text-center">Subject</th>
									</tr>
								</thead>
								<tbody>
									<tr align="center">
										<td>
											01-04-2019	
										</td>
										<td>
											Tuesday
										</td>
										<td>
											Math	
										</td>
									</tr>
									<tr align="center">
										<td>
											02-04-2019	
										</td>
										<td>
											Wednesday
										</td>
										<td>
											English	
										</td>
									</tr>
									<tr align="center">
										<td>
											03-04-2019	
										</td>
										<td>
											Thursday
										</td>
										<td>
											Urdu	
										</td>
									</tr>
									<tr align="center">
										<td>
											04-04-2019	
										</td>
										<td>
											Friday
										</td>
										<td>
											Physics	
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>