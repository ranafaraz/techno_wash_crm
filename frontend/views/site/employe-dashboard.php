<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
//$this->title = 'SMART EDUCATION';
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style type="text/css">
    #abc{
      opacity:0.5;
    }
    #abc:hover{
      opacity: 2.0;
      filter: alpha(opacity=100);
    }
  </style>
</head>
<body>

</body>
</html>
<?php 
      $branch_id = Yii::$app->user->identity->branch_id;
      $userType = Yii::$app->user->identity->user_type;
      $username = Yii::$app->user->identity->username;
      
      //echo $userType;
// online user signup portal strat
      if ($userType == 'Inquiry') { 

        $userId = Yii::$app->user->identity->id;
        //echo $userId;
        $userData = Yii::$app->db->createCommand("SELECT *
        FROM user
        WHERE id = '$userId'")->queryAll();
        $userInfo = $userData[0]['first_name'];

        ?>
        <div class="site-index">
    <!-- Main content -->
    <section class="content" style="padding:0px;margin-top:-20px;">
      <h3 style="border-left:3px solid #00A65A;font-family:georgia;" class="well"><i class="glyphicon glyphicon-hand-right" style="color:#00A65A;"></i> Welcome <b style="color:#00A65A;"><?php echo $userInfo; ?>,</b> to <b>E - </b> Portal</h3>

      <!-- Small boxes (Stat box) -->
      <div class="row" style="padding:40px;">
        <div class="col-md-3">
          <div class="panel panel-default" id="abc" id="hide">
            <div class="panel-body" style="text-align: center;">
              <h2>Admissions</h2>
              <img src="images/std.png" width="100px" height="100px">
              <hr style="border-color:lightgray;">
              <a href="./student-details" class="btn btn-success btn-block">Apply</a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-default" id="abc">
            <div class="panel-body" style="text-align: center;">
              <h2>Entry Test</h2>
              <img src="images/std.png" width="100px" height="100px">
              <hr style="border-color:lightgray;">
              <button class="btn btn-success btn-block">Apply</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-default" id="abc">
            <div class="panel-body" style="text-align: center;">
              <h2>Hostel</h2>
              <img src="images/std.png" width="100px" height="100px">
              <hr style="border-color:lightgray;">
              <button class="btn btn-success btn-block">Apply</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-default" id="abc">
            <div class="panel-body" style="text-align: center;">
              <h2>Careers</h2>
              <img src="images/std.png" width="100px" height="100px">
              <hr style="border-color:lightgray;">
              <button class="btn btn-success btn-block">Apply</button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Small boxes (Stat box) -->
      <div class="row" style="padding:40px;">
        <div class="col-md-3">
          <div class="panel panel-default" id="abc">
            <div class="panel-body" style="text-align: center;">
              <h2>Short Courses</h2>
              <img src="images/std.png" width="100px" height="100px">
              <hr style="border-color:lightgray;">
              <button class="btn btn-success btn-block">Apply</button>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-default" id="abc">
            <div class="panel-body" style="text-align: center;">
              <h2>News</h2>
              <img src="images/std.png" width="100px" height="100px">
              <hr style="border-color:lightgray;">
              <button class="btn btn-success btn-block">Apply</button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->


      <!-- Message of the day start -->
      <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box skin-dark callout-warning">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
              <h4 style="float: left;">Message of the day!</h4>  
              <h4 style="float:right">
                <span id="hr"></span>
                <span id="min"></span>
                <span id="sec"></span> -
                <?php echo date('l d-M-Y');?> 
              </h4>
              <br><br>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                  <marquee onmouseover="this.stop();" onmouseout="this.start();">
                    <?php 
                      $message = Yii::$app->db->createCommand("SELECT msg_details FROM msg_of_day")->queryAll();
                      $date = 2;
                      $msg = $message[$date]['msg_details'];
                      echo $msg;
                    ?>
                  </marquee>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>
      <!-- Message of the day close -->
      
      <!-- Notice Row Start -->
      <div class="row">
        <!-- Notice Panel Start -->
        <div class="col-md-7">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active">
                <a href="#employees" data-toggle="tab">
                  <i class="fa fa-user" style="color: #F39C12;"></i>
                  Employees
                </a>
              </li>
              <li class="pull-left header"><i class="fa fa-inbox" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Notice Board</span></li>
            </ul>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- ***************** -->
              <!-- employees tab start -->
              <?php 
              $date = date('Y-m-d');
              $employeeNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Employees' AND is_status ='Active' AND CAST(notice_start AS DATE) <= '$date' AND CAST(notice_end AS DATE) >= '$date'")->queryAll();
              ?>
              <div class="tab-pane active" id="employees">
                <?php if(!empty($employeeNotice)) { 
                        $empNoticeCount = count($employeeNotice);
                        for ($i=0; $i < $empNoticeCount; $i++) {
                  ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-warning" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                      <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalEmployees" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #F39C12;">
                              <?php echo $employeeNotice[$i]['notice_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $employeeNotice[$i]['notice_description']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                        }
                        //end of for loop
                      }
                      // end of if....
                      else {
                        $empNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Employees' AND is_status ='Active' AND CAST(notice_end AS DATE) < '$date'")->queryAll();

                        foreach ($empNotice as $key => $value) {
                          $empNoticeId = $value['notice_id'];
                          var_dump($empNoticeId);
                          $empNotice = Yii::$app->db->createCommand("UPDATE notice SET is_status = 'Inactive' WHERE notice_id = '$empNoticeId'")->execute();
                        } 
                ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // end of else
                ?>
              </div>
              <!-- employees tab close -->
              <!-- ***************** -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->

        <!-- Notice Panel Start -->
        <div class="col-md-5">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li>
                <a href="#upcoming" data-toggle="tab">
                  <i class="fa fa-recycle" style="color: #5AC594;"></i> 
                  Upcoming
                </a>
              </li>
              <li class="active">
                <a href="#today" data-toggle="tab">
                  <i class="fa fa-clock-o" style="color: #00C0EF;"></i> 
                  Today
                </a>
              </li>
              <li class="pull-left header"><i class="fa fa-calendar" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Events</span></li>
            </ul>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- today tab start -->
              <?php 
                $date = date('Y-m-d');
                $todayEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) =  '$date'")->queryAll();
              ?> 
              <div class="tab-pane active" id="today">
                <?php if(!empty($todayEvent)) { ?> 
                  <div class="alert bg-info text-info">
                    <div class="row">
                      <div class="col-md-2">
                        <span class="label label-info" style="padding: 3px;">
                          <i class="fa fa-calendar"></i>
                          <?php echo date('D d-M-Y'); ?>
                        </span>
                      </div>
                      <div class="col-md-10">
                        <h4 style="margin: 0px 20px">
                          <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalTodays" data-toggle="tooltip" title="Click me for event details!">
                            <span>
                              <h4 style="color: #00C0EF;">
                                <?php echo $todayEvent[0]['event_title']; ?>
                              </h4>
                            </span>   
                          </button>
                        </h4>
                      </div>
                    </div>
                    <div class="row">  
                      <div class="col-md-12">
                        <span><?php echo $todayEvent[0]['event_detail']; ?></span>
                      </div>
                    </div>
                  </div>
                  <?php 
                    }
                    // ending of if...
                    else {
                  ?>
                  <div class="alert bg-info text-info">
                    <div class="row">  
                      <div class="col-md-12">
                        <i class="fa fa-warning"></i> 
                        No event for today! 
                      </div>
                    </div>
                  </div>
                  <?php 
                    }
                    // ending of else...
                  ?>
                </div>
              <!-- today tab close -->
              <!-- ***************** -->
              <!-- Upcomming tab start -->
              <?php 
                $date = date('Y-m-d');
                $upcomingEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) = '$date' OR CAST(event_end_datetime AS DATE) >= '$date'")->queryAll();
              ?> 
              <div class="tab-pane" id="upcoming">
                <?php if(!empty($upcomingEvent)) { ?> 
                <div class="alert bg-success text-success">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-success" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                     <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalUpcomings" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00A65A;">
                              <?php echo $upcomingEvent[0]['event_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $upcomingEvent[0]['event_detail']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-success text-success">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No event for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else...
                ?>
              </div>
              <!-- Upcomming tab close -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->
      </div>
      <!-- Notice Row CLose -->
    </section>
    <!-- /.content -->
  </div>
<!-- *************************** -->
      <?php }
// online user signup portal close
// for teacher portal
if ($userType == 'Teacher') { 

  $teacherCnic = Yii::$app->user->identity->username; 
  $teacherName = Yii::$app->db->createCommand("SELECT  emp_name FROM  emp_info WHERE emp_cnic = '$teacherCnic' AND emp_status = 'Active' AND delete_status = 1")->queryAll();

  if(empty($teacherName)){
    Yii::$app->session->setFlash('error', 'You are not authorized to login Teacher\'s penal.<br /> Please use valid Username & Password.<br />Or contact Administrator for details.');
  } else {

 ?>
  <div class="site-index">
    <!-- Main content -->
    <section class="content" style="padding:0px;margin-top:-20px;">
      <h3 style="border-left:3px solid #00A65A;font-family:georgia;" class="well"><i class="glyphicon glyphicon-hand-right" style="color:#00A65A;"></i> Welcome <b style="color:#00A65A;"><?php echo $teacherName[0]['emp_name']; ?>,</b> to <b>Teacher</b> Portal</h3>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <p>&nbsp;</p>
              <h4><b>Profile</b></h4>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="./employee-portfolio" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <p>&nbsp;</p>
              <h4><b>Attendance</b></h4>
            </div>
            <div class="icon">
              <i class="fa fa-check-square-o"></i>
            </div>
            <a href="./premium-version" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <p>&nbsp;</p>
              <h4><b>Time Table</b></h4>
            </div>
            <div class="icon">
              <i class="fa fa-calendar"></i>
            </div>
            <a href="./premium-version" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <p>&nbsp;</p>
              <h4><b>Date Sheet</b></h4>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-eye-open" style="font-size: 70px;"></i>
            </div>
            <a href="./view-datesheet" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- Message of the day start -->
      <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box skin-dark callout-warning">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
              <h4 style="float: left;">Message of the day!</h4>  
              <h4 style="float:right">
                <span id="hr"></span>
                <span id="min"></span>
                <span id="sec"></span> -
                <?php echo date('l d-M-Y');?> 
              </h4>
              <br><br>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                  <marquee onmouseover="this.stop();" onmouseout="this.start();">
                    <?php 
                      $message = Yii::$app->db->createCommand("SELECT msg_details FROM msg_of_day")->queryAll();
                      $date = 2;
                      $msg = $message[$date]['msg_details'];
                      echo $msg;
                    ?>
                  </marquee>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>
      <!-- Message of the day close -->
      
      <!-- Notice Row Start -->
      <div class="row">
        <!-- Notice Panel Start -->
        <div class="col-md-7">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active">
                <a href="#employees" data-toggle="tab">
                  <i class="fa fa-user" style="color: #F39C12;"></i>
                  Employees
                </a>
              </li>
              <li class="pull-left header"><i class="fa fa-inbox" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Notice Board</span></li>
            </ul>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- ***************** -->
              <!-- employees tab start -->
              <?php 
              $date = date('Y-m-d');
              $employeeNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Employees' AND is_status ='Active' AND CAST(notice_start AS DATE) <= '$date' AND CAST(notice_end AS DATE) >= '$date'")->queryAll();
              ?>
              <div class="tab-pane active" id="employees">
                <?php if(!empty($employeeNotice)) { 
                        $empNoticeCount = count($employeeNotice);
                        for ($i=0; $i < $empNoticeCount; $i++) {
                  ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-warning" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                      <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalEmployees" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #F39C12;">
                              <?php echo $employeeNotice[$i]['notice_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $employeeNotice[$i]['notice_description']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                        }
                        //end of for loop
                      }
                      // end of if....
                      else {
                        $empNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Employees' AND is_status ='Active' AND CAST(notice_end AS DATE) < '$date'")->queryAll();

                        foreach ($empNotice as $key => $value) {
                          $empNoticeId = $value['notice_id'];
                          var_dump($empNoticeId);
                          $empNotice = Yii::$app->db->createCommand("UPDATE notice SET is_status = 'Inactive' WHERE notice_id = '$empNoticeId'")->execute();
                        } 
                ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // end of else
                ?>
              </div>
              <!-- employees tab close -->
              <!-- ***************** -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->

        <!-- Notice Panel Start -->
        <div class="col-md-5">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li>
                <a href="#upcoming" data-toggle="tab">
                  <i class="fa fa-recycle" style="color: #5AC594;"></i> 
                  Upcoming
                </a>
              </li>
              <li class="active">
                <a href="#today" data-toggle="tab">
                  <i class="fa fa-clock-o" style="color: #00C0EF;"></i> 
                  Today
                </a>
              </li>
              <li class="pull-left header"><i class="fa fa-calendar" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Events</span></li>
            </ul>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- today tab start -->
              <?php 
                $date = date('Y-m-d');
                $todayEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) =  '$date'")->queryAll();
              ?> 
              <div class="tab-pane active" id="today">
                <?php if(!empty($todayEvent)) { ?> 
                  <div class="alert bg-info text-info">
                    <div class="row">
                      <div class="col-md-2">
                        <span class="label label-info" style="padding: 3px;">
                          <i class="fa fa-calendar"></i>
                          <?php echo date('D d-M-Y'); ?>
                        </span>
                      </div>
                      <div class="col-md-10">
                        <h4 style="margin: 0px 20px">
                          <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalTodays" data-toggle="tooltip" title="Click me for event details!">
                            <span>
                              <h4 style="color: #00C0EF;">
                                <?php echo $todayEvent[0]['event_title']; ?>
                              </h4>
                            </span>   
                          </button>
                        </h4>
                      </div>
                    </div>
                    <div class="row">  
                      <div class="col-md-12">
                        <span><?php echo $todayEvent[0]['event_detail']; ?></span>
                      </div>
                    </div>
                  </div>
                  <?php 
                    }
                    // ending of if...
                    else {
                  ?>
                  <div class="alert bg-info text-info">
                    <div class="row">  
                      <div class="col-md-12">
                        <i class="fa fa-warning"></i> 
                        No event for today! 
                      </div>
                    </div>
                  </div>
                  <?php 
                    }
                    // ending of else...
                  ?>
                </div>
              <!-- today tab close -->
              <!-- ***************** -->
              <!-- Upcomming tab start -->
              <?php 
                $date = date('Y-m-d');
                $upcomingEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) = '$date' OR CAST(event_end_datetime AS DATE) >= '$date'")->queryAll();
              ?> 
              <div class="tab-pane" id="upcoming">
                <?php if(!empty($upcomingEvent)) { ?> 
                <div class="alert bg-success text-success">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-success" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                     <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalUpcomings" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00A65A;">
                              <?php echo $upcomingEvent[0]['event_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $upcomingEvent[0]['event_detail']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-success text-success">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No event for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else...
                ?>
              </div>
              <!-- Upcomming tab close -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->
      </div>
      <!-- Notice Row CLose -->
    </section>
    <!-- /.content -->
  </div>
<!-- *************************** -->
<!-- Employee Notice Modal Start -->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-warning" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-warning"> <b>View Notice Details</b></h4>',
  "id"=>"modalEmployee",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($employeeNotice)) { ?>
<div id='employeeContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <thead>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $employeeNotice[0]['notice_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $employeeNotice[0]['notice_description']; ?></td>
          </tr>
          <tr>
            <td><b>Notice For</b></td>
            <td><?php echo $employeeNotice[0]['notice_user_type']; ?></td>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php 
}
Modal::end();
// modal content close.....
?>
<!-- Employees Notice Modal Close -->
<!-- **************************** -->
<!-- Todays Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-info" style="float:left;margin:12px 1px; color: #00C0EF;"></i><h4 style="float:left; color: #00C0EF;" class="text-info"> <b>View Notice Details</b></h4>',
  "id"=>"modalToday",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($todayEvent)) { ?>
<div id='todayContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $todayEvent[0]['event_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $todayEvent[0]['event_detail']; ?></td>
          </tr>
          <tr>
            <td><b>Start Date Time</b></td>
            <td><?php echo $todayEvent[0]['event_start_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>End Date Time</b></td>
            <td><?php echo $todayEvent[0]['event_end_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event Venue</b></td>
            <td><?php echo $upcomingEvent[0]['event_venue']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Todays Notice Modal Close -->
<!-- ************************* -->
<!-- Upcomings Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-success" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-success"> <b>View Notice Details</b></h4>',
  "id"=>"modalUpcoming",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($upcomingEvent)) { ?>
<div id='todayContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $upcomingEvent[0]['event_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $upcomingEvent[0]['event_detail']; ?></td>
          </tr>
          <tr>
            <td><b>Event Start Datetime</b></td>
            <td><?php echo $upcomingEvent[0]['event_start_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event End Datetime</b></td>
            <td><?php echo $upcomingEvent[0]['event_end_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event Venue</b></td>
            <td><?php echo $upcomingEvent[0]['event_venue']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Upcomings Notice Modal Close -->
<!-- Script for tooltip -->
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
</script>
<script>
  $(document).ready(function(){
    $('#hide').hide();   
  });
</script>

<style type="text/css">
  #modalStudents{
    text-decoration: none;
  }
  #modalEmployees{
    text-decoration: none;
  }
  #modalParents{
    text-decoration: none;
  }
  #modalTodays{
    text-decoration: none;
  }
  #modalUpcomings{
    text-decoration: none;
  }
</style>

<script type="text/javascript">
  function clock() {
      const fullDate = new Date();
      let hours = fullDate.getHours();
      let mins = fullDate.getMinutes();
      let secs = fullDate.getSeconds();
      if (hours>12) {
        var am = "PM"
        hours=hours-12;
      }
      else{
        var am = "AM";
      }
      if (hours < 10) {
          hours = "0" + hours;
      }
      if (mins < 10) {
          mins = "0" + mins;
      }
      if (secs < 10) {
          secs = "0" + secs;
      }
      document.getElementById('hr').innerHTML = hours+':';
      document.getElementById('min').innerHTML = mins+':';
      document.getElementById('sec').innerHTML = secs+' '+am;
  }
  setInterval(clock, 1000)
</script>
<?php 
  } // end of else
}  // teacher index page end here.....
// student index page start here.....
if ($userType == 'Student') {
  $stdCnic = Yii::$app->user->identity->username;
  $stdPersonalInfo = Yii::$app->db->createCommand("SELECT std_name FROM std_personal_info WHERE std_b_form = '$stdCnic'")->queryAll();
  ?>
  <div class="site-index">
    <!-- Main content -->
    <section class="content" style="padding:0px;margin-top:-20px;">
      <h3 style="border-left:3px solid #00A65A;font-family:georgia;" class="well">Welcome <b style="color:#00A65A;"><?php echo $stdPersonalInfo[0]['std_name']; ?>,</b> to <b>Student</b> Portal</h3>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner" style="text-align: center;">
              <h3><i class="fa fa-eye"></i></h3>

              <p>Profile View</p>
            </div>
            <!-- <div class="icon">
              <i class="fa fa-user"></i>
            </div> -->
            <a href="./std-profile" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner" style="text-align: center;">
              <?php 
              // $query = (new \yii\db\Query())->from('emp_info');
              // $id = $query->count('emp_id'); ?>
              <h3><i class="fa fa-money"></i></h3>
              <p>Fee</p>
            </div>
           <!--  <div class="icon">
              <i class="fa fa-user"></i>
            </div> -->
            <a href="./std-fee" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner" style="text-align: center;">
             <?php 
              // $query = (new \yii\db\Query())->from('user');
              // $id = $query->count('id'); ?>
              <h3><i class="fa fa-calendar"></i></h3>
              <p>Time Table</p>
            </div>
            <!-- <div class="icon">
              <i class="fa fa-user"></i>
            </div> -->
            <a href="./premium-version" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner" style="text-align: center;">
              <h3><i class="fa fa-calendar"></i></h3>
              <p>View Date Sheet</p>
            </div>
            <!-- <div class="icon">
              <i class="glyphicon glyphicon-eye-open" style="font-size: 70px;"></i>
            </div> -->
            <a href="./std-exams" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- Message of the day start -->
      <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box skin-dark callout-warning">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
              <h4 style="float: left;">Message of the day!</h4>  
              <h4 style="float:right">
                <span id="hr"></span>
                <span id="min"></span>
                <span id="sec"></span> -
                <?php echo date('l d-M-Y');?> 
              </h4>
              <br><br>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                <span class="progress-description">
                    <marquee onmouseover="this.stop();" onmouseout="this.start();">
                      <?php 
                        $message = Yii::$app->db->createCommand("SELECT msg_details FROM msg_of_day")->queryAll();
                        $date = 2;
                        $msg = $message[$date]['msg_details'];
                        echo $msg;
                      ?>
                    </marquee>
                </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>
      <!-- Message of the day close -->
      
      <!-- Notice Row Start -->
      <div class="row">
        <!-- Notice Panel Start -->
        <div class="col-md-7">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <!-- <li>
                <a href="#parents" data-toggle="tab">
                  <i class="fa fa-user-o" style="color: #30BBBB;"></i>
                   Parents
                </a>
              </li> -->
              <li>
                <a href="#student" data-toggle="tab">
                  <i class="fa fa-users" style="color: #00A65A;"></i>
                  Students
                </a
              </li>
               <!-- <li class="active">
                <a href="#employees" data-toggle="tab">
                  <i class="fa fa-user" style="color: #F39C12;"></i>
                  Employees
                </a>
              </li> -->
              <li class="pull-left header"><i class="fa fa-inbox" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Notice Board</span></li>
            </ul>
            <?php 
            $date = date('Y-m-d');
            $studentNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Students' AND is_status ='Active' AND CAST(notice_start AS DATE) >= '$date'")->queryAll();
            ?>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- student tab start -->
              <div class="tab-pane active" id="student">
                <?php if(!empty($studentNotice)) { ?>
                  <div class="alert bg-success text-success">
                    <div class="row">
                      <div class="col-md-2">
                        <span class="label label-success" style="padding: 3px;">
                          <i class="fa fa-calendar"></i>
                          <?php echo date('D d-M-Y'); ?>
                        </span>
                      </div>
                      <div class="col-md-10">
                        <h4 style="margin: 0px 20px">
                          <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalStudents" data-toggle="tooltip" title="Click me for event details!">
                            <span>
                              <h4 style="color: #00A65A;">
                                <?php echo $studentNotice[0]['notice_title']; ?>
                              </h4>
                            </span>   
                          </button>
                        </h4>
                      </div>
                    </div>
                    <div class="row">  
                      <div class="col-md-12">
                        <span><?php echo $studentNotice[0]['notice_description']; ?></span>
                      </div>
                    </div>
                  </div>
                <?php } 
                  else {
                ?>  
                <div class="alert bg-success text-success">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                 </div>
                <?php } ?>
              </div>
              <!-- students tab close -->
              <!-- ***************** -->
              <!-- employees tab start -->
              <?php 
              $date = date('Y-m-d');
              $employeeNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Employees' AND is_status ='Active' AND CAST(created_at AS DATE) =  '$date'")->queryAll();
              ?>
              <div class="tab-pane" id="employees">
                <?php if(!empty($employeeNotice)) { ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-warning" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                      <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalEmployees" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #F39C12;">
                              <?php echo $employeeNotice[0]['notice_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $employeeNotice[0]['notice_description']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // end of if....
                  else {
                ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // end of else
                ?>
              </div>
              <!-- employees tab close -->
              <!-- ***************** -->
              <!-- parents tab start -->
              <!-- /.tab-pane -->
              <?php 
                $date = date('Y-m-d');
                $parentNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Parents' AND is_status ='Active' AND CAST(created_at AS DATE) =  '$date'")->queryAll();
              ?> 
              <div class="tab-pane" id="parents">
              <?php if(!empty($employeeNotice)) { ?>  
                <div class="alert bg-info text-info">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-info" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                        <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalParents" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00C0EF;">
                              <?php echo $parentNotice[0]['notice_title']; ?>
                            </h4>
                          </span>   
                        </button>
                        </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $parentNotice[0]['notice_description']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                    }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-info text-info">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else... 
                ?>
              </div> 
              <!-- parents tab close -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->

        <!-- Notice Panel Start -->
        <div class="col-md-5">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li>
                <a href="#upcoming" data-toggle="tab">
                  <i class="fa fa-recycle" style="color: #5AC594;"></i> 
                  Upcoming
                </a>
              </li>
              <li class="active">
                <a href="#today" data-toggle="tab">
                  <i class="fa fa-clock-o" style="color: #00C0EF;"></i> 
                  Today
                </a>
              </li>
              <li class="pull-left header"><i class="fa fa-calendar" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Events</span></li>
            </ul>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- general tab start -->
              <?php 
                $date = date('Y-m-d');
                $todayEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) =  '$date'")->queryAll();
              ?> 
              <div class="tab-pane active" id="today">
              <?php if(!empty($todayEvent)) { ?> 
                <div class="alert bg-info text-info">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-info" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                      <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalTodays" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00C0EF;">
                              <?php echo $todayEvent[0]['event_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $todayEvent[0]['event_detail']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-info text-info">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No event for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else...
                ?>
              </div>
              <!-- general tab close -->
              <!-- ***************** -->
              <!-- student tab start -->
              <?php 
                $date = date('Y-m-d');
                $upcomingEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) = '$date' OR CAST(event_end_datetime AS DATE) >= '$date'")->queryAll();
              ?> 
              <div class="tab-pane" id="upcoming">
              <?php if(!empty($upcomingEvent)) { ?> 
                <div class="alert bg-success text-success">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-success" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                     <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalUpcomings" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00A65A;">
                              <?php echo $upcomingEvent[0]['event_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $upcomingEvent[0]['event_detail']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-success text-success">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No event for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else...
                ?>
              </div>
              <!-- students tab close -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->
      </div>
      <!-- Notice Row CLose -->
    </section>
    <!-- /.content -->
</div>
<!-- Students Notice Modal Start -->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-success" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-success"> <b>View Notice Details</b></h4>',
  "id"=>"modalStudent",
  "footer"=>"",// always need it for jquery plugin
]);

// modal content start.....
?>
<?php if(!empty($studentNotice)) { ?>
<div id='studentContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <thead>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $studentNotice[0]['notice_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $studentNotice[0]['notice_description']; ?></td>
          </tr>
          <tr>
            <td><b>Notice For</b></td>
            <td><?php echo $studentNotice[0]['notice_user_type']; ?></td>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
// modal content close.....
?>
<!-- Students Notice Modal Close -->
<!-- *************************** -->
<!-- Employee Notice Modal Start -->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-warning" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-warning"> <b>View Notice Details</b></h4>',
  "id"=>"modalEmployee",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($employeeNotice)) { ?>
<div id='employeeContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <thead>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $employeeNotice[0]['notice_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $employeeNotice[0]['notice_description']; ?></td>
          </tr>
          <tr>
            <td><b>Notice For</b></td>
            <td><?php echo $employeeNotice[0]['notice_user_type']; ?></td>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php 
}
Modal::end();
// modal content close.....
?>
<!-- Employees Notice Modal Close -->
<!-- **************************** -->
<!-- Parents Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-info" style="float:left;margin:12px 1px; color: #00C0EF;"></i><h4 style="float:left; color: #00C0EF;" class="text-info"> <b>View Notice Details</b></h4>',
  "id"=>"modalParent",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($parentNotice)) { ?>
<div id='parentContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $parentNotice[0]['notice_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $parentNotice[0]['notice_description']; ?></td>
          </tr>
          <tr>
            <td><b>Notice For</b></td>
            <td><?php echo $parentNotice[0]['notice_user_type']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Parents Notice Modal Close -->
<!-- **************************** -->
<!-- Todays Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-info" style="float:left;margin:12px 1px; color: #00C0EF;"></i><h4 style="float:left; color: #00C0EF;" class="text-info"> <b>View Notice Details</b></h4>',
  "id"=>"modalToday",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($todayEvent)) { ?>
<div id='todayContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $todayEvent[0]['event_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $todayEvent[0]['event_detail']; ?></td>
          </tr>
          <tr>
            <td><b>Start Date Time</b></td>
            <td><?php echo $todayEvent[0]['event_start_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>End Date Time</b></td>
            <td><?php echo $todayEvent[0]['event_end_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event Venue</b></td>
            <td><?php echo $upcomingEvent[0]['event_venue']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Todays Notice Modal Close -->
<!-- ************************* -->
<!-- Upcomings Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-success" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-success"> <b>View Notice Details</b></h4>',
  "id"=>"modalUpcoming",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($upcomingEvent)) { ?>
<div id='todayContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $upcomingEvent[0]['event_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $upcomingEvent[0]['event_detail']; ?></td>
          </tr>
          <tr>
            <td><b>Event Start Datetime</b></td>
            <td><?php echo $upcomingEvent[0]['event_start_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event End Datetime</b></td>
            <td><?php echo $upcomingEvent[0]['event_end_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event Venue</b></td>
            <td><?php echo $upcomingEvent[0]['event_venue']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Upcomings Notice Modal Close -->
<!-- Script for tooltip -->
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
</script>

<style type="text/css">
  #modalStudents{
    text-decoration: none;
  }
  #modalEmployees{
    text-decoration: none;
  }
  #modalParents{
    text-decoration: none;
  }
  #modalTodays{
    text-decoration: none;
  }
  #modalUpcomings{
    text-decoration: none;
  }
</style>

<script type="text/javascript">
  function clock() {
      const fullDate = new Date();
      let hours = fullDate.getHours();
      let mins = fullDate.getMinutes();
      let secs = fullDate.getSeconds();
      if (hours>12) {
        var am = "PM"
        hours=hours-12;
      }
      else{
        var am = "AM";
      }
      if (hours < 10) {
          hours = "0" + hours;
      }
      if (mins < 10) {
          mins = "0" + mins;
      }
      if (secs < 10) {
          secs = "0" + secs;
      }
      document.getElementById('hr').innerHTML = hours+':';
      document.getElementById('min').innerHTML = mins+':';
      document.getElementById('sec').innerHTML = secs+' '+am;
  }
  setInterval(clock, 1000)
</script>
      
 <?php }?>
  <?php
      if ($userType == 'Parent') { 
          $parentCnic = Yii::$app->user->identity->username; 
       $parentName = Yii::$app->db->createCommand("SELECT  guardian_name FROM  std_guardian_info WHERE guardian_cnic = '$parentCnic'")->queryAll();
        ?>
        <div class="site-index">
    <!-- Main content -->
    <section class="content" style="padding:0px;margin-top:-20px;">
      <h3 style="border-left:3px solid #00A65A;font-family:georgia;" class="well">Welcome <b style="color:#00A65A;"><?php echo $parentName[0]['guardian_name']; ?>,</b> to <b>Parent</b> Portal</h3>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php 
              $query = (new \yii\db\Query())->from('std_personal_info');
              $id = $query->count('std_id'); ?>
              <h3><?php echo $id; ?> </h3>

              <p>Class Time Table</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="./std-personal-info" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php 
              $query = (new \yii\db\Query())->from('emp_info');
              $id = $query->count('emp_id'); ?>
              <h3><?php echo $id; ?> </h3>
              <p>Attendance</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="./emp-info" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             <?php 
              $query = (new \yii\db\Query())->from('user');
              $id = $query->count('id'); ?>
              <h3><?php echo $id; ?> </h3>
              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>
              <p>View Date Sheet</p>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-eye-open" style="font-size: 70px;"></i>
            </div>
            <a href="./view-datesheet" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- Message of the day start -->
      <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box skin-dark callout-warning">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
              <h4 style="float: left;">Message of the day!</h4>  
              <h4 style="float:right">
                <span id="hr"></span>
                <span id="min"></span>
                <span id="sec"></span> -
                <?php echo date('l d-M-Y');?> 
              </h4>
              <br><br>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                <span class="progress-description">
                    <marquee onmouseover="this.stop();" onmouseout="this.start();">
                      <?php 
                        $message = Yii::$app->db->createCommand("SELECT msg_details FROM msg_of_day")->queryAll();
                        $date = 2;
                        $msg = $message[$date]['msg_details'];
                        echo $msg;
                      ?>
                    </marquee>
                </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>
      <!-- Message of the day close -->
      
      <!-- Notice Row Start -->
      <div class="row">
        <!-- Notice Panel Start -->
        <div class="col-md-7">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li>
                <a href="#parents" data-toggle="tab">
                  <i class="fa fa-user-o" style="color: #30BBBB;"></i>
                   Parents
                </a>
              </li>
              <!-- <li>
                <a href="#student" data-toggle="tab">
                  <i class="fa fa-users" style="color: #00A65A;"></i>
                  Students
                </a>
              </li>
               <li class="active">
                <a href="#employees" data-toggle="tab">
                  <i class="fa fa-user" style="color: #F39C12;"></i>
                  Employees
                </a>
              </li> -->
              <li class="pull-left header"><i class="fa fa-inbox" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Notice Board</span></li>
            </ul>
            <?php 
            $date = date('Y-m-d');
            $studentNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Students' AND is_status ='Active' AND CAST(notice_start AS DATE) >= '$date'")->queryAll();
            ?>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- student tab start -->
              <div class="tab-pane active" id="student">
                <?php if(!empty($studentNotice)) { ?>
                  <div class="alert bg-success text-success">
                    <div class="row">
                      <div class="col-md-2">
                        <span class="label label-success" style="padding: 3px;">
                          <i class="fa fa-calendar"></i>
                          <?php echo date('D d-M-Y'); ?>
                        </span>
                      </div>
                      <div class="col-md-10">
                        <h4 style="margin: 0px 20px">
                          <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalStudents" data-toggle="tooltip" title="Click me for event details!">
                            <span>
                              <h4 style="color: #00A65A;">
                                <?php echo $studentNotice[0]['notice_title']; ?>
                              </h4>
                            </span>   
                          </button>
                        </h4>
                      </div>
                    </div>
                    <div class="row">  
                      <div class="col-md-12">
                        <span><?php echo $studentNotice[0]['notice_description']; ?></span>
                      </div>
                    </div>
                  </div>
                <?php } 
                  else {
                ?>  
                <div class="alert bg-success text-success">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                 </div>
                <?php } ?>
              </div>
              <!-- students tab close -->
              <!-- ***************** -->
              <!-- employees tab start -->
              <?php 
              $date = date('Y-m-d');
              $employeeNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Employees' AND is_status ='Active' AND CAST(created_at AS DATE) =  '$date'")->queryAll();
              ?>
              <div class="tab-pane" id="employees">
                <?php if(!empty($employeeNotice)) { ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-warning" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                      <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalEmployees" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #F39C12;">
                              <?php echo $employeeNotice[0]['notice_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $employeeNotice[0]['notice_description']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // end of if....
                  else {
                ?>
                <div class="alert bg-warning text-warning">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // end of else
                ?>
              </div>
              <!-- employees tab close -->
              <!-- ***************** -->
              <!-- parents tab start -->
              <!-- /.tab-pane -->
              <?php 
                $date = date('Y-m-d');
                $parentNotice = Yii::$app->db->createCommand("SELECT * FROM notice WHERE notice_user_type = 'Parents' AND is_status ='Active' AND CAST(created_at AS DATE) =  '$date'")->queryAll();
              ?> 
              <div class="tab-pane" id="parents">
              <?php if(!empty($employeeNotice)) { ?>  
                <div class="alert bg-info text-info">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-info" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                        <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalParents" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00C0EF;">
                              <?php echo $parentNotice[0]['notice_title']; ?>
                            </h4>
                          </span>   
                        </button>
                        </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $parentNotice[0]['notice_description']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                    }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-info text-info">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No notice for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else... 
                ?>
              </div> 
              <!-- parents tab close -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->

        <!-- Notice Panel Start -->
        <div class="col-md-5">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li>
                <a href="#upcoming" data-toggle="tab">
                  <i class="fa fa-recycle" style="color: #5AC594;"></i> 
                  Upcoming
                </a>
              </li>
              <li class="active">
                <a href="#today" data-toggle="tab">
                  <i class="fa fa-clock-o" style="color: #00C0EF;"></i> 
                  Today
                </a>
              </li>
              <li class="pull-left header"><i class="fa fa-calendar" style="color: #3C8DBC;"></i><span style="color: #3C8DBC;">Events</span></li>
            </ul>
            <!-- tab-content start -->
            <div class="tab-content">
              <!-- general tab start -->
              <?php 
                $date = date('Y-m-d');
                $todayEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) =  '$date'")->queryAll();
              ?> 
              <div class="tab-pane active" id="today">
              <?php if(!empty($todayEvent)) { ?> 
                <div class="alert bg-info text-info">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-info" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                      <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalTodays" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00C0EF;">
                              <?php echo $todayEvent[0]['event_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $todayEvent[0]['event_detail']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-info text-info">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No event for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else...
                ?>
              </div>
              <!-- general tab close -->
              <!-- ***************** -->
              <!-- student tab start -->
              <?php 
                $date = date('Y-m-d');
                $upcomingEvent = Yii::$app->db->createCommand("SELECT * FROM events WHERE is_status ='Active' AND CAST(event_start_datetime AS DATE) = '$date' OR CAST(event_end_datetime AS DATE) >= '$date'")->queryAll();
              ?> 
              <div class="tab-pane" id="upcoming">
              <?php if(!empty($upcomingEvent)) { ?> 
                <div class="alert bg-success text-success">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="label label-success" style="padding: 3px;">
                        <i class="fa fa-calendar"></i>
                        <?php echo date('D d-M-Y'); ?>
                      </span>
                    </div>
                    <div class="col-md-10">
                     <h4 style="margin: 0px 20px">
                        <button class="btn btn-xs btn-link" value="index.php?r=events/view-event-popup" id="modalUpcomings" data-toggle="tooltip" title="Click me for event details!">
                          <span>
                            <h4 style="color: #00A65A;">
                              <?php echo $upcomingEvent[0]['event_title']; ?>
                            </h4>
                          </span>   
                        </button>
                      </h4>
                    </div>
                  </div>
                  <div class="row">  
                    <div class="col-md-12">
                      <span><?php echo $upcomingEvent[0]['event_detail']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of if...
                  else {
                ?>
                <div class="alert bg-success text-success">
                  <div class="row">  
                    <div class="col-md-12">
                      <i class="fa fa-warning"></i> 
                      No event for today! 
                    </div>
                  </div>
                </div>
                <?php 
                  }
                  // ending of else...
                ?>
              </div>
              <!-- students tab close -->
            </div>
            <!-- tab-content close -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- Notice Panel CLose -->
      </div>
      <!-- Notice Row CLose -->

    </section>
    <!-- /.content -->
</div>
<!-- Students Notice Modal Start -->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-success" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-success"> <b>View Notice Details</b></h4>',
  "id"=>"modalStudent",
  "footer"=>"",// always need it for jquery plugin
]);

// modal content start.....
?>
<?php if(!empty($studentNotice)) { ?>
<div id='studentContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <thead>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $studentNotice[0]['notice_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $studentNotice[0]['notice_description']; ?></td>
          </tr>
          <tr>
            <td><b>Notice For</b></td>
            <td><?php echo $studentNotice[0]['notice_user_type']; ?></td>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
// modal content close.....
?>
<!-- Students Notice Modal Close -->
<!-- *************************** -->
<!-- Employee Notice Modal Start -->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-warning" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-warning"> <b>View Notice Details</b></h4>',
  "id"=>"modalEmployee",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($employeeNotice)) { ?>
<div id='employeeContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <thead>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $employeeNotice[0]['notice_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $employeeNotice[0]['notice_description']; ?></td>
          </tr>
          <tr>
            <td><b>Notice For</b></td>
            <td><?php echo $employeeNotice[0]['notice_user_type']; ?></td>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php 
}
Modal::end();
// modal content close.....
?>
<!-- Employees Notice Modal Close -->
<!-- **************************** -->
<!-- Parents Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-info" style="float:left;margin:12px 1px; color: #00C0EF;"></i><h4 style="float:left; color: #00C0EF;" class="text-info"> <b>View Notice Details</b></h4>',
  "id"=>"modalParent",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($parentNotice)) { ?>
<div id='parentContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $parentNotice[0]['notice_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $parentNotice[0]['notice_description']; ?></td>
          </tr>
          <tr>
            <td><b>Notice For</b></td>
            <td><?php echo $parentNotice[0]['notice_user_type']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Parents Notice Modal Close -->
<!-- **************************** -->
<!-- Todays Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-info" style="float:left;margin:12px 1px; color: #00C0EF;"></i><h4 style="float:left; color: #00C0EF;" class="text-info"> <b>View Notice Details</b></h4>',
  "id"=>"modalToday",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($todayEvent)) { ?>
<div id='todayContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $todayEvent[0]['event_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $todayEvent[0]['event_detail']; ?></td>
          </tr>
          <tr>
            <td><b>Start Date Time</b></td>
            <td><?php echo $todayEvent[0]['event_start_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>End Date Time</b></td>
            <td><?php echo $todayEvent[0]['event_end_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event Venue</b></td>
            <td><?php echo $upcomingEvent[0]['event_venue']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Todays Notice Modal Close -->
<!-- ************************* -->
<!-- Upcomings Notice Modal Start ---->
<?php Modal::begin([
  'header'=> '<i class="fa fa-eye text-success" style="float:left;margin:12px 1px;"></i><h4 style="float:left;" class="text-success"> <b>View Notice Details</b></h4>',
  "id"=>"modalUpcoming",
  "footer"=>"",// always need it for jquery plugin
]);
?>
<?php if(!empty($upcomingEvent)) { ?>
<div id='todayContent'>
  <div class='row'>
    <div class='col-md-12'>
      <table class='table table-responsive table-hover'>
        <tbody>
          <tr>
            <td><b>Title</b></td>
            <td><?php echo $upcomingEvent[0]['event_title']; ?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $upcomingEvent[0]['event_detail']; ?></td>
          </tr>
          <tr>
            <td><b>Event Start Datetime</b></td>
            <td><?php echo $upcomingEvent[0]['event_start_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event End Datetime</b></td>
            <td><?php echo $upcomingEvent[0]['event_end_datetime']; ?></td>
          </tr>
          <tr>
            <td><b>Event Venue</b></td>
            <td><?php echo $upcomingEvent[0]['event_venue']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}
Modal::end();
?>
<!-- Upcomings Notice Modal Close -->
<!-- Script for tooltip -->
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
</script>

<style type="text/css">
  #modalStudents{
    text-decoration: none;
  }
  #modalEmployees{
    text-decoration: none;
  }
  #modalParents{
    text-decoration: none;
  }
  #modalTodays{
    text-decoration: none;
  }
  #modalUpcomings{
    text-decoration: none;
  }
</style>

<script type="text/javascript">
  function clock() {
      const fullDate = new Date();
      let hours = fullDate.getHours();
      let mins = fullDate.getMinutes();
      let secs = fullDate.getSeconds();
      if (hours>12) {
        var am = "PM"
        hours=hours-12;
      }
      else{
        var am = "AM";
      }
      if (hours < 10) {
          hours = "0" + hours;
      }
      if (mins < 10) {
          mins = "0" + mins;
      }
      if (secs < 10) {
          secs = "0" + secs;
      }
      document.getElementById('hr').innerHTML = hours+':';
      document.getElementById('min').innerHTML = mins+':';
      document.getElementById('sec').innerHTML = secs+' '+am;
  }
  setInterval(clock, 1000)
</script>
      
<?php }?>
<?php 
  // executive portal start...
  if ($userType == 'Director' || $userType == 'Executive') { ?>
      <!-- /.box-header -->
<div class="box-body">
<?php  
    $branches = Yii::$app->db->createCommand("SELECT branch_id, branch_name, branch_code FROM branches WHERE status = 'Active'")->queryAll();
    $branchCount = count($branches);
    if ($branchCount > 1) {
        $branchName1 = $branches[0]['branch_name'];
        $branchCode1 = $branches[0]['branch_code'];
        $branchName2 = $branches[1]['branch_name'];
        $branchCode2 = $branches[1]['branch_code'];            
    }
    else{
        $branchName1 = $branches[0]['branch_name'];
        $branchCode1 = $branches[0]['branch_code'];
    }
    $month = date('Y-m');
    // Main Branch Queries...
    $income = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 5 AND account_nature = 'Income' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
    $totalIncomeMain = $income[0]['date'];
    // getting total expense of the current month...
    $expense = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 5 AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
    $totalExpenseMain = $expense[0]['date'];
    $remainingMain = $totalIncomeMain - $totalExpenseMain;
    //-----------------------------------------
    // Sub Branch Queries...
    $income = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 6 AND account_nature = 'Income' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
    $totalIncomeSub = $income[0]['date'];
    // getting total expense of the current month...
    $expense = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 6 AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
    $totalExpenseSub = $expense[0]['date'];
    $remainingSub = $totalIncomeSub - $totalExpenseSub;
    $incomeMain = Array();
    $expenseMain = Array();
    $incomeSub = Array();
    $expenseSub = Array();
    for ($i=1; $i <=12; $i++) { 
        $month = date('Y-').$i;
        if ($month == "2019-10") {
            $month = date('Y-').$i;
        }else if ($month == "2019-11") {
            $month = date('Y-').$i;
        }else if ($month == "2019-12") {
            $month = date('Y-').$i;
        }
        else{
            $month = date('Y-').'0'.$i;
        }
        $income = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 5 AND account_nature = 'Income' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
        $incomeMain[$i] = $income[0]['date'];
        $expense = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 5 AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
        $expenseMain[$i] = $expense[0]['date'];
        // income/expense sub branch...
        $incomee = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 6 AND account_nature = 'Income' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
        $incomeSub[$i] = $incomee[0]['date'];
        //var_dump($income);
        $expensee = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 6 AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
        $expenseSub[$i] = $expensee[0]['date'];
    }
    // income main branch....
    $incomeLength = count($incomeMain);
    for ($i=1; $i <=$incomeLength; $i++) { 
        if ($incomeMain[$i] == NULL) {
            $incomeMain[$i] = 0;
        }
    }
    $netIncome = implode(',', $incomeMain);
    // expense main branch...
    $expenseLength = count($expenseMain);
    for ($i=1; $i <=$expenseLength; $i++) { 
        if ($expenseMain[$i] == NULL) {
            $expenseMain[$i] = 0;
        }
    }
    $netExpense = implode(',', $expenseMain);
    // income sub branch...
    $incomeLengthSub = count($incomeSub);
    for ($j=1; $j <=$incomeLengthSub; $j++) { 
        if ($incomeSub[$j] == NULL) {
            $incomeSub[$j] = 0;
        }
    }
    $netIncomeSub = implode(',', $incomeSub);
    // expense sub branch...
    $expenseLengthSub = count($expenseSub);
    for ($k=1; $k <=$expenseLengthSub; $k++) { 
        if ($expenseSub[$k] == NULL) {
            $expenseSub[$k] = 0;
        }
    }
    $netExpenseSub = implode(',', $expenseSub);
    // expense sub branch...
?>  
  <!-- DONUT CHART -->
  <div class="col-md-6">
      <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title" style="color: #DD4B39;"><i class="fa fa-pie-chart" aria-hidden="true"></i>
                <?php echo $branchName1." - ".$branchCode1; ?> Income/Expense<small style="color: #DD4B39;"> Session 2019</small>
            </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" style="color: #04e27b;"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" style="color: #DD4B39;"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12 col-sm-12" id="container1"></div>
        </div>
        <!-- /.box-body -->
      </div>
  </div>
  <!-- /.box -->
  <!-- DONUT CHART -->
  <div class="col-md-6">
      <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title" style="color: #00C0EF;"><i class="fa fa-pie-chart" aria-hidden="true"></i>
               <?php echo $branchName2." - ".$branchCode2; ?> Income/Expense <small style="color: #00C0EF;"> Session 2019</small>
            </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" style="color: #04e27b;"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" style="color: #DD4B39;"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12 col-sm-12" id="container2"></div>
        </div>
        <!-- /.box-body -->
      </div>
  </div>
  <!-- /.box -->
  <!-- BAR CHART -->
  <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title" style="color: #04e27b;"><i class="fa fa-pie-chart" aria-hidden="true"></i>
                Overall Income/Expense <small style="color: #04e27b;"> Session 2019</small>
            </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" style="color: #04e27b;"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" style="color: #DD4B39;"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
            <div id="container3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
        <!-- /.box-body -->
      </div>
  </div>
  <!-- /.box -->
</div>
<!-- /.box-body -->
<?php $month = date('Y-m'); ?>
<script>
// Current Month Income/Expense of Main Branch start....
Highcharts.chart('container1', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Current Month (<?php echo date("F", strtotime("$month")); ?>)'
    },
    // subtitle: {
    //     text: 'anything'
    // },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} PKR</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Amount',
        data: [
            <?php if ($totalIncomeMain > $totalExpenseMain) { $status = "Profit"; } else { $status = "Loss"; }; ?>
            ['<b>Income</b>', <?php echo $totalIncomeMain; ?>],
            ['<b>Expence</b>', <?php echo $totalExpenseMain; ?>],
            ['<b><?php echo $status ?></b>', <?php echo (abs($remainingMain)); ?>],
        ]
    }]
});
// Current Month Income/Expense of Main Branch close....
// -----------------------------------------------------
// Current Month Income/Expense of Sub Branch start....
Highcharts.chart('container2', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Current Month (<?php echo date("F", strtotime("$month")); ?>)'
    },
    // subtitle: {
    //     text: 'anything'
    // },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} PKR</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Amount',
        data: [
            <?php if ($totalIncomeSub > $totalExpenseSub) { $status = "Profit:"; } else { $status = "Loss:"; }; ?>
            ['<b>Income:</b>', <?php echo $totalIncomeSub; ?>],
            ['<b>Expence:</b>', <?php echo $totalExpenseSub; ?>],
            ['<b><?php echo $status ?></b>', <?php echo (abs($remainingSub)); ?>],
        ]
    }]
});
// Current Month Income/Expense of Sub Branch close....
// ----------------------------------------------------
// Bar Chart start...
// ----------------------------------------------------
</script>
<script>
Highcharts.chart('container3', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Month Wise Income/Expense'
    },
    // subtitle: {
    //     text: 'Source: WorldClimate.com'
    // },
    xAxis: {
        categories: [
            '<b>January</b>',
            '<b>Febuary</b>',
            '<b>March</b>',
            '<b>April</b>',
            '<b>May</b>',
            '<b>June</b>',
            '<b>July</b>',
            '<b>August</b>',
            '<b>September</b>',
            '<b>October</b>',
            '<b>November</b>',
            '<b>December</b>'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: '<b>Amount</b>'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} PKR</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Income Main Branch',
        data: [<?php echo $netIncome; ?>]

    }, {
        name: 'Expense Main Branch',
        data: [<?php echo $netExpense; ?>]

    },{
        name: 'Income Sub Branch',
        data: [<?php echo $netIncomeSub; ?>]

    }, {
        name: 'Expense Sub Branch',
        data: [<?php echo $netExpenseSub; ?>]

    }, 
    ]
});
</script>
<?php 
  } 
  // executive portal close...
?>



