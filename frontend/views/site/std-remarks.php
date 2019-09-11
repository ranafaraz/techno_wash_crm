<?php 

	// get class_id
if(isset($_GET['class_id']))
{
	$classID = $_GET['class_id'];
	$subID = $_GET['sub_id'];
	$empID = $_GET['emp_id'];

	$ClassNameID = Yii::$app->db->createCommand("SELECT std_enroll_head_name,  class_name_id
            FROM std_enrollment_head
            WHERE std_enroll_head_id = '$classID'")->queryAll();
    $classNameId = $ClassNameID[0]['class_name_id'];

	$examDataCond = Yii::$app->db->createCommand("SELECT c.exam_criteria_id,c.exam_category_id,s.full_marks,s.passing_marks,c.exam_type
	FROM exams_criteria as c
	INNER JOIN exams_schedule as s 
	ON c.exam_criteria_id = s.exam_criteria_id
	WHERE c.class_id = '$classNameId'  
	AND c.exam_status = 'conducted' 
	AND (c.exam_type = 'Regular'
	OR c.exam_type = 'Supply')
	AND s.subject_id = '$subID'
				")->queryAll();
	//print_r($examDataCond);
	if (empty($examDataCond)){
		Yii::$app->session->setFlash('warning', "No Exam Found.!");
	} else {

		$examCriteriaId = $examDataCond[0]['exam_criteria_id'];
		$examDataResult = Yii::$app->db->createCommand("SELECT c.exam_category_id,s.full_marks,s.passing_marks
		FROM exams_criteria as c
		INNER JOIN exams_schedule as s 
		ON c.exam_criteria_id = s.exam_criteria_id
		WHERE c.class_id = '$classNameId'
		AND c.exam_criteria_id = '$examCriteriaId'
		AND s.subject_id = '$subID' 
		AND s.status = 'result prepared'
					")->queryAll();
		$marksData = Yii::$app->db->createCommand("SELECT * 
			FROM marks_head as h
		INNER JOIN marks_details as d
		ON h.marks_head_id = d.marks_head_id
		WHERE h.class_head_id = '$classID'
		AND d.subject_id = '$subID'
		")->queryAll();


		if(!empty($marksData)){
			Yii::$app->session->setFlash('warning', "Mark sheet already submitted..!");
		} else {
			$examCatId = $examDataCond[0]['exam_category_id'];
			$examCatName = Yii::$app->db->createCommand("SELECT category_name
			FROM exams_category
			WHERE exam_category_id = '$examCatId' 
						")->queryAll();
			$subjectName = Yii::$app->db->createCommand("SELECT subject_name
			FROM subjects
			WHERE subject_id = '$subID' 
						")->queryAll();
			$empName = Yii::$app->db->createCommand("SELECT emp_name
			FROM emp_info
			WHERE emp_id = '$empID' 
						")->queryAll();
			$students = Yii::$app->db->createCommand("SELECT d.std_roll_no, d.std_enroll_detail_std_id, d.std_enroll_detail_std_name
			FROM std_enrollment_detail as d 
			INNER JOIN std_enrollment_head as h 
			ON h.std_enroll_head_id = d.std_enroll_detail_head_id
			WHERE h.std_enroll_head_id = '$classID'")->queryAll();
			$countStudents = count($students);

			$marksWeightageDetails = Yii::$app->db->createCommand("SELECT d.weightage_type_id,d.marks
			FROM marks_weightage_details as d 
			INNER JOIN marks_weightage_head as h 
			ON h.marks_weightage_id = d.weightage_head_id
			WHERE h.class_id = '$classNameId'
			AND h.subjects_id = '$subID'
			AND h.exam_category_id = '$examCatId'")->queryAll();

 ?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
		        <div class="col-md-3 col-md-offset-9">
		            <a href="./list-of-classes"  style="float: right;background-color: #605CA8;color: white;padding:3px;border-radius:5px;"><i class="glyphicon glyphicon-backward"></i> Back</a>
		        </div>
    		</div><br>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<h2 style="text-align: center;font-family: georgia;box-shadow: 1px 1px 1px 1px;">
									<?php echo $examCatName[0]['category_name']; ?> (<?php echo date('Y'); ?>)
									</h2>
									<br>
									<p style="text-align: center;font-weight: bold;font-size: 20px;">Remarks Sheet:
										<b></b>(<?php echo $examDataCond[0]['exam_type']; ?>)</p><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6" style="border-right:1px solid;text-align: center;">
									<table class="table">
											<tr>
												<b>Class Name</b>
												<center>
													<?php echo $ClassNameID[0]['std_enroll_head_name']; ?>
												</center>
											</tr>
									</table>
								</div>
								<!-- <div class="col-md-4" style="border-right:1px solid;text-align: center;">
									<table class="table">
											<tr>
												<b>Subject</b><br>
												<center>
													<?php// echo $subjectName[0]['subject_name']; ?>
												</center>
											</tr>
									</table>
								</div> -->
								<div class="col-md-6" style="text-align: center;">
									<table class="table">
											<tr>
												<b>Teacher Name</b>
												<center>
													<?php echo $empName[0]['emp_name']; ?>
												</center>
											</tr>
									</table>
								</div>
							</div><hr>
							<div class="row">
								<div class="col-md-12">
									<form method="POST" action="./activity-view?sub_id=<?php echo $subID; ?>&class_id=<?php echo $classID; ?>&emp_id=<?php echo $empID; ?>">
									<table class="table table-hover">
										<thead>
											<tr style="background-color: #337AB7;color: white;">
												<th class="text-center">Sr#</th>
												<th class="text-center">Roll no.</th>
												<th class="text-center">Student</th>
												<th colspan="2" class="text-center">Marks <?php echo $examDataCond[0]['passing_marks']."/".$examDataCond[0]['full_marks'] ?>
												</th>
											</tr>
										</thead>								
										<tbody>
									<?php  	for ($j=0; $j <$countStudents ; $j++) { ?>
											<div class="row">
												<tr align="center">
													<div class="col-md-5">
														<td>
															<?php echo $j+1; ?>	
														</td>
														<td>
															<?php echo $students[$j]['std_roll_no']; ?>	
														</td>
														<td>
															<?php echo $students[$j]['std_enroll_detail_std_name']; ?>
														</td>
													</div>
													<div class="col-md-3">
														<td>
															<?php $countWeightage = count($marksWeightageDetails); ?>
															<input type="checkbox" name="marks[<?php echo $j;?>][0]" onclick=" remove(<?php echo $j+1 ?>,<?php echo $countWeightage; ?>)" value="A" id="ch<?php echo $j+1; ?>">Absent
														</td>
													</div>
													<div class="col-md-4">
														<td>
															<?php if(!empty($marksWeightageDetails)){
													
																for ($i=0; $i <$countWeightage ; $i++) {
																	$weightageTypeId[$i] = $marksWeightageDetails[$i]['weightage_type_id'];

																	$weightageName = Yii::$app->db->createCommand("SELECT weightage_type_name
																		FROM marks_weightage_type 
																		WHERE weightage_type_id = '$weightageTypeId[$i]'")->queryAll();
															?> 
															<div class="col-md-3">
																<label><?php echo $weightageName[0]['weightage_type_name']." (".$marksWeightageDetails[$i]['marks'].")"; ?>
																</label>	
																<input class="form-control" type="text" name="marks[<?php echo $j; ?>][<?php echo $i; ?>]" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="marks<?php echo $j+1;?><?php echo $i+1;?>" required>
															</div>	
														<?php } //closing of $i loop
															} //closing of if(!empty($marksWeightageDetails))
															?>
															
														</td>
													</div>
												</tr>
											</div>
												<!-- row close -->
												<?php 
												$stdID = $students[$j]['std_enroll_detail_std_id'];
												$studentId[$j] = $stdID;
												?>
											<?php }
											//closing of for loop j ?>
										</tbody>
									</table>
									<?php foreach ($studentId as $value) {
						                		echo '<input type="hidden" name="stdId[]" value="'.$value.'" style="width: 30px">';
						                	}
					                	foreach ($weightageTypeId as $value) {
					                		echo '<input type="hidden" name="weightageTypeId[]" value="'.$value.'" style="width: 30px">';
					                	} ?>
						             <input class="form-control" type="hidden" name="countStudents" value="<?php echo $countStudents; ?>">
						             <input class="form-control" type="hidden" name="categoryId" value="<?php echo $examCatId; ?>">
						             <input class="form-control" type="hidden" name="examCriteriaId" value="<?php echo $examCriteriaId; ?>">
						             <input class="form-control" type="hidden" name="classHeadId" value="<?php echo $classID; ?>">
						             <input class="form-control" type="hidden" name="subId" value="<?php echo $subID; ?>">
						             <input class="form-control" type="hidden" name="classNameId" value="<?php echo $classNameId; ?>">
						             <input class="form-control" type="hidden" name="countWeightage" value="<?php echo $countWeightage; ?>">

									<button style="float: right;s" type="submit" name="saveMarks" class="btn btn-success btn-flat btn-xs" onclick="return confirm('are you sure')">
											<i class="fa fa-sign-in"></i> <b>Submit Marks</b>
										</button>
									</form>
								</div>
							</div> <hr>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php //end of (result) else
		}
//end of (conducted) else
	}
//end of if isset
} 
?>

<script type="text/javascript">
	function remove(i,j)
	{
		if ($('#ch'+i).prop('checked')) {
		 	for(k=1; k<=j; k++) {
	 	 		$('#marks'+i+k). prop("disabled", true);
	 	 		$("#marks"+i+k).val("Absent");
 	 		} 
 	 		y=i+1;
 	 		x=1;
 	 		$("#marks"+y+x).focus();

 	 	} else {
 	 		for(k=1; k<=j; k++) {
	 	 		$('#marks'+i+k). prop("disabled", false);
	 	 		$("#marks"+i+k).val("");
 	 		}
	 		k=1;
	 		$("#marks"+i+k).focus();
		}
	}
</script>
