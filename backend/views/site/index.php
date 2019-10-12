<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
//$this->title = 'SMART EDUCATION';
 // $vvv = Yii::$app->user->identity->branch_id;
 // echo $vvv;
$currentDate = date('Y-m-d');
//echo $currentDate;
$WASH = 1;
  $countWash  = Yii::$app->db->createCommand("
  SELECT s.service_name,sid.discount_per_service
  FROM services as s
  INNER JOIN service_details as sd
  ON s.service_id = sd.service_id
  INNER JOIN sale_invoice_detail as sid
  ON sid.item_id = sd.service_detail_id
  INNER JOIN sale_invoice_head as sih
  ON sih.sale_inv_head_id = sid.sale_inv_head_id
  WHERE s.service_id = '$WASH'
  AND sid.item_type = 'Service'
  AND CAST(date as DATE) = '$currentDate'
  ")->queryAll();
  $countwash = count($countWash);
// // // Body wax count queries
// $serviceBodyWaxID  = Yii::$app->db->createCommand("
//             SELECT services_id
//             FROM services
//             WHERE name = 'Wax'
//             ")->queryAll();
// $bodyWaxId = $serviceBodyWaxID[0]['services_id'];



// $countbodyWax  = Yii::$app->db->createCommand("
//             SELECT COUNT(sid.item_id)
//             FROM sale_invoice_head as sih
//             INNER JOIN sale_invoice_detail as sid
//             ON sih.sale_inv_head_id = sid.sale_inv_head_id
//             WHERE CAST(date as DATE) = '$currentDate'
//             AND sid.item_type = 'Service'
//             AND sid.item_id = '$bodyWaxId'
//             ")->queryAll();
?>

<div class="site-index">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="./under-construction">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <p><i class="glyphicon glyphicon-user"></i> Today's Visitors</p><br>
                <b style="background-color:#FAB61C;color:white;padding:10px;border-radius: 20px;">25</b>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3">
          <a href="./under-construction">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <p><i class="glyphicon glyphicon-user"></i> Today's Expenses</p><br>
                <b style="background-color:#DD4B39;color:white;padding:10px;border-radius: 20px;">5000</b>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3">
          <a href="./under-construction">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <p><i class="glyphicon glyphicon-user"></i> Today's Income</p><br>
                <b style="background-color:#00C0EF;color:white;padding:10px;border-radius: 20px;">15000</b>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3">
          <a href="./under-construction">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <p><i class="fa fa-money"></i> Today's Profit</p><br>
                <b style="background-color:#00A65A;color:white;padding:10px;border-radius: 20px;">10000</b>
              </div>
            </div>
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <a href="./car-wash-details?serviceID=<?php //echo $washId; ?>">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <tr>
                        <th>WASH</th>
                        <td>
                          <b style="background-color:;color:black;padding:5px;border-radius: 20px;"><?php echo $countwash; ?></b>
                        </td>
                      </tr>
                      <tr>
                        <?php 
                          $washSum = 0; 
                          for ($m=0; $m <$countwash ; $m++) { 
                          $washSum += $countWash[$m]['discount_per_service'];
                          ?>
                        <?php } ?>
                        <th>Amount</th>
                        <td><?php echo $washSum; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3">
          <a href="./car-wash-details?serviceID=<?php //echo $bodyWaxId; ?>">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <p><i class="glyphicon glyphicon-"></i> Today's<br>Body Wax</p><br>
                <b style="background-color:#DD4B39;color:white;padding:10px;border-radius: 20px;"><?php //echo $countbodyWax[0]['COUNT(sid.item_id)']; ?></b>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3">
          <?php 
            $creditInvoicesDetails  = Yii::$app->db->createCommand("
            SELECT sih.remaining_amount
            FROM sale_invoice_head as sih
            WHERE sih.status != 'Paid'
            ")->queryAll();
            $count = count($creditInvoicesDetails);
            $creditSum = 0;
            foreach ($creditInvoicesDetails as $key => $value) {
              $creditSum += $value['remaining_amount'];
            }
          ?>
          <a href="./credit-sale-invoices">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <p>
                  <i class="glyphicon glyphicon-"></i> 
                Credit Invoices <br><?php echo "Rs.".$creditSum; ?>
                </p><br>
                <b style="background-color:#00C0EF;color:white;padding:10px;border-radius: 20px;"><?php echo $count; ?></b>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3">
          <!-- <a href="./customer">
            <div class="panel panel-default" style="box-shadow:0px 0px 15px 0px #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px">
                <p><i class="fa fa-money"></i> Today's Profit</p><br>
                <b style="background-color:#00A65A;color:white;padding:10px;border-radius: 20px;">10000</b>
              </div>
            </div>
          </a> -->
        </div>
      </div>
      <!-- Small boxes (Stat box) -->
      
      <!-- /.row -->

      <!-- Message of the day start -->
      <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box callout-warning" style="border-left:4px solid #FAB61C;border-right:4px solid #FAB61C;border-top-right-radius:20px;
          border-bottom-right-radius:20px;">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
              <h4 style="float: left;color:#FAB61C;">Message of the day!</h4>  
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
                      
                    </marquee>
                </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>
      <!-- Message of the day close -->

</section>
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
      if (hours < 12) {
          hours = "0" + hours;
      }
      if (mins < 12) {
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

