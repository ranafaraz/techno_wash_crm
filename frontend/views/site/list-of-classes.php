<?php 
    use yii\db\Connection;
    $conn = \Yii::$app->db; 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Attendance</title> 
    <style type="text/css">
        * {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.column {
  float: left;
  width: 25%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding in columns */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* this adds the "card" effect */
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}
.card:hover {
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

/* Responsive columns - one column layout (vertical) on small screens */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/*teacher activity panel styling*/
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
.offer-danger { border-color: #d9534f; }
.offer-danger .shape{
    border-color: transparent #d9534f transparent transparent;
}
.offer-success {    border-color: #5cb85c; }
.offer-success .shape{
    border-color: transparent #5cb85c transparent transparent;
}
.offer-pink {   border-color: #8fb800; }
.offer-pink .shape{
    border-color: transparent   #8fb800 transparent transparent;
}
.offer-seagreen {   border-color: #2fcea5; }
.offer-seagreen .shape{
    border-color: transparent   #2fcea5 transparent transparent;
}
.offer-brown {  border-color: #c47c48; }
.offer-brown .shape{
    border-color: transparent   #c47c48 transparent transparent;
}
.offer-default {    border-color: #999999; }
.offer-default .shape{
    border-color: transparent #999999 transparent transparent;
}
.offer-primary {    border-color: #428bca; }
.offer-primary .shape{
    border-color: transparent #428bca transparent transparent;
}
.offer-info {   border-color: #999999; }
.offer-info .shape{
    border-color: transparent #999999 transparent transparent;
}
.offer-warning {    border-color: #f0ad4e; }
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
    padding:10px;
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
<div class="container-fluid">
    <!-- <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <a href="./home"  style="float: right;background-color: #605CA8;color: white;padding:3px;border-radius:5px;"><i class="glyphicon glyphicon-backward"></i> Back</a>
        </div> -->
    </div><br>
    <?php

        $branch_id = Yii::$app->user->identity->branch_id;
        $empCnic = Yii::$app->user->identity->username;
        $empId = Yii::$app->db->createCommand("SELECT emp.emp_id FROM emp_info as emp WHERE emp.emp_cnic = '$empCnic' AND emp.emp_status = 'Active' AND emp.delete_status = 1")->queryAll();
        $empId = $empId[0]['emp_id'];
        $teacherId = Yii::$app->db->createCommand("SELECT teacher_subject_assign_head_id FROM teacher_subject_assign_head WHERE teacher_id = '$empId'")->queryAll();
        if(empty($teacherId)){
            Yii::$app->session->setFlash('warning',"Sorry. No class assigned to you..!");
        } else {
        $headId = $teacherId[0]['teacher_subject_assign_head_id'];

        $classId = Yii::$app->db->createCommand("SELECT DISTINCT d.class_id FROM teacher_subject_assign_detail as d INNER JOIN teacher_subject_assign_head as h ON d.teacher_subject_assign_detail_head_id = h.teacher_subject_assign_head_id WHERE h.teacher_id = '$empId'")->queryAll();
        $countClassIds = count($classId);
   
        for ($i=0; $i <$countClassIds ; $i++) {
         $id = $classId[$i]['class_id'];
         $CLASSName = Yii::$app->db->createCommand("SELECT seh.std_enroll_head_name,seh.std_enroll_head_id, seh.class_name_id
            FROM std_enrollment_head as seh
            INNER JOIN teacher_subject_assign_detail as tsad
            ON seh.std_enroll_head_id = tsad.class_id WHERE seh.std_enroll_head_id = '$id' AND seh.branch_id = '$branch_id' AND seh.status = 'Active'")->queryAll();

        $subjectsIDs = Yii::$app->db->createCommand("SELECT tsad.subject_id
        FROM teacher_subject_assign_detail as tsad
        WHERE tsad.class_id = '$id' AND tsad.teacher_subject_assign_detail_head_id = '$headId'")->queryAll();
        
            ?>

        <!-- <div class="box-header">
           <h2 class="text-center" style="color:#605CA8; font-family: georgia;"><img src="backend/web/uploads/teacher.jpg" height="40px" width="40px"> List of Classes</h2><hr  style=" border-color:#c8c6f2;" > 
        </div> -->
            
            <div class="col-md-6">
                <div class="box box-danger collapsed-box" style=" border-color:#605CA8;">
                    <div class="box-header" style="background-color:#c8c6f2;padding: 15px;">
                        <h3 class="box-title">
                            <b>
                            <?php echo $CLASSName[0]['std_enroll_head_name']; ?>
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
                    	<?php 
                    		foreach ($subjectsIDs as $key => $value) {
                                    
                    			$SubID = $value['subject_id'];
                                //$count = count($SubID);
                                $subjectsNames = Yii::$app->db->createCommand("SELECT subject_name
                                FROM subjects WHERE subject_id = '$SubID'")->queryAll();
                        ?>
                        <td>
                            <a href="./activity-view?sub_id=<?php echo $SubID;?>&class_id=<?php echo $id;?>&teacherHeadId=<?php echo $headId;?>" class="btn btn-default"  style=" border-color:#605CA8;" >
                               <i class="fa fa-book" style="background-color:#605CA8; border:1px solid; padding:5px ;border-radius:50px;font-size:25px; color:white;"> 
                                
                               </i><br>
                               <?php echo $subjectsNames[0]['subject_name']; ?>   
                            </a>
                        </td>
                        
                    <?php   
                        //end of foreach
                        } ?>
                    	<td>
                            <?php 
                            // $classNameId = $CLASSName[0]['class_name_id'];
                            // $examDataCond = Yii::$app->db->createCommand("SELECT c.*
                            //     FROM exams_criteria as c
                            //     INNER JOIN exams_schedule as s 
                            //     ON c.exam_criteria_id = s.exam_criteria_id
                            //     WHERE c.class_id = '$classNameId'  
                            //     AND c.exam_status = 'conducted' 
                            //     AND c.exam_type = 'Regular'
                            //                 ")->queryAll(); 
                            // if(!empty($examDataCond)){ ?>
                                <!-- <a href="std-remarks?class_id=<?php //echo $id;?>&emp_id=<?php //echo $empId;?>&sub_id=<?php //echo $SubID;?>" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Add Remarks</a> -->
                            <?php //} ?>
                            
                        </td>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
    <?php 
        //end of for loop
        } 
    ?>
<?php } ?>
</body>
</html>