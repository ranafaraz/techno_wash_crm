<!DOCTYPE html>
<html>
<head>
  <title>All Branches</title>
</head>
<body>
<?php 
  $cnic = Yii::$app->user->identity->username;
    // Employee Personal Info..... 
  $empInfo = Yii::$app->db->createCommand("SELECT * FROM emp_info WHERE emp_cnic = '$cnic'")->queryAll();
  $empID = $empInfo[0]['emp_id'];
  $teacherDetails = Yii::$app->db->createCommand("SELECT * FROM teacher_subject_assign_head WHERE teacher_id = '$empID'")->queryAll();

  if(empty($teacherDetails)){
      Yii::$app->session->setFlash('warning',"Sorry. No class assigned to you..!");
  } else {
    $teacherHeadId = $teacherDetails[0]['teacher_subject_assign_head_id'];

    $teacherName = Yii::$app->db->createCommand("SELECT teacher_subject_assign_head_name FROM teacher_subject_assign_head WHERE teacher_subject_assign_head_id = '$teacherHeadId'")->queryAll();

    $teacherClassID = Yii::$app->db->createCommand("SELECT DISTINCT class_id FROM teacher_subject_assign_detail WHERE teacher_subject_assign_detail_head_id = '$teacherHeadId'")->queryAll();
    
?>
<div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
        <!-- back button start -->
         <ol class="breadcrumb">
            <li><a class="btn btn-primary btn-xs" href="./home"><i class="fa fa-home"></i> Home</a></li>
          </ol>
        <!-- back button close -->
      </div>
  </div>
  <div class="row">
    <div class="col-md-6" style="color: #3C8DBC;">
      <h2>
        <i class="fa fa-user-circle-o"></i>
        <?php echo $teacherName[0]['teacher_subject_assign_head_name']." - Information" ; ?>
      </h2>
    </div>
  </div>
  <!-- <section class="content-header" style="border:1px solid;">
    <h1 style="color: #3C8DBC;">
      <i class="fa fa-user-circle-o"></i>
      <?php //echo $teacherName[0]['teacher_subject_assign_head_name']." - Information" ; ?>
    </h1>
  </section> -->
  <!--  -->
  <section class="content">
    <div class="row">
      <!-- /.col -->
      <div class="col-md-8" style="border:1px solid;padding:10px;box-shadow:1px 1px 1px 1px #3C8DBC;">
        <table class="table table-bordered table-hover table-condensed table-striped">
          <tbody>
            <?php 
              foreach ($teacherClassID as $k => $val) {
                $teacherClassId = $val['class_id'];              
                $teacherClassName = Yii::$app->db->createCommand("SELECT std_enroll_head_name 
                  FROM std_enrollment_head 
                  WHERE std_enroll_head_id = '$teacherClassId'")->queryAll(); 

                $teacherAssignDetail = Yii::$app->db->createCommand("SELECT tsah.teacher_subject_assign_head_name,tsad.class_id,tsad.subject_id,tsad.no_of_lecture,tsad.incharge
                FROM teacher_subject_assign_detail as tsad
                INNER JOIN teacher_subject_assign_head as tsah
                ON tsah.teacher_subject_assign_head_id = tsad.teacher_subject_assign_detail_head_id
                WHERE tsad.teacher_subject_assign_detail_head_id = '$teacherHeadId' ANd tsad.class_id = '$teacherClassId'")->queryAll();
            ?>
              <thead>
                <tr>
                  <th colspan="6" class="label-primary text-center">
                    <?php echo $teacherClassName[0]['std_enroll_head_name']; ?>
                    
                      <?php 
                        if ($teacherAssignDetail[0]['incharge'] == 1) { ?>
                          <span class="label label-success" style="float: right;padding: 5px;">
                         <?php echo "Incharge"; ?>
                          </span>
                     <?php } ?>  
                  </th>
                </tr>  
                <tr class="label-aqua">
                  <th style="width: 60px; text-align: center;">Sr #</th>
                  <th style="width: 200px">Subject</th>
                  <th>Lectures</th>
                </tr>
              </thead>
              <?php
                foreach ($teacherAssignDetail as $key => $value) {
                  $teacherSubjectId  = $value['subject_id'];
                  $teacherSubjectName = Yii::$app->db->createCommand("SELECT subject_name FROM subjects WHERE subject_id = '$teacherSubjectId'")->queryAll();
              ?>
              <tr>
                <td align="center"><b><?php  echo $key+1; ?></b></td>
                <td><?php echo $teacherSubjectName[0]['subject_name']; ?></td>
                <td><?php echo $value['no_of_lecture'];?></td>
              </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!--  -->
</div>  
<?php } ?>
</body>
</html>