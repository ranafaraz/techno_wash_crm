<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php  
  use yii\helpers\Html;
  use yii\bootstrap\Modal;
  use common\models\StdPersonalInfo;

  if(isset($_GET['std_b_form'])){
    $std_b_form = $_GET['std_b_form'];
  } else {
    $std_b_form = Yii::$app->user->identity->username;
  }
    // Stduent Personal Info..... 
    $stdPersonalInfo = Yii::$app->db->createCommand("SELECT * FROM std_personal_info WHERE std_b_form = '$std_b_form'")->queryAll();
    $number =  $stdPersonalInfo[0]['std_contact_no'];
    $id =  $stdPersonalInfo[0]['std_id'];
    // Student Photo...
    $photo = $stdPersonalInfo[0]['std_photo'];
    //echo $photo;
    // Stduent Guardian Info.....  
    $stdGuardianInfo = Yii::$app->db->createCommand("SELECT * FROM std_guardian_info WHERE std_id = '$id'")->queryAll();
    $stdGuardianId = $stdGuardianInfo[0]['std_guardian_info_id'];
    // Stduent ICE Info.....  
    $stdICEInfo = Yii::$app->db->createCommand("SELECT * FROM std_ice_info WHERE std_id = '$id'")->queryAll();
    // student ICE Name.... 
    if($stdICEInfo==null){
      $stdICEName = 'Not updated...';
      $stdICERelation = 'Not updated...';
      $stdICEContact = 'Not updated...';
      $stdICEAddress = 'Not updated...';
      $stdICEId = 0;
    } else{
      $stdICEId = $stdICEInfo[0]['std_ice_id'];
      $stdICEName = $stdICEInfo[0]['std_ice_name'];  
      $stdICERelation = $stdICEInfo[0]['std_ice_relation'];  
      $stdICEContact = $stdICEInfo[0]['std_ice_contact_no'];
      $stdICEAddress = $stdICEInfo[0]['std_ice_address'];  
    }
    // Stduent Academic Info..... 
    $stdAcademicInfo = Yii::$app->db->createCommand("SELECT * FROM std_academic_info WHERE std_id = '$id'")->queryAll();
    $stdAcademicId = $stdAcademicInfo[0]['academic_id'];
    $stdAcademicClass = $stdAcademicInfo[0]['class_name_id'];  
    $stdSubjectID = $stdAcademicInfo[0]['subject_combination']; 
    $stdSubject = Yii::$app->db->createCommand("SELECT std_subject_name FROM std_subjects WHERE std_subject_id = '$stdSubjectID'")->queryAll();
    $stdSubjects = $stdSubject[0]['std_subject_name'];
    //var_dump($stdSubjects); 
    $className = Yii::$app->db->createCommand("SELECT class_name FROM std_class_name WHERE class_name_id = '$stdAcademicClass'")->queryAll();

    // Stduent Fee Info..... 
    $stdFeeInfo = Yii::$app->db->createCommand("SELECT * FROM std_fee_details WHERE std_id = '$id'")->queryAll();
    $stdFeeId = $stdFeeInfo[0]['fee_id'];

    $stdFeeInstallmentDetails = Yii::$app->db->createCommand("SELECT sfi.installment_no,sfi.installment_amount
       FROM std_fee_installments as sfi
       INNER JOIN std_fee_details as sfd
       ON sfd.fee_id = sfi.std_fee_id
       WHERE sfd.std_id = '$id'")->queryAll();

    // fetching student roll number from `std_enrollment_detail` against selected student `$id`
    $stdRollNo = Yii::$app->db->createCommand("SELECT sed.std_roll_no,seh.session_id,seh.section_id, seh.std_enroll_head_id
    FROM std_enrollment_detail as sed
    INNER JOIN std_enrollment_head as seh
    ON seh.std_enroll_head_id = sed.std_enroll_detail_head_id
    WHERE sed.std_enroll_detail_std_id = '$id'")->queryAll();
    $classHeaId = $stdRollNo[0]['std_enroll_head_id'];
    
?>
<div class="container-fluid">
  <div class="row">
    <section class="content-header">
      <h1 style="color: #3C8DBC;">
        <i class="fa fa-user"></i> Student Profile
      </h1>
    </section>
    <!-- Content Start -->
    <section class="content">
      <?php 
        // display success message
        if (Yii::$app->session->hasFlash('success')) { ?>
          <div class="row">
            <div class="col-md-6 alert alert-success alert-dismissable">
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
               <h4><i class="icon fa fa-check"></i>Saved!</h4>
               <?= Yii::$app->session->getFlash('success') ?>
            </div>
          </div>
      <?php } ?>
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php echo './backend/web/'.$photo; ?>" alt="User profile picture">
                <!-- <div class="photo-edit text-center">
                  <a href="./std-personal-info-std-photo?id=<?php echo $id; ?>"><i class="fa fa-pencil"></i></a>
                </div> -->
                <h3 class="profile-username text-center" style="color: #3C8DBC;"><?php echo $stdPersonalInfo[0]['std_name'] ?></h3>
                <p class="text-muted text-center"><!-- Software Engineer --></p>
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Roll #:</b> <a class="pull-right"><?php 
                    if (empty($stdRollNo[0]['std_roll_no'])) {
                      echo "N/A";
                    }
                    else
                    {
                      echo $stdRollNo[0]['std_roll_no'];
                    }
                     ?></a>
                  </li>
                  <li class="list-group-item" style="height: 75px;">
                    <b>Class:</b><br>
                    <a><?php echo $className[0]['class_name'] ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="pull-right"><?php echo $stdPersonalInfo[0]['std_email'] ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Contact #:</b> <a class="pull-right"><?php echo $stdPersonalInfo[0]['std_contact_no']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status:</b> <a class="pull-right">
                      
                      <?php 
                        if ($stdPersonalInfo[0]['status'] == "Active") {?>
                        <span class="label label-success"> 
                        <?php echo $stdPersonalInfo[0]['status']; ?> 
                        </span>
                    <?php } else {?>
                        <span class="label label-danger"> 
                        <?php echo $stdPersonalInfo[0]['status']; ?> 
                        </span>
                    <?php } ?>
                  </a>
                  </li>
                  <li class="list-group-item">
                    <b>Academic Status:</b> <a class="pull-right">
                      <?php 
                        if ($stdPersonalInfo[0]['academic_status'] == "Active") {?>
                        <span class="label label-success"> 
                        <?php echo $stdPersonalInfo[0]['academic_status']; ?> 
                        </span>
                    <?php } else if ($stdPersonalInfo[0]['academic_status'] == "Promote"){?>
                        <span class="label label-primary"> 
                        <?php echo $stdPersonalInfo[0]['academic_status']; ?> 
                        </span>
                    <?php } else if ($stdPersonalInfo[0]['academic_status'] == "Left"){?>
                      <span class="label label-danger"> 
                        <?php echo $stdPersonalInfo[0]['academic_status']; ?> 
                        </span>
                      <?php }else{ ?>
                        <span class="label label-warning"> 
                        <?php echo $stdPersonalInfo[0]['academic_status']; ?> 
                        </span>
                      <?php } ?>
                    </a>
                  </li>
                </ul>
                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- About Me Box -->
            <!-- /.box -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#personal" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-user-circle" ></i>Personal Info</a></li>
                <li><a href="#guardian" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-user"></i>Guardian Info</a></li>
                <li><a href="#ice" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-user-o"></i>ICE Info</a></li>
                <li><a href="#academic" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-book"></i>Academic Info</a></li>
                <li><a href="#fee" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-money"></i> Fee Details</a></li>
                <li><a href="#vouchar" data-toggle="tab" style="color: #3C8DBC;"><i class="fa fa-money"></i> Vouchar Details</a></li>
              </ul>
              <!-- student personal info Tab start -->
              <div class="tab-content">
                <div class="active tab-pane" id="personal">
                  <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Personal Information</p>
                    </div>
                    <div class="col-md-7">
                      <div  style="float: right;">
                        <div class="modal fade" id="modal-default">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">SMS</h4>
                              </div>
                              <form method="get" action="">
                                <div class="modal-body">  
                                  <label>Reciever Name</label>
                                  <input type="hidden" name="to" value="<?php echo $stdPersonalInfo[0]['std_contact_no']; ?>" class="form-control">
                                  <input type="text" name="std_name" value="<?php echo $stdPersonalInfo[0]['std_name']; ?>" class="form-control" readonly=""><br>
                                  <label>SMS Content</label>
                                    <textarea name="message" rows="5" class="form-control" id="message"></textarea>
                                    <p>
                                      <span><b>NOTE:</b> 160 characters = 1 SMS</span>
                                        <span id="remaining" class="pull-right">160 characters remaining </span>
                                      <span id="messages" style="text-align: center;">/ Count SMS(0)</span>
                                      <input type="hidden" value="" id="count"><br>
                                      <input type="text" value="" id="sms" style="border: none; color: green; font-weight: bold;">
                                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    </p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                  <button type="submit" name="sms" class="btn btn-primary btn-sm">Send SMS</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                      </div>
                    </div>
                  </div><hr>
                  <!-- student info start -->
                    <div class="row">
                      <div class="col-md-6" style="border-right: 1px dashed;">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Student ID:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_id'] ?></td>
                            </tr>
                            <tr>
                              <th>Student Name:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_name'] ?></td>
                            </tr>
                            <tr>
                              <th>Father's Name:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_father_name'] ?></td>
                            </tr>
                            <tr>
                              <th>Gender:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_gender'] ?></td>
                            </tr>
                            <tr>
                              <th>Date of Birth:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_DOB'] ?></td>
                            </tr>
                            <tr>
                              <th>Temporary Address:</th>
                            </tr>
                            <tr>
                              <td><?php echo $stdPersonalInfo[0]['std_temporary_address'] ?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-stripped">
                          <thead>
                            <tr>
                              <th>CNIC:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_b_form'] ?></td>
                            </tr>
                            <tr>
                              <th>District:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_district'] ?></td>
                            </tr>
                            <tr>
                              <th>Tehseel:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_tehseel'] ?></td>
                            </tr>
                            <tr>
                              <th>Religion:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_religion'] ?></td>
                            </tr>
                            <tr>
                              <th>Nationality:</th>
                              <td><?php echo $stdPersonalInfo[0]['std_nationality'] ?></td>
                            </tr>
                            <tr>
                              <th>Permanent Address:</th>
                            </tr>
                            <tr>
                              <td><?php echo $stdPersonalInfo[0]['std_permanent_address'] ?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  <!-- student info close -->
                </div>
                <!-- student personal info Tab close -->
                <!-- ******************************* -->
                <!-- Guardian tab start here -->
                <div class="tab-pane" id="guardian">
                  <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Guardian Information</p>
                    </div>
                  </div><hr>
                  <!-- guardian info start -->
                  <div class="row">
                      <div class="col-md-6" style="border-right: 1px dashed;">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Guardian Name:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_name'] ?></td>
                            </tr>
                            <tr>
                              <th>Relation:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_relation'] ?></td>
                            </tr>
                            <tr>
                              <th>CNIC:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_cnic'] ?></td>
                            </tr>
                            <tr>
                              <th>Gurdian Email:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_email'] ?></td>
                            </tr>
                            <tr>
                              <th>Monthly Income:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_monthly_income'] ?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-stripped">
                          <thead>
                            <tr>
                              <th>Contact No. 1:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_contact_no_1'] ?></td>
                            </tr>
                            <tr>
                              <th>Contact No. 2:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_contact_no_2'] ?></td>
                            </tr>
                            <tr>
                              <th>Occupation:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_occupation'] ?></td>
                            </tr>
                             <tr>
                              <th>Designation:</th>
                              <td><?php echo $stdGuardianInfo[0]['guardian_designation'] ?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  <!-- guardian info close -->

                </div>
                <!-- Guardian tab close here -->
                <!-- *********************** -->
                <!-- ICE tab start here -->
                <div class="tab-pane" id="ice">
                 <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> ICE Information</p>
                    </div>
                  </div><hr>
                  <!-- ICE info start -->
                    <div class="row">
                      <div class="col-md-6">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>ICE Name:</th>
                              <td><?php echo $stdICEName; ?></td>
                            </tr>
                            <tr>
                              <th>Relation:</th>
                              <td><?php echo $stdICERelation; ?></td>
                            </tr>
                            <tr>
                              <th>Contact No:</th>
                              <td><?php echo $stdICEContact; ?></td>
                            </tr>
                            <tr>
                              <th>Address:</th>
                              <td><?php echo $stdICEAddress; ?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  <!-- ICE info close -->
                </div>
                <!-- ICE tab close here -->
                <!-- ****************** -->
                <!-- Academic tab start here -->
                <div class="tab-pane" id="academic">
                 <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Academic Information</p>
                    </div>
                  </div><hr>
                  <!-- Academic info start -->
                    <div class="row">
                      <div class="col-md-6" style="border-right:1px dashed; ">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Session:</th>
                              <td>
                                <?php 
                                if(empty($stdRollNo[0]['session_id'])){
                                  echo 'N/A';
                                } else {
                                        $sessId = $stdRollNo[0]['session_id'];
                                        $sessName = Yii::$app->db->createCommand("SELECT session_name FROM    std_sessions WHERE session_id = '$sessId'")->queryAll();
                                        echo $sessName[0]['session_name'];
                                }
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <th>Section:</th>
                              <td>
                                 <?php 
                                if(empty($stdRollNo[0]['section_id'])){
                                    echo 'N/A';
                                } else {
                                    $secId = $stdRollNo[0]['section_id'];
                                    $secName = Yii::$app->db->createCommand("SELECT section_name FROM std_sections WHERE section_id = '$secId'")->queryAll();
                                    echo $secName[0]['section_name'];
                                  } 
                                ?> 
                              </td>
                            </tr>
                            <tr  colspan="2">
                              <th>Class:</th>
                              <td><?php echo $className[0]['class_name']; ?></td>
                            </tr>
                            <tr>
                              <th>Subject Combination:</th>
                            </tr>
                            <tr>
                              <td colspan="2"><?php echo $stdSubjects ?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="col-md-6">
                         <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Previous Class:</th>
                              <td><?php echo $stdAcademicInfo[0]['previous_class']?></td>
                            </tr>
                            <tr>
                              <th>Previous Class Roll No:</th>
                              <td><?php echo $stdAcademicInfo[0]['previous_class_rollno']?></td>
                            </tr>
                            <tr>
                              <th>Passing Year:</th>
                              <td><?php echo $stdAcademicInfo[0]['passing_year']?></td>
                            </tr>
                            <tr>
                              <th>Obtained Marks:</th>
                              <td><?php echo $stdAcademicInfo[0]['obtained_marks']?></td>
                            </tr>
                            <tr>
                              <th>Total Marks:</th>
                              <td><?php echo $stdAcademicInfo[0]['total_marks']?></td>
                            </tr>
                            <tr>
                              <th>Grades:</th>
                              <td><?php echo $stdAcademicInfo[0]['grades']?></td>
                            </tr>
                            <tr>
                              <th>Percentage:</th>
                              <td><?php echo round($stdAcademicInfo[0]['percentage'],2)."%"?></td>
                            </tr>
                          </thead>
                        </table> 
                      </div>
                    </div>
                  <!-- Academic info close -->
                </div>
                <!-- Academic tab close here -->
                <!-- *********************** -->
                <!-- Fee tab start here -->
                <div class="tab-pane" id="fee">
                 <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Fee Information</p>
                    </div>
                  </div><hr>
                  <!-- Fee info start -->
                    <div class="row">
                      <div class="col-md-6" style="border-right:1px dashed; ">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Fee Category:</th>
                              <td>Monthly</td>
                            </tr>
                            <tr>
                              <th>Admission Fee:</th>
                              <td><?php echo  $stdFeeInfo[0]['admission_fee'] ?></td>
                            </tr>
                            <tr>
                              <th>Admission Fee Discount:</th>
                              <td><?php echo  $stdFeeInfo[0]['addmission_fee_discount'] ?></td>
                            </tr>
                            <tr>
                              <th>Net Admission Fee:</th>
                              <td><?php echo  $stdFeeInfo[0]['net_addmission_fee'] ?></td>
                            </tr>
                            <tr>
                              <th>Tuition Fee:</th>
                              <td><?php echo  $stdFeeInfo[0]['tuition_fee'] ?></td>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <!-- <div class="col-md-6">
                         
                      </div> -->
                    </div>`
                  <!-- Fee info close -->
                </div>
                <!-- Fee tab close here -->
                <div class="tab-pane" id="vouchar">
                  
                    <?php
                     // h alias for Head and s alias for session 
                      $fetch_class= Yii::$app->db->createCommand("SELECT seh.session_id,s.status FROM std_sessions AS s INNER JOIN std_enrollment_head AS seh ON seh.session_id=s.session_id WHERE s.status='Active' AND seh.std_enroll_head_id='$classHeaId'")->queryAll(); 
                        if (!empty($fetch_class)) {?>
                    <div class="row">
                    <div class="col-md-5">
                      <p style="font-size: 20px; color: #3C8DBC;"><i class="fa fa-info-circle" style="font-size: 20px;"></i> Fee Information</p>
                    </div>
                  </div><hr>
                  <!-- Fee info start -->
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-striped table-hover table-bordered">
                          <thead>
                            <tr>
                              <th>Voucher No</th>
                              <th>Month</th>
                              <th>Issue Date</th>
                              <th> Due Date</th>
                              <th>Amount</th>                 
                              <th>Paid Amount</th>
                              <th>Remaining Amount</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- Fetching the student fee Data from -->
                            <?php 
                              $stdFeeInfo = Yii::$app->db->createCommand("SELECT * FROM fee_transaction_head WHERE std_id = '$id'")->queryAll();
                              $no_of_voucher=count($stdFeeInfo);
                              for ($i=0; $i <$no_of_voucher ; $i++) {
                                $voucher_no=$stdFeeInfo[$i]['voucher_no'];
                                //echo $voucher_no;
                                  $FeeMonthInfo = Yii::$app->db->createCommand("SELECT month FROM fee_month_detail WHERE voucher_no = '$voucher_no'")->queryAll();
                                    $voucher=$FeeMonthInfo[0]['month'];
                                    $month=date("Y - F",strtotime($voucher));
                                    //echo $voucher;
                                    if ($stdFeeInfo[$i]['paid_amount']==0) {
                                      $status="Unpaid";
                                      $label="label label-danger";
                                    }
                                    elseif ($stdFeeInfo[$i]['total_amount']==$stdFeeInfo[$i]['paid_amount']) {
                                      $status="Paid";
                                      $label="label label-success";
                                    }
                                    else
                                    {
                                      $status="Paritialy Paid";
                                      $label="label label-warning";
                                    }
                                ?> 
                                <tr>
                              
                              <td><?php echo $stdFeeInfo[$i]['voucher_no']; ?></td>
                              <td><?php echo $month;?></td>
                              <td>-------</td>
                              <td>-------</td>
                              <td><?php echo $stdFeeInfo[$i]['total_amount']; ?></td>
                              
                              <td><?php echo $stdFeeInfo[$i]['paid_amount']; ?></td>
                              <td><?php echo $stdFeeInfo[$i]['remaining']; ?></td>
                              <td><span class="<?php echo $label ?>"><?php echo $status; ?></span></td>
                            </tr>  
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- <div class="col-md-6">
                         
                      </div> -->
                    </div>
                        <?php
                        }

                      ?>
                  
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
      <!--  -->
  </div>
</div>
</section>
</div>
</div>

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
        Yii::$app->session->setFlash('success', "SMS sent successfully...").$result;
    }
  }
?>