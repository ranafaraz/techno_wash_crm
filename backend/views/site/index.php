<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
//$this->title = 'SMART EDUCATION';
  $currentDate = date('Y-m-d');

  $countCustomer  = Yii::$app->db->createCommand("
  SELECT *
  FROM sale_invoice_head
  WHERE CAST(date as DATE) = '$currentDate'
  ")->queryAll();
  $countcustomer = count($countCustomer);

  $WASH = 1;
  $countWash  = Yii::$app->db->createCommand("
  SELECT s.service_name,sd.vehicle_type_id,sid.discount_per_service
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


  // counter for WAX
  $WAX = 2;
  $countWax  = Yii::$app->db->createCommand("
  SELECT s.service_name,sd.vehicle_type_id,sid.discount_per_service
  FROM services as s
  INNER JOIN service_details as sd
  ON s.service_id = sd.service_id
  INNER JOIN sale_invoice_detail as sid
  ON sid.item_id = sd.service_detail_id
  INNER JOIN sale_invoice_head as sih
  ON sih.sale_inv_head_id = sid.sale_inv_head_id
  WHERE s.service_id = '$WAX'
  AND sid.item_type = 'Service'
  AND CAST(date as DATE) = '$currentDate'
  ")->queryAll();
  $countwax = count($countWax);

  // counter for interior protection
  $interiorProtection = 3;
  $countInteriorProt  = Yii::$app->db->createCommand("
  SELECT s.service_name,sd.vehicle_type_id,sid.discount_per_service
  FROM services as s
  INNER JOIN service_details as sd
  ON s.service_id = sd.service_id
  INNER JOIN sale_invoice_detail as sid
  ON sid.item_id = sd.service_detail_id
  INNER JOIN sale_invoice_head as sih
  ON sih.sale_inv_head_id = sid.sale_inv_head_id
  WHERE s.service_id = '$interiorProtection'
  AND sid.item_type = 'Service'
  AND CAST(date as DATE) = '$currentDate'
  ")->queryAll();
  $countinteriorprot = count($countInteriorProt);

  // counter for engine dressing
  $engineDressing = 4;
  $countEngineDressing  = Yii::$app->db->createCommand("
  SELECT s.service_name,sd.vehicle_type_id,sid.discount_per_service
  FROM services as s
  INNER JOIN service_details as sd
  ON s.service_id = sd.service_id
  INNER JOIN sale_invoice_detail as sid
  ON sid.item_id = sd.service_detail_id
  INNER JOIN sale_invoice_head as sih
  ON sih.sale_inv_head_id = sid.sale_inv_head_id
  WHERE s.service_id = '$engineDressing'
  AND sid.item_type = 'Service'
  AND CAST(date as DATE) = '$currentDate'
  ")->queryAll();
  $countenginedressing = count($countEngineDressing);

  // counter for under carriage
  $underCarriage = 9;
  $countUnderCarriage  = Yii::$app->db->createCommand("
  SELECT s.service_name,sd.vehicle_type_id,sid.discount_per_service
  FROM services as s
  INNER JOIN service_details as sd
  ON s.service_id = sd.service_id
  INNER JOIN sale_invoice_detail as sid
  ON sid.item_id = sd.service_detail_id
  INNER JOIN sale_invoice_head as sih
  ON sih.sale_inv_head_id = sid.sale_inv_head_id
  WHERE s.service_id = '$underCarriage'
  AND sid.item_type = 'Service'
  AND CAST(date as DATE) = '$currentDate'
  ")->queryAll();
  $countundercarriage = count($countUnderCarriage);
?>

<div class="" style="margin-top:-35px;padding:-20px;">
  <!-- Main content -->
  <section class="content">
    <!-- Message of the day start -->
      <div class="row">
        <div class="col-md-6">
          <p style="font-size:25px;line-height:2 "><i class="glyphicon glyphicon-hand-right"></i> <span style="color:#FAB61C;">Admin</span> Dashboard</p>
        </div>
        <div class="col-md-6"> 
            <div class="info-box-content" style="color:#FAB61C;">
              <h4 style="float:right">
                <span style="color:#000000;" id="hr"></span>
                <span style="color:#000000;" id="min"></span>
                <span style="color:#000000;" id="sec"></span> -
                <?php echo date('l d-M-Y');?> 
              </h4>  
              <br><br>
            </div>
          <!-- /.info-box -->
        </div>
      </div>
    <!-- Message of the day close -->
    <div class="row">
        <div class="col-md-3" style="background-color:white;padding:10px;border-top:3px solid #FAB61C;">
          <p style="text-align: center;font-weight: bolder;color:#000000;">Today's</p>
        <a href="./car-wash-details?customer">
          <!--   <div class="panel panel-default" style="border:1px solid #FAB61C;"> -->
              <!-- <div class="panel-body" style="text-align: center;padding:30px" -->
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                        <th colspan="2" style="text-align: left;background-color:#FAB61C;color:white;"><span style="color:#000000;"></span>CUSTOMERS <b>(<?php echo $countcustomer ?>)</b></th>
                        </tr>
                      <!-- <tr>
                        <th>Count</th>
                        <td>
                          <b style="border-radius: 20px;"></b>
                        </td>
                      </tr> -->
                      </thead>
                    </table>
                  </div>
                </div>
              <!-- </div> -->
            <!-- </div> -->
          </a>
          <a href="./car-wash-details?polish">
            <!-- <div class="panel panel-default" style="border:1px solid #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px"> -->
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <?php
                            // total count of all types of polishes 
                            $polishCount = $countwax + $countinteriorprot + $countenginedressing + $countundercarriage;
                        ?>
                        <tr>
                        <th colspan="3" style="text-align: left;background-color:#FAB61C;color:white;"><span style="color:#000000;"></span>POLISHES <b>(<?php echo $polishCount;?>)</b></th>
                        </tr>
                      <!-- <tr>
                        <th>Count</th>
                        <td>
                          <b style="border-radius: 20px;">
                          hello
                          </b>
                        </td>
                      </tr> -->
                      <tr>
                        <?php 
                          $waxSum             = 0;
                          $intProtSum         = 0;
                          $engineDressingSum  = 0;
                          $underCarriageSum   = 0;

                          // loop for WAX total amount 
                          for ($w=0; $w <$countwax ; $w++) { 
                          $waxSum += $countWax[$w]['discount_per_service'];
                          }
                          // loop for interior protection total amount 
                          for ($p=0; $p <$countinteriorprot ; $p++) { 
                          $intProtSum += $countInteriorProt[$p]['discount_per_service'];
                          }
                          // loop for Engine Dressing total amount 
                          for ($e=0; $e <$countenginedressing ; $e++) { 
                          $engineDressingSum += $countEngineDressing[$e]['discount_per_service'];
                          }
                          // loop for under Carriage total amount 
                          for ($u=0; $u <$countundercarriage ; $u++) { 
                          $underCarriageSum += $countUnderCarriage[$u]['discount_per_service'];
                          }
                          // total sum of all types of polishes in a current date
                          $totalSUM = $waxSum + $intProtSum + $engineDressingSum + $underCarriageSum;
                        ?>
                        <th colspan="2" style="text-align:left;">Amount</th>
                        <td style="color:#FAB61C;font-family:arial;font-weight:bolder;text-align: center;"><?php 
                        //echo $totalSUM;
                        echo "Rs. ".number_format($totalSUM);
                         ?>
                           
                        </td>
                      </tr>
                      </thead>
                    </table>
                  </div>
                </div>
             <!--  </div>
            </div> -->
          </a>
          <a href="./car-wash-details?serviceID=<?php echo $WASH; ?>">
            <!-- <div class="panel panel-default" style="border:1px solid #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px"> -->
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                        <th colspan="3" style="text-align: left;background-color:#FAB61C;color:white;"><span style="color:#000000;"></span>WASH <b>(<?php echo $countwash; ?>)</b></th>
                        </tr>
                      <!-- <tr>
                        <th>Count</th>
                        <td>
                          <b style="border-radius: 20px;"></b>
                        </td>
                      </tr>
                      <tr> -->
                        <?php 
                          $washSum = 0; 
                          for ($m=0; $m <$countwash ; $m++) { 
                          $washSum += $countWash[$m]['discount_per_service'];
                          ?>
                        <?php } ?>
                        <th colspan="2" style="text-align:left;">Amount</th>
                        <td style="color:#FAB61C;font-family:arial;font-weight:bolder;text-align:center;"><?php echo "Rs. ".number_format($washSum); ?></td>
                      </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              <!-- </div>
            </div> -->
          </a>
          <a href="./credit-sale-invoices?creditInvoice">
            <!-- <div class="panel panel-default" style="border:1px solid #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px"> -->
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
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                        <th colspan="3" style="text-align: left;background-color:#FAB61C;color:white;"><span style="color:#000000;"></span>CREDIT INVOICES <b>(<?php echo $count; ?>)</b></th>
                        </tr>
                      <!-- <tr>
                        <th>Count</th>
                        <td>
                          <b style="border-radius: 20px;"></b>
                        </td>
                      </tr> -->
                      <tr>
                        <th colspan="2" style="text-align:left;">Amount</th>
                        <td style="color:#FAB61C;font-family:arial;font-weight:bolder;text-align: center;"><?php 
                        //echo $totalSUM;
                        echo "Rs. ".number_format($creditSum);
                         ?>
                           
                        </td>
                      </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              <!-- </div>
            </div> -->
          </a>
          <a href="./credit-sale-invoices?debitinvoice">
            <!-- <div class="panel panel-default" style="border:1px solid #FAB61C;">
              <div class="panel-body" style="text-align: center;padding:30px"> -->
                <?php 
                    $debitInvoicesDetails  = Yii::$app->db->createCommand("
                    SELECT pi.remaining_amount
                    FROM purchase_invoice as pi
                    WHERE pi.status != 'Paid'
                    ")->queryAll();
                    $countdebit = count($debitInvoicesDetails);
                    $debitSum = 0;
                    foreach ($debitInvoicesDetails as $key => $value) {
                      $debitSum += $value['remaining_amount'];
                    }
                ?>
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                        <th colspan="3" style="text-align: left;background-color:#FAB61C;color:white;"><span style="color:#000000;"></span>DEBIT INVOICES <b>(<?php echo $countdebit; ?>)</b></th>
                        </tr>
                      <!-- <tr>
                        <th>Count</th>
                        <td>
                          <b style="border-radius: 20px;"></b>
                        </td>
                      </tr> -->
                      <tr>
                        <th colspan="2" style="text-align:left;">Amount</th>
                        <td style="color:#FAB61C;font-family:arial;font-weight:bolder;text-align: center;"><?php 
                        //echo $totalSUM;
                        echo "Rs. ".number_format($debitSum);
                         ?>
                           
                        </td>
                      </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              <!-- </div>
            </div> -->
          </a>
      </div>
      <div class="col-md-9">
          <div class="row">
              <div class="col-md-3">
                <a href="./under-construction">
                <div class="panel panel-default" style="border:1px solid #FAB61C;">
                  <div class="panel-body" style="text-align: center;padding:30px">
                    <p><i class="glyphicon glyphicon-user"></i> Today Visitor</p><br>
                    <b style="background-color:#FAB61C;color:white;padding:10px;border-radius: 20px;">25</b>
                  </div>
                </div>
                </a>
              </div>
              <div class="col-md-3">
                <a href="./under-construction">
                    <div class="panel panel-default" style="border:1px solid #FAB61C;">
                      <div class="panel-body" style="text-align: center;padding:30px">
                        <p><i class="glyphicon glyphicon-user"></i> Today Expense</p><br>
                        <b style="background-color:#FAB61C;color:white;padding:10px;border-radius: 20px;">5000</b>
                      </div>
                    </div>
                </a>
              </div>
              <div class="col-md-3">
                <a href="./under-construction">
                    <div class="panel panel-default" style="border:1px solid #FAB61C;">
                      <div class="panel-body" style="text-align: center;padding:30px">
                        <p><i class="glyphicon glyphicon-user"></i> Today Income</p><br>
                        <b style="background-color:#FAB61C;color:white;padding:10px;border-radius: 20px;">15000</b>
                      </div>
                    </div>
                </a>
              </div>
              <div class="col-md-3">
                <a href="./under-construction">
                    <div class="panel panel-default" style="border:1px solid #FAB61C;">
                      <div class="panel-body" style="text-align: center;padding:30px">
                        <p><i class="fa fa-money"></i> Today Profit</p><br>
                        <b style="background-color:#FAB61C;color:white;padding:10px;border-radius: 20px;">10000</b>
                      </div>
                    </div>
                </a>
              </div>
          </div>
          <div class="row">
              <div class="col-md-3">
                <a href="./sale-invoice-view">
                    <div class="panel panel-default" style="border:1px solid #FAB61C;">
                      <div class="panel-body" style="text-align: center;padding:30px">
                        <i class="glyphicon glyphicon-usd"></i><br>
                        <p>Sale Invoice</p>
                      </div>
                    </div>
                </a>
              </div>
              <div class="col-md-3">
                <a href="./stock-type">
                    <div class="panel panel-default" style="border:1px solid #FAB61C;">
                      <div class="panel-body" style="text-align: center;padding:30px">
                        <i class="fa fa-bar-chart"></i><br>
                        <p>Stock Type</p>
                      </div>
                    </div>
                </a>
              </div>
          </div>
      </div>
    </div>
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

