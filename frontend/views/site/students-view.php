<?php 

	$id = Yii::$app->user->identity->username;
  	// Employee Personal Info..... 
  	$empInfo = Yii::$app->db->createCommand("SELECT * FROM emp_info WHERE emp_cnic = '$id'")->queryAll();
  	$empID = $empInfo[0]['emp_id'];
  	$teacherId = Yii::$app->db->createCommand("SELECT teacher_subject_assign_head_id FROM teacher_subject_assign_head WHERE teacher_id = '$empID'")->queryAll();
  if(empty($teacherName)){
      Yii::$app->session->setFlash('warning',"Sorry. No class assigned to you..!");
  } else {
    $teacherHeadId = $teacherId[0]['teacher_subject_assign_head_id'];

  	$classId = Yii::$app->db->createCommand("SELECT DISTINCT d.class_id FROM teacher_subject_assign_detail as d 
  		WHERE d.teacher_subject_assign_detail_head_id = '$teacherHeadId'")->queryAll();
  	$countclasses = count($classId);

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
			<ol class="breadcrumb">
	        	<li><a href="./home"><i class="fa fa-dashboard"></i> Home</a></li>
	    	</ol>
		</div>
	</div>
	<div class="box box-default">
		<div class="box-header">
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>Class Wise Students</h2>
				</div>
			</div>
		</div><hr>
		<?php 

		for ($i=0; $i <$countclasses ; $i++) { 
			$classID = $classId[$i]['class_id'];

			$className = Yii::$app->db->createCommand("SELECT h.std_enroll_head_name FROM std_enrollment_head as h 
  			WHERE h.std_enroll_head_id = '$classID'")->queryAll();

  			$stdNames = Yii::$app->db->createCommand("SELECT d.std_enroll_detail_std_name,d.std_enroll_detail_std_id FROM std_enrollment_detail as d 
  			WHERE d.std_enroll_detail_head_id = '$classID'")->queryAll();
  			$countStd = count($stdNames);

		 ?>
			<div class="row container-fluid">
				<div class="col-md-6">
					<div class="box box-danger collapsed-box" style=" border-color:#605CA8;">
	                    <div class="box-header" style="background-color:#c8c6f2;padding: 15px;">
	                        <h3 class="box-title">
	                            <b>
	                            <?php echo $className[0]['std_enroll_head_name']; ?>
	                            </b>
	                        </h3>
	                        <div class="box-tools pull-right">
	                            <button type="button" class="btn btn-box-tool" data-widget="collapse">  <br><i class="fa fa-plus" style="font-size:15px;color:#605CA8;"></i>
	                            </button>
	                        </div>
	                        <!-- /.box-tools -->
	                    </div>
	                    <!-- /.box-header -->
	                    <div class="box-body">
	                        <table class="table table-hover">
	                        	<thead>
	                        		<tr>
	                        			<th>Sr.#</th>
	                        			<th>Student Name</th>
	                        		</tr>
	                        	</thead>
	                        	<tbody>
	                        		<?php 
	                        			for ($i=0; $i <$countStd ; $i++) {

	                        			$std_id = $stdNames[$i]['std_enroll_detail_std_id'] ;
	                        		 ?>
	                        		<tr>
	                        			<td><?php echo $i+1; ?></td>
	                        			<td>
	                        				<a href="./students-list?std_id=<?php echo $std_id; ?>">
	                        					<?php echo $stdNames[$i]['std_enroll_detail_std_name'] ;?>
	                        				</a>
	                        					
	                        			</td>
	                        		</tr>
	                        		<?php } ?>
	                        	</tbody>
	                        </table>
	                    </div>
	                    <!-- /.box-body -->
                	</div>
              <!-- /.box -->
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<?php } ?>
</body>
</html>