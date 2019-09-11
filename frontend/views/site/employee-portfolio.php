<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php 
  use yii\helpers\Html;
  use common\models\StdPersonalInfo;

  $userType = Yii::$app->user->identity->user_type;

  if ($userType == "Teacher") {
  // Get `emp_id` from `emp_info` table
  $cnic = Yii::$app->user->identity->username;
  // Employee Personal Info..... 
  $empInfo = Yii::$app->db->createCommand("SELECT * FROM emp_info WHERE emp_cnic = '$cnic' AND emp_status = 'Active' AND delete_status=1")->queryAll();

  $id = $empInfo[0]['emp_id'];
  $branchId = $empInfo[0]['emp_branch_id'];


  // Get `emp_dept_id` from `emp_info` table
  $deptId = $empInfo[0]['emp_dept_id'];
  $empdept = Yii::$app->db->createCommand("SELECT * FROM departments WHERE department_id = '$deptId'")->queryAll(); 
  $count = count($empdept);
  // Employee `desigantion_name` from `emp_designation` table against `$empDesignationId`
  //$emp_designation = Yii::$app->db->createCommand("SELECT * FROM emp_designation WHERE emp_designation_id = '$empDesignationId'")->queryAll();
  //$empDesignationName = $emp_designation[0]['emp_designation'];
  // Get `emp_type_id` from `emp_info` table
  //$// = $empInfo[0]['emp_type_id'];
  // `emp_type` from `emp_type` table against `$empTypeId`
  //$emp_type_id = Yii::$app->db->createCommand("SELECT * FROM emp_type WHERE emp_type_id = '$empTypeId'")->queryAll();
  //$empType = $emp_type[0]['emp_type'];
  $empDesignation = Yii::$app->db->createCommand("SELECT * FROM emp_designation WHERE emp_id = '$id'")->queryAll();
  
  // Employee refrence info from `emp_refrence` table againts `emp_id`
  $empReference = Yii::$app->db->createCommand("SELECT * FROM emp_reference WHERE emp_id = '$id'")->queryAll();
  if (empty($empReference)) {
    $empReference[0]['ref_name'] = 'N/A';
    $empReference[0]['ref_contact_no'] = 'N/A';
    $empReference[0]['ref_cnic'] = 'N/A';
    $empReference[0]['ref_designation'] = 'N/A';
    $empRefID = 0;
  }
  else{
    $empRefID = $empReference[0]['emp_ref_id'];
    $empReference = $empReference;
  }
  // Employee Documents Info..... 
  $empDocs = Yii::$app->db->createCommand("SELECT emp_document_id, emp_document, emp_document_name FROM emp_documents WHERE emp_info_id = '$id' AND delete_status = 1")->queryAll();
  $countDocs = count($empDocs);
  $emp_photo = $empInfo[0]['emp_photo'];
?>
<div class="container-fluid">
	<section class="content-header">
    <h1 style="color: #3C8DBC;">
        <i class="fa fa-user"></i> Profile
      </h1>
  </section>
  <!-- main content start  -->
	<section class="content">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image Start -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo './backend/web/'.$emp_photo; ?>" alt="User profile picture" width="10%">
            <h3 class="profile-username text-center" style="color: #3C8DBC;">
              <?php echo $empInfo[0]['emp_name']; ?>
            </h3>
            <p class="text-muted text-center"><!-- Software Engineer --></p>
            <ul class="list-group list-group-unbordered">
              <b>Departments</b>
               <?php 
                //for ($i=0; $i <$count ; $i++) {
                   //$deptId = $empdept[$i]['dept_id'];
                   // Get `deprtment_name` from `departments` againts `emp_department_id`
                    //$empDeptName = Yii::$app->db->createCommand("SELECT department_name,department_id FROM departments WHERE department_id = '$deptId'")->queryAll();
                  ?>
                <li class="list-group-item" style="height:40px">
                  <a href="./departments-view?id=<?php echo $empdept[0]['department_id']; ?>" class="">
                    <?php echo $empdept[0]['department_name']; ?>
                  </a>
                </li>
              <?php //} ?> 
              <li class="list-group-item">
                <b>Designation</b> <a class="pull-right">
                  <?php $des_id = $empDesignation[0]['designation_id'];
                  $empDesignationName = Yii::$app->db->createCommand("SELECT * FROM designation WHERE designation_id = '$des_id'")->queryAll();

                  echo $empDesignationName[0]['designation']; ?>
                </a>
              </li>
              <li class="list-group-item">
                <b>Type</b> <a class="pull-right">
                  <?php $type_id = $empDesignation[0]['emp_type_id'];
                  $empTypeName = Yii::$app->db->createCommand("SELECT * FROM emp_type WHERE emp_type_id = '$type_id'")->queryAll();

                  echo $empTypeName[0]['emp_type']; ?>
                </a>
              </li>
              <li class="list-group-item">
                <b>Member</b> <a class="pull-right">
                  <?php echo $empDesignation[0]['group_by']; ?>
                </a>
              </li>
              <li class="list-group-item">
                <b>Contact #</b> 
                <a class="pull-right">
                  <?php echo $empInfo[0]['emp_contact_no'] ?>
                </a>
              </li>
              <li class="list-group-item">
                <b>Email</b><br>
                <a class="">
                  <?php echo $empInfo[0]['emp_email'] ?>
                </a> 
              </li>
              <li class="list-group-item">
                <b>Facebook ID</b><br>
                <a class="">
                  <?php echo $empInfo[0]['emp_fb_ID'] ?>
                </a> 
              </li>
              <!-- <li class="list-group-item">
                <b>Status</b>
                <a class="pull-right"><span class="label label-success">Active</span></a>
              </li> -->
            </ul>
            <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- Profile Image Close -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active">
              <a href="#personal" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-user-circle"></i> Employee Info</a>
            </li>
            <li>
              <a href="#attendance" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-user"></i> Attendance</a>
            </li>
            <li>
              <a href="#examination" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-user"></i> Examination</a>
            </li>
            <li>
              <a href="#payroll" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-book"></i> Payroll</a>
            </li>
          </ul>
          <!-- Employee personal info Tab start -->
          <div class="tab-content" >
            <div class="active tab-pane" id="personal">
              <div class="row">
                <div class="col-md-6">
                  <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Personal Information</p>
                </div>
                
              </div><hr>
              <!-- Employee info start -->
                <div class="row">
                  <div class="col-md-6">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Father Name:</th>
                          <td><?php echo $empInfo[0]['emp_father_name'] ?></td>
                        </tr>
                        <tr>
                          <th>Martial Status:</th>
                          <td><?php echo $empInfo[0]['emp_marital_status'] ?></td>
                        </tr>
                        <tr>
                          <th>Gender:</th>
                          <td><?php echo $empInfo[0]['emp_gender'] ?></td>
                        </tr>
                        <tr>
                          <th>
                            <?php if($empInfo[0]['emp_salary_type'] == 'Salaried') {
                                echo "Salaried: ";
                              }
                              else {
                                echo $empInfo[0]['emp_salary_type'].": ";
                              } 
                            ?>
                          </th>
                          <td><?php echo $empDesignation[0]['emp_salary']; ?></td>
                        </tr>
                        <tr>
                          <th>Permanent Address:</th>
                        </tr>
                        <tr>
                          <td><?php echo $empInfo[0]['emp_perm_address'] ?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <div class="col-md-6">
                      <table class="table table-stripped">
                      <thead>
                        <!-- <tr>
                          <th>Employee Branch:</th>
                          <td></td>
                        </tr> -->
                        <tr>
                          <th>CNIC:</th>
                          <td><?php echo $empInfo[0]['emp_cnic'] ?></td>
                        </tr>
                        <tr>
                          <th>Qualification:</th>
                          <td><?php echo $empInfo[0]['emp_qualification'] ?></td>
                        </tr>
                        <tr>
                          <th>Passing Year:</th>
                          <td><?php echo $empInfo[0]['emp_passing_year'] ?></td>
                        </tr>
                        <tr>
                          <th>Institute Name:</th>
                          <td><?php echo $empInfo[0]['emp_institute_name'] ?></td>
                        </tr>
                        <tr>
                          <th>Temporary Address:</th>
                        </tr>
                        <tr>
                          <td><?php echo $empInfo[0]['emp_temp_address'] ?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              <!-- Employee info close -->
              <!-- Employee Refrence tab start here -->
            <div class="tab-pane" id="refrence">
             <div class="row">
                <div class="col-md-12">
                  <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Refrence Information</p>
                </div>
              </div><hr>
              <!-- Employee refrence info start -->
                <div class="row">
                  <div class="col-md-6">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Refrence Name:</th>
                          <td><?php echo $empReference[0]['ref_name']; ?></td>
                        </tr>
                        <tr>
                          <th>Refrence Contact No:</th>
                          <td><?php echo $empReference[0]['ref_contact_no']; ?></td>
                        </tr>
                        <tr>
                          <th>Refrence CNIC:</th>
                          <td><?php echo $empReference[0]['ref_cnic']; ?></td>
                        </tr>
                        <tr>
                          <th>Refrence Designation:</th>
                          <td><?php echo $empReference[0]['ref_designation']; ?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <div class="col-md-6">
                     
                  </div>
                </div>
              <!-- Employee refrence info close -->
            </div>
            <!-- Employee refrence tab close here -->
            <!-- Employee Document tab start here -->
            
            <div class="tab-pane" id="doc">
             <div class="row">
                <div class="col-md-5">
                  <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Document Information</p>
                </div>
              </div><hr>
              <!-- Employee Document info start -->
                <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-responsive">
                      <tr class="label-primary">
                        <th class="text-center" style="width: 50px">Sr #</th>
                        <th>Document Name</th>
                        <th class="text-center">Document</th>
                        <th class="text-center">Action</th>
                      </tr>
                      <?php for ($i=0; $i < $countDocs ; $i++) { ?>
                      <tr>
                        <td class="text-center"><b><?php echo $i+1; ?></b></td>
                        <td><?php echo $empDocs[$i]['emp_document_name'] ?></td>
                        <td align="center"><img src="<?php echo $empDocs[$i]['emp_document'] ?>" class="img-responsive img-thumbnail" alt="Document in (.pdf/docs)" width="50px"></td>
                        <td>
                          <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 no-padding">
                            <?= Html::a('<span class = "glyphicon glyphicon-download"></span>', ['/emp-download-doc', 'emp_doc_id' => $empDocs[$i]['emp_document_id']], ['class' => 'btn-sm btn btn-block btn-flat btn-primary', 'title' => 'Download Document', 'data' => ['method' => 'post']]) ?>
                          </div>
                          <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 no-padding">
                            <?=  Html::a('<i class="fa fa-trash-o"></i>',['/emp-delete-doc', 'emp_doc_id' => $empDocs[$i]['emp_document_id']], [
                                'class' => 'btn-sm btn btn-danger btn-block btn-flat',
                                'title' => 'Delete Document',
                                'data' => [
                                  'confirm' => ('Are you sure you want to delete this item?'),
                                  'method' => 'post',
                                ],
                            ])  ?>
                          </div>
                        </td>
                      </tr>
                      <?php } ?>
                    </table>
                    </div>
                  
                </div>
              <!-- Employee Document info close -->
            </div>
            <!-- Employee Document tab close here -->
            </div>
            <!-- Employee personal info Tab close -->
            <!-- ******************************** -->
            <!-- teacher attendance tab start here -->
          <div class="tab-pane" id="attendance">
            <div class="row">
              <div class="col-md-12">
                  <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Attendance Information</p>
              </div>
            </div><hr>
            <?php 

            // Logined Employee ID
            $id = $empInfo[0]['emp_id'];

            // Employee Branch ID
            $branchId = $empInfo[0]['emp_branch_id'];

            // Employee Attendance Years
            $empAttYears = Yii::$app->db->createCommand("SELECT YEAR(att_date) FROM  emp_attendance WHERE emp_id = '$id' AND branch_id = '$branchId' ORDER BY YEAR(att_date) DESC")->queryAll();

            // count Emplyee Attendance Years
            $countempAttYears = count($empAttYears);

            for ($i=0; $i <$countempAttYears ; $i++) { 
            $years = $empAttYears[$i]['YEAR(att_date)'];

            // Employee attendance Months
            $empAttMonth = Yii::$app->db->createCommand("SELECT MONTH(att_date) FROM  emp_attendance WHERE emp_id = '$id' AND branch_id = '$branchId' AND YEAR(att_date) = '$years'")->queryAll();
            
            // Count Employee Attendance Months
            $countempAttMonth = count($empAttMonth);
          
             ?>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-hover">
                  <thead>
                    <h3 class="text-center" style="background-color:#ECF0F5;">
                    Year ( <?php echo $years; ?> )
                    </h3>
                    <tr>
                      <th>Sr.#</th>
                      <th>Month</th>
                      <th>Working Days</th>
                      <th>Present</th>
                      <th>Leave</th>
                      <th>Absent</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    // Employee Attendance Month Loop 
                    for ($j=0; $j <$countempAttMonth ; $j++) { 
                    $months = $empAttMonth[$j]['MONTH(att_date)'];

                    // Employee Attendance Months
                    $empAttMonth = Yii::$app->db->createCommand("SELECT MONTH(att_date) FROM  emp_attendance WHERE emp_id = '$id' AND branch_id = '$branchId' AND YEAR(att_date) = '$years'")->queryAll();

                    // Employee working days
                    $empWorkingDays = Yii::$app->db->createCommand("SELECT * FROM  emp_attendance WHERE emp_id = '$id'
                      AND branch_id = '$branchId'
                      AND YEAR(att_date) = '$years'
                      AND MONTH(att_date) = '$months' ")->queryAll();

                    // Count Employee Working Days
                    $countempWorkingDays = count($empWorkingDays);

                    // Employee Present days
                    $empPresentDays = Yii::$app->db->createCommand("SELECT * FROM  emp_attendance
                      WHERE emp_id = '$id'
                      AND branch_id = '$branchId'
                      AND YEAR(att_date) = '$years'
                      AND MONTH(att_date) = '$months'
                      AND attendance = 'P'")->queryAll();

                    // Count Employee Present Days
                    $countPresentDays = count($empPresentDays);

                    // Employee Leave days
                    $empLeaveDays = Yii::$app->db->createCommand("SELECT * FROM  emp_attendance
                      WHERE emp_id = '$id'
                      AND branch_id = '$branchId'
                      AND YEAR(att_date) = '$years'
                      AND MONTH(att_date) = '$months'
                      AND attendance = 'L'")->queryAll();

                    // Count Employee Present Days
                    $countLeaveDays = count($empLeaveDays);

                    // Employee Absent days
                    $empAbsentDays = Yii::$app->db->createCommand("SELECT * FROM  emp_attendance
                      WHERE emp_id = '$id'
                      AND branch_id = '$branchId'
                      AND YEAR(att_date) = '$years'
                      AND MONTH(att_date) = '$months'
                      AND attendance = 'A'")->queryAll();

                    // Count Employee Present Days
                    $countAbsentDays = count($empAbsentDays);

                    
                    ?>
                    <tr>
                      <td><?php echo $j+1; ?></td>
                      <td>
                        <?php 

                        // Extract Name of a Month 
                        $dateObj   = DateTime::createFromFormat('!m', $months);
                        $month_name = $dateObj->format('F');
                        echo $month_name;
                        ?>
                      </td>
                      <td><?php echo $countempWorkingDays; ?></td>
                      <td><?php echo $countPresentDays; ?></td>
                      <td><?php echo $countLeaveDays; ?></td>
                      <td><?php echo $countAbsentDays; ?></td>
                      <td>
                        <a href="./emp-attendance?empID=<?php echo $id ;?>&month=<?php echo $months ;?>&year=<?php echo $years ;?>">
                          <button class="btn btn-xs btn-warning">View</button>
                        </a>
                      </td>
                    </tr>
                    <?php }  // closing loop for Employee Attendance Months 
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php } // closing loop for emp Attendance years 
            ?>
          </div>
          <!-- teacher attendance tab close here -->
          <!-- teacher Exam tab start here -->
          <div class="tab-pane" id="examination">
            <div class="row">
              <div class="col-md-12">
                  <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Examination Information</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-hover">
                  <thead>
                    <h3 class="text-center" style="background-color:#ECF0F5;">Year (2019)</h3>
                    <p class="text-center">Final Term Exam</p>
                    <tr>
                      <th>Sr.#</th>
                      <th>Class</th>
                      <th>Subject</th>
                      <th>Date</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>KG-(2019-2020)-Green</td>
                      <td>English</td>
                      <td>6-04-19</td>
                      <td>P</td>
                    </tr>
                     <tr>
                      <td>2</td>
                      <td>8th-(2019-2020)-Blue</td>
                      <td>Math</td>
                      <td>10-04-19</td>
                      <td>P</td>
                    </tr>
                     <tr>
                      <td>3</td>
                      <td>9th-(2019-2020)-Pink</td>
                      <td>Urdu</td>
                      <td>12-04-19</td>
                      <td>A</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- teacher Exam tab close here -->
          <!-- teacher payroll tab start here -->
          <div class="tab-pane" id="payroll">
            <div class="row">
              <div class="col-md-12">
                  <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Payroll Information</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h2>Put content here for teacher Payroll</h2>
              </div>
            </div>
          </div>
          <!-- teacher payroll tab close here -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- main content close -->
</div>
<?php } ?>
<?php 
if ($userType == "Student") {
  echo "heloooooo World";
}
 ?>	
</body>
</html>

<?php 
  if (isset($_GET['sms'])) {
    $to = $_GET['to'];
    $message = $_GET['message'];
    // sms ....
    $type = "xml";
    $id = "Brookfieldclg";
    $pass = "college42";
    $lang = "English";
    $mask = "Brookfield";
    // Data for text message
    $message = urlencode($message);
    // Prepare data for POST request
    $data = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to."&lang=".$lang."&mask=".$mask."&type=".$type;
    // Send the POST request with cURL
    $ch = curl_init('http://www.sms4connect.com/api/sendsms.php/sendsms/url');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); //This is the result from SMS4CONNECT
    curl_close($ch);
    
    if ($result) {
        Yii::$app->session->setFlash('success', "SMS sent successfully...");
    }
  }
?>
<script>
// textarea sms counter....
$(document).ready(function(){
    var $remaining = $('#remaining'),
    $messages = $remaining.next();
    var numbers = '<?php //echo $countNumbers; ?>';
    $('#message').keyup(function(){
        var chars = this.value.length,
        messages = Math.ceil(chars / 160),
        remaining = messages * 160 - (chars % (messages * 160) || messages * 160);
        $messages.text('/ Count SMS (' + messages + ')');
        $messages.css('color', 'red');
        $remaining.text(remaining + ' characters remaining');
      
        $('#count').val(messages);
      var countSMS = $('#count').val();
        //var sms = parseInt(countSMS * numbers);
        $('#sms').val("Your Consumed SMS: (" + countSMS+ ")");
    });
});
</script>