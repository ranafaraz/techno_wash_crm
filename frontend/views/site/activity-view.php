<?php 

    if(isset($_GET['sub_id'])){
        $sub_id = $_GET['sub_id'];  
        $class_id = $_GET['class_id'];
        $teacherHeadId = $_GET['teacherHeadId'];
        $date  = date('d-m-Y');

        $CLASSName = Yii::$app->db->createCommand("SELECT seh.std_enroll_head_name
            FROM std_enrollment_head as seh
            WHERE seh.std_enroll_head_id = '$class_id'")->queryAll();

        $subjectsName = Yii::$app->db->createCommand("SELECT subject_name FROM subjects WHERE subject_id = '$sub_id'")->queryAll();   
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
<style type="text/css">
.shape{    
    border-style: solid; border-width: 0 70px 40px 0; float:right; height: 0px; width: 0px;
	-ms-transform:rotate(360deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(360deg); /* Safari and Chrome */
	transform:rotate(360deg);
}
.offer{
	background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
}
.offer:hover {
    -webkit-transform: scale(1.1); 
    -moz-transform: scale(1.1); 
    -ms-transform: scale(1.1); 
    -o-transform: scale(1.1); 
    transform:rotate scale(1.1); 
    -webkit-transition: all 0.4s ease-in-out; 
-moz-transition: all 0.4s ease-in-out; 
-o-transition: all 0.4s ease-in-out;
transition: all 0.4s ease-in-out;
    }
.shape {
	border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}
.offer-radius{
	border-radius:7px;
}
.offer-danger {	border-color: #d9534f; }
.offer-danger .shape{
	border-color: transparent #d9534f transparent transparent;
}
.offer-success {	border-color: #5cb85c; }
.offer-success .shape{
	border-color: transparent #5cb85c transparent transparent;
}
.offer-pink {	border-color: #8fb800; }
.offer-pink .shape{
	border-color: transparent 	#8fb800 transparent transparent;
}
.offer-seagreen {	border-color: #2fcea5; }
.offer-seagreen .shape{
	border-color: transparent 	#2fcea5 transparent transparent;
}
.offer-brown {	border-color: #c47c48; }
.offer-brown .shape{
	border-color: transparent 	#c47c48 transparent transparent;
}
.offer-default {	border-color: #999999; }
.offer-default .shape{
	border-color: transparent #999999 transparent transparent;
}
.offer-primary {	border-color: #428bca; }
.offer-primary .shape{
	border-color: transparent #428bca transparent transparent;
}
.offer-info {	border-color: #999999; }
.offer-info .shape{
	border-color: transparent #999999 transparent transparent;
}
.offer-warning {	border-color: #f0ad4e; }
.offer-warning .shape{
	border-color: transparent #f0ad4e transparent transparent;
}

.shape-text{
	color:#fff; font-size:12px; font-weight:bold; position:relative; right:-40px; top:2px; white-space: nowrap;
	-ms-transform:rotate(30deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(30deg); /* Safari and Chrome */
	transform:rotate(30deg);
}	
.offer-content{
	padding:0 20px 10px;
}
@media (min-width: 487px) {
  .container {
    max-width: 750px;
  }
  .col-sm-6 {
    width: 50%;
  }
}
@media (min-width: 900px) {
  .container {
    max-width: 970px;
  }
  .col-md-4 {
    width: 33.33333333333333%;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 1170px;
  }
  .col-lg-3 {
    width: 25%;
  }
  }
</style>
</head>
<body>

<div class="row container-fluid">
	<div class="row">
		  <div class="col-md-12">
		    <!-- back button start -->
		     <ol class="breadcrumb">
		        <li><a class="btn btn-primary btn-xs" href="./list-of-classes"><i class="glyphicon glyphicon-backward"></i> Back</a></li>
		      </ol>
		    <!-- back button close -->
		  </div>
  	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="box box-danger" style=" border-color:#605CA8;">
				<div class="box-header" style="padding:2px;">
					<h3 class="text-center" style="font-family: georgia;">Class Information</h3><hr  style=" border-color:#c8c6f2;" >
				</div>
				<div class="box-body">
					<li style="list-style-type: none;">
                        <p class="text-center" style="background-color: #605CA8;color:white; padding:4px;">Date</p>
                        <p style="background-color:#c8c6f2;color: ;text-align: center;">
                            <u><?php echo $date; ?></u>
                        </p>
                    </li><hr  style=" border-color:#c8c6f2;" ><br>
                    <li style="list-style-type: none;margin-top: -20px;">
                        <b>Class:</b>
                        <p>
                            <?php echo $CLASSName[0]['std_enroll_head_name']; ?>
                        </p>
                    </li><br>
                    <li style="list-style-type: none;">
                        <b>Subject:</b>
                        <p>
                            <?php echo $subjectsName[0]['subject_name']; ?>
                        </p>
                    </li><hr  style=" border-color:#c8c6f2;" ><br>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="box box-danger" style=" border-color:#605CA8;">
				<div class="box-header" style="background-color:#c8c6f2;padding:8px;">
					 <h2 class="text-center" style="font-family: georgia;color:#605CA8;margin-top: 10px;"><i class="fa fa-cogs"></i> Activity Panel</h2>
				</div>
				<div class="box-body">
					<div class="row">
				    	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" >
							<div class="offer offer-radius offer-danger">
								<div class="shape">
									<div class="shape-text">
										<span class="glyphicon glyphicon glyphicon-th"></span>							
									</div>
								</div>
								<div class="offer-content">
									<h3 class="lead" style="color:#d9534f;">
									Attendance
									</h3>
									<a href="./take-attendance?sub_id=<?php echo $sub_id ?>&class_id=<?php echo $class_id ?>&teacherHeadId=<?php echo $teacherHeadId ?>">Take attendance</a>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="">
							<div class="offer offer-radius offer-success">
								<div class="shape">
									<div class="shape-text">
										<span class="glyphicon glyphicon glyphicon-eye-open"></span>							
									</div>
								</div>
								<div class="offer-content">
									<h3 class="lead" style="color:#5CB85C;">
										Reports
									</h3>
									<a href="./view-attendance?sub_id=<?php echo $sub_id ?>&class_id=<?php echo $class_id ?>&teacherHeadId=<?php echo $teacherHeadId ?>">View attendance reports</a>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" >
							<div class="offer offer-radius offer-warning">
								<div class="shape">
									<div class="shape-text">
										<span class="glyphicon glyphicon glyphicon-edit"></span>							
									</div>
								</div>
								<div class="offer-content">
									<h3 class="lead">
									Marks Sheet
									</h3>
									<a href="./marks-sheet?sub_id=<?php echo $sub_id ?>&class_id=<?php echo $class_id ?>&teacherHeadId=<?php echo $teacherHeadId ?>">Add marks</a>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
							<div class="offer offer-radius offer-pink">
								<div class="shape">
									<div class="shape-text">
										<span class="glyphicon glyphicon glyphicon-eye-open"></span>							
									</div>
								</div>
								<div class="offer-content">
									<h3 class="lead">
										Marks List
									</h3>
									<a href="">View Marks</a>
								</div>
							</div>
						</div>
			        </div>
			        <!-- row 2 start -->
			        <div class="row">
			        	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
							<div class="offer offer-radius offer-primary">
								<div class="shape">
									<div class="shape-text">
										<span class="glyphicon  glyphicon-user"></span>							
									</div>
								</div>
								<div class="offer-content">
									<h3 class="lead">
										Assignment
									</h3>
									<a href="">View assignment</a>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
							<div class="offer offer-radius offer-info">
								<div class="shape">
									<div class="shape-text">
										<span class="glyphicon  glyphicon-bell"></span>							
									</div>
								</div>
								<div class="offer-content">
									<h3 class="lead">
										Quiz
									</h3>
									<a href="">View Quiz</a>
								</div>
							</div>
						</div>
			        </div>
			        <!-- row 2 close -->
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
//closing of ifisset
}

// for inserting marks from mark-sheet.php
if(isset($_POST['saveMarks'])){
	//marks_head
	$examCriteriaId = $_POST['examCriteriaId'];
	$classHeadId 	= $_POST['classHeadId'];
	$stdId 			= $_POST['stdId'];
	//marks_details
	$subjectId 		= $_POST['subId'];
	//marks_details_weightage
	$weightageTypeId = $_POST['weightageTypeId'];
	$obtMarks = $_POST['marks'];
	//------------------------------
	$classNameId	= $_POST['classNameId'];
	$categoryId 	= $_POST['categoryId'];
	$countStudents 	= $_POST['countStudents'];
	$countWeightage 	= $_POST['countWeightage'];
	// populate absent fields
	for($i=0; $i<$countStudents;$i++){
		if($obtMarks[$i][0] == 'A'){
			for ($j=0; $j <$countWeightage ; $j++) { 
				$obtMarks[$i][$j] = 'A';
			}
		}
	}
	
	$transection = Yii::$app->db->beginTransaction();
	try{
		for ($i=0; $i < $countStudents; $i++) { 
			$marksHeadId = Yii::$app->db->createCommand("SELECT marks_head_id 
					FROM marks_head WHERE exam_criteria_id = '$examCriteriaId' AND class_head_id = '$classHeadId' AND std_id = '$stdId[$i]'")->queryAll();

			if(empty($marksHeadId)){
				$marksHead = Yii::$app->db->createCommand()->insert('marks_head',[
	    			'exam_criteria_id' 		=> $examCriteriaId,
	    			'class_head_id'			=> $classHeadId,
					'std_id' 				=> $stdId[$i],
					'created_at'		    => new \yii\db\Expression('NOW()'),
					'created_by'			=> Yii::$app->user->identity->id, 
				])->execute();

				if($marksHead){
					$marksHeadId = Yii::$app->db->createCommand("SELECT marks_head_id 
					FROM marks_head WHERE exam_criteria_id = '$examCriteriaId' AND class_head_id = '$classHeadId' AND std_id = '$stdId[$i]'")->queryAll();
					$marksHeadid = $marksHeadId[0]['marks_head_id'];
				
					$marksDetails = Yii::$app->db->createCommand()->insert('marks_details',[
	            			'marks_head_id' 	=> $marksHeadid,
							'subject_id' 		=> $subjectId,
							'created_at'		=> new \yii\db\Expression('NOW()'),
							'created_by'		=> Yii::$app->user->identity->id, 
						])->execute();

					if($marksDetails){
						$marksDetailId = Yii::$app->db->createCommand("SELECT marks_detail_id 
						FROM marks_details WHERE marks_head_id = '$marksHeadid' AND subject_id = '$subjectId'")->queryAll();
						$marksDetailid = $marksDetailId[0]['marks_detail_id'];

						for ($j=0; $j <$countWeightage ; $j++) { 
							$marksDetailsWeightage = Yii::$app->db->createCommand()->insert('marks_details_weightage',[
		            			'marks_details_id' 	=> $marksDetailid,
								'weightage_type_id' => $weightageTypeId[$j],
								'obtained_marks'	=> $obtMarks[$i][$j],
								'created_at'		=> new \yii\db\Expression('NOW()'),
								'created_by'		=> Yii::$app->user->identity->id, 
							])->execute();
						} //end of j loop
					} //end of $marksDetails
				} //end of $marksHead
			} else {

				$marksHeadid = $marksHeadId[0]['marks_head_id'];
				$marksDetail = Yii::$app->db->createCommand("SELECT marks_detail_id 
					FROM marks_details WHERE marks_head_id = '$marksHeadid' AND subject_id = '$subjectId'")->queryAll();

				if(empty($marksDetail)){
					$marksDetails = Yii::$app->db->createCommand()->insert('marks_details',[
	            			'marks_head_id' 	=> $marksHeadid,
							'subject_id' 		=> $subjectId,
							'created_at'		=> new \yii\db\Expression('NOW()'),
							'created_by'		=> Yii::$app->user->identity->id, 
						])->execute();

					if($marksDetails){
						$marksDetailId = Yii::$app->db->createCommand("SELECT marks_detail_id 
						FROM marks_details WHERE marks_head_id = '$marksHeadid' AND subject_id = '$subjectId'")->queryAll();
						$marksDetailid = $marksDetailId[0]['marks_detail_id'];

						for ($j=0; $j <$countWeightage ; $j++) { 
							$marksDetailsWeightage = Yii::$app->db->createCommand()->insert('marks_details_weightage',[
		            			'marks_details_id' 	=> $marksDetailid,
								'weightage_type_id' => $weightageTypeId[$j],
								'obtained_marks'	=> $obtMarks[$i][$j],
								'created_at'		=> new \yii\db\Expression('NOW()'),
								'created_by'		=> Yii::$app->user->identity->id, 
							])->execute();
						} //end of j loop
					} //end of $marksDetails
				} // end of empty($marksDetail)
			} // end of else

			if($marksDetailsWeightage){
				$classHeadIds = Yii::$app->db->createCommand("SELECT std_enroll_head_id FROM std_enrollment_head
				WHERE class_name_id = '$classNameId'
				")->queryAll();
				$countHeads = count($classHeadIds);
				$count=0;
				for ($k=0; $k < $countHeads; $k++) { 
					$headId = $classHeadIds[$k]['std_enroll_head_id'];

					$marksData = Yii::$app->db->createCommand("SELECT * 
						FROM marks_head as h
					INNER JOIN marks_details as d
					ON h.marks_head_id = d.marks_head_id
					WHERE h.class_head_id = '$headId'
					AND d.subject_id = '$subjectId'
					")->queryAll();

					if(!empty($marksData)){
						$count++;
					}
				}

				if($count == $countHeads){
					$examScheduleId = Yii::$app->db->createCommand("SELECT s.exam_schedule_id FROM exams_schedule as s
					INNER JOIN exams_criteria as c 
					ON s.exam_criteria_id = c.exam_criteria_id
					WHERE c.class_id = '$classNameId'
					AND c.exam_category_id = '$categoryId'
					AND s.subject_id = '$subjectId'
					AND c.exam_status = 'conducted'
					")->queryAll();


					$scheduleId = $examScheduleId[0]['exam_schedule_id'];
					$examSchedule = Yii::$app->db->createCommand()->update('exams_schedule',[
	                            'status' => 'result prepared'],
	                            ['exam_schedule_id' => $scheduleId] 
	                            )->execute();
				} //closing of if
			} //closing of $marksDetailsWeightage	
		} // closing of loop countStudent
		if($marksDetails){
			$transection->commit();
			Yii::$app->session->setFlash('success', "Mark Sheet managed sccessfully...!");
		}
	} //closing of try block
	catch(Exception $e){
		$transection->rollback();
		echo $e;
		Yii::$app->session->setFlash('warning', "Mark Sheet not managed. Try again!");
	}
	//closing of catch

}
//closing of if isset
?>