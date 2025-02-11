<?php 
use common\models\Customer; 
use common\models\Branches;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Products;
use common\models\CustomerVehicles;
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
?>

 
  <?php


 // getting services
  $services = Yii::$app->db->createCommand("
    SELECT *
    FROM services
    ")->queryAll();
    $countServices = count($services);

    $id =  Yii::$app->user->identity->id;
    date_default_timezone_set("Asia/Karachi");
    $date = date('Y-m-d');

    $paidinvoiceData = Yii::$app->db->createCommand("
    SELECT sih.*
    FROM sale_invoice_head as sih 
    WHERE CAST(sih.date as DATE) = '$date'
    AND (sih.status = 'paid' OR sih.status = 'Paid')
    ORDER BY sih.sale_inv_head_id DESC
    ")->queryAll();

    $countpaidinvoiceData = count($paidinvoiceData);

    $creditinvoiceData = Yii::$app->db->createCommand("
    SELECT sih.*
    FROM sale_invoice_head as sih
    WHERE CAST(sih.date as DATE) = '$date'
    AND (sih.status = 'Partially' OR sih.status = 'Unpaid')
    ORDER BY sih.sale_inv_head_id DESC
    ")->queryAll();

    $countcreditinvoiceData = count($creditinvoiceData);

    //$branchId = $customerData[0]['branch_id'];

   // $branchData = Branches::find()->where(['branch_id' => $branchId])->one();
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
   <meta charset="utf-8">
  <style type="text/css" media="screen">
  	#remove_index,#types{
  		display: none;
  	}
  	#myTableData thead tr:hover{
  		background-color: #ECF0F5;
  		cursor: pointer;
  	}
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-md-3" style="margin-top:0px">
              <p style="color:#3C8DBC;font-size:1.3em;"><label style="color: #000000;">Sale Invoice&ensp;</label><b><i><?php //echo $customerData[0]['customer_name']; ?></i></b></p>
            </div>
            <div class="col-md-2" style="margin-top: 10px">
              <label style="margin-left: 50px">Date:</label>
            </div>  
            <div class="col-md-4" style="margin-top: 10px">
              <?php $date = date("m/d/Y"); ?>
              <input type="date" name="invoice_date"  class="form-control" id="invoice_date" value="<?php echo date('Y-m-d'); ?>" style="margin-top: -6px;">      
            </div>
            <div class="col-md-3" style="margin-top: 4px;">
              <?= Html::a('Add Customer', ['./customer-create'],
                    ['role'=>'', 'target'=>'_blank','title'=> 'Create new Customers','class'=>'btn btn-success']); ?>
            </div> 
          </div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#invoice" data-toggle="tab">New Invoice</a>
              </li>
               <li><a href="#paidd" data-toggle="tab">Paid Invoices <span class="badge"><?=$countpaidinvoiceData?></span></a></li>
               <li><a href="#credit" data-toggle="tab">Credit <span class="badge"><?=$countcreditinvoiceData?></span></a></li>
            </ul>
            <div class="tab-content" style="background-color: #efefef;">
              <div class="tab-pane" id="credit" style="background-color:lightgray;padding:10px;">
                <div class="row">
                  <div class="col-md-8">
                    <h3 class="text-info" style="vertical-align: middle;">Credit Invoices</h3>
                  </div>
                  <?php
                    $totalcreditAmount=0;
                    for ($i=0; $i <$countcreditinvoiceData ; $i++) {
                      $totalcreditAmount += $creditinvoiceData[$i]['remaining_amount'];
                    }        
                  ?>
                  <div class="col-md-4">
                    <h3 style="vertical-align: middle; margin-bottom: 20px !important;background-color:#FAB61C;color:#3F0D12;padding: 6px;border-radius: 3px;text-align: center;">Total Credit: <?= $totalcreditAmount;?></h3>
                  </div>
                </div>    
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">                      
                      <table class="table table-bordered">
                        <thead style="background-color: #367FA9;color:white;">
                          <tr>
                            <!-- <th class="t-cen" style="vertical-align:middle;">Sr #</th> -->
                            <!-- <th class="t-cen" style="vertical-align:middle;width: 100px;">Invoice #</th> -->
                             <th style="vertical-align:middle;text-align: center;">Sr.#</th>
                             <th style="vertical-align:middle;text-align: center;">Inv #</th>
                            <th style="vertical-align:middle;text-align: center;">Customer</th>
                            <th style="vertical-align:middle;text-align: center;">Vehicle</th>
                            <th style="vertical-align:middle;text-align: center;">Total<br>Amount</th>
                            <th style="vertical-align:middle;text-align: center;">Paid<br>Amount</th>
                            <th style="vertical-align:middle;text-align: center;">Remaining<br>Amount</th>
                            <th style="vertical-align:middle;text-align: center;">Status</th>
                            <th style="vertical-align:middle;text-align: center;">Action</th>
                          </tr>
                        </thead>
                        <tbody style="background-color:#b0e0e6;font-family:arial;font-weight:bolder;">
                          <?php for ($i=0; $i <$countcreditinvoiceData ; $i++) {  
                            $custId = $creditinvoiceData[$i]['customer_id'];
                            $customerName = Yii::$app->db->createCommand("
                            SELECT customer_name
                            FROM customer 
                            WHERE customer_id = '$custId' 
                            ")->queryAll();

                            $sale_inv_head_id = $creditinvoiceData[$i]['sale_inv_head_id'];

                            $creditinv = Yii::$app->db->createCommand("
                                SELECT cv.registration_no, vst.name
                                FROM  sale_invoice_detail as sid 
                                INNER JOIN customer_vehicles as cv 
                                ON cv.customer_vehicle_id = sid.customer_vehicle_id 
                                INNER JOIN vehicle_type_sub_category as vst 
                                ON cv.vehicle_typ_sub_id  = vst.vehicle_typ_sub_id 
                                WHERE sid.sale_inv_head_id = '$sale_inv_head_id'
                                ")->queryAll();

                            ?>
                            <tr>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $i+1; ?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $creditinvoiceData[$i]['sale_inv_head_id']; ?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $customerName[0]['customer_name'];?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php //echo $creditinv[0]['name']." - ".$creditinv[0]['registration_no'];?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $creditinvoiceData[$i]['total_amount']; ?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $creditinvoiceData[$i]['paid_amount']; ?></td>
                               <td style="vertical-align:middle;text-align: center;"><?php echo $creditinvoiceData[$i]['remaining_amount']; ?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $creditinvoiceData[$i]['status']; ?></td>
                              <td class="text-center" style="vertical-align:middle;text-align: center;">
                                <?php  
                                  if(Yii::$app->user->identity->user_type == 'Admin'){ ?>
                                    <a href="./paid-sale-invoice?sihID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>" title="View" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> Bill</a>
                                    <a href="./update-sale-invoice?saleinvheadID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>&customerid=<?php echo $creditinvoiceData[$i]['customer_id'];?>" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Update</a>
                                    <a href="./collect-sale-invoice?saleinvheadID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>&customerID=<?php echo $creditinvoiceData[$i]['customer_id'];?>" title="Collect" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Collect</a>
                                <?php } else { ?>
                                    <a href="./paid-sale-invoice?sihID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>" title="View" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> Bill</a>
                                    <a href="./collect-sale-invoice?saleinvheadID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>&customerID=<?php echo $creditinvoiceData[$i]['customer_id'];?>" title="Collect" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Collect</a>
                                <?php } ?>
                                </td>
                            </tr>   
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="paidd" style="background-color:lightgray;padding:10px;">
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="text-info" style="text-align: center;">
                      Paid Invoices
                    </h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">                      
                      <table class="table table-bordered">
                        <thead style="background-color: #367FA9;color:white;">
                          <tr>
                            <th class="text-center" style="vertical-align:middle;">Sr #</th>
                            <!-- <th class="t-cen" style="vertical-align:middle; width: 100px;">Invoice #</th> -->
                            <th class="text-center" style="vertical-align:middle;">Inv #</th>
                            <th class="text-center" style="vertical-align:middle;">Customer</th>
                            <th class="text-center" style="vertical-align:middle;">Vehicle</th>
                            <th class="text-center" style="vertical-align:middle;">Amount</th>
                            <th class="text-center" style="vertical-align:middle;">Action</th>
                          </tr>
                        </thead>
                        <tbody style="background-color:#b0e0e6;font-family:arial;font-weight:bolder;">
                          <?php for ($i=0; $i <$countpaidinvoiceData ; $i++) { 

                            $custId = $paidinvoiceData[$i]['customer_id'];
                            $customerName = Yii::$app->db->createCommand("
                            SELECT customer_name
                            FROM customer 
                            WHERE customer_id = '$custId'
                            ")->queryAll();

                            $sale_inv_head_id = $paidinvoiceData[$i]['sale_inv_head_id'];
                            $paidinv = Yii::$app->db->createCommand("
                                SELECT cv.registration_no, vst.name
                                FROM  sale_invoice_detail as sid 
                                INNER JOIN customer_vehicles as cv 
                                ON cv.customer_vehicle_id = sid.customer_vehicle_id 
                                INNER JOIN vehicle_type_sub_category as vst 
                                ON cv.vehicle_typ_sub_id  = vst.vehicle_typ_sub_id  
                                WHERE sid.sale_inv_head_id = '$sale_inv_head_id'
                                ")->queryAll();
                            ?>   
                            <tr>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $i+1; ?></td>
                              <!-- <td style="vertical-align:middle;"><?php echo $paidinvoiceData[$i]['sale_inv_head_id']; ?></td> -->
                              <td style="vertical-align:middle;text-align: center;"><?php echo $paidinvoiceData[$i]['sale_inv_head_id']; ?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $customerName[0]['customer_name']; ?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $paidinv[0]['name']." - ".$paidinv[0]['registration_no'];?></td>
                              <td style="vertical-align:middle;text-align: center;"><?php echo $paidinvoiceData[$i]['paid_amount']; ?></td>
                              <td class="text-center" style="vertical-align:middle;text-align: center;">
                                <?php  
                                  if(Yii::$app->user->identity->user_type == 'Admin'){ ?>
                                    <a href="paid-sale-invoice?sihID=<?=$paidinvoiceData[$i]['sale_inv_head_id']?>" title="View" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Bill</a>
                                    <a href="update-sale-invoice?saleinvheadID=<?=$paidinvoiceData[$i]['sale_inv_head_id'];?>&customerid=<?=$paidinvoiceData[$i]['customer_id'];?>" title="Edit" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Update</a>
                                <?php } else { ?>
                                    <a href="paid-sale-invoice?sihID=<?=$paidinvoiceData[$i]['sale_inv_head_id']?>" title="View" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Bill</a>
                                <?php } ?>
                                <!--  <a href="sale-invoice-transaction?saleinvheadID=<?php //echo $paidinvoiceData[$i]['sale_inv_head_id'];?>&customerid=<?php //echo $paidinvoiceData[$i]['customer_id'];?>" title="Transaction" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-transfer"></i> Transactions</a> -->
                              </td>
                            </tr>  
                            <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="active tab-pane" id="invoice"  style="background-color:lightgray;padding:10px;">
                <div class="form-group">
                  <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="container-fluid" style="margin-bottom:8px;">
                     <?php echo Dialog::widget([
                         'libName' => 'krajeeDialog',
                         'options' => [], // default options
                      ]); ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Customer Name</label>
                            <?php 
                              echo Select2::widget([
                              'name' => '',
                              'value' => '',
                              'data' => ArrayHelper::map(Customer::find()->where(['is_deleted' => 0])->all(),'customer_id','customer_name'),
                              'options' => ['placeholder' => 'Select Name','id' =>'customer_name']
                              ]);
                            ?>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Customer Contact</label>
                            <?php 
                              echo Select2::widget([
                              'name' => '',
                              'value' => '',
                              'data' => ArrayHelper::map(Customer::find()->where(['is_deleted' => 0])->all(),'customer_id','customer_contact_no'),
                              'options' => ['placeholder' => 'Select Contact','id' =>'customer_contact']
                              ]);
                            ?>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Select Vehicle</label>
                            <?php 
                              echo Select2::widget([
                              'name' => '',
                              'value' => '',
                              'data' => ArrayHelper::map(CustomerVehicles::find()
                                          ->innerJoinWith('customer')->where(['is_deleted' => 0])
                                          ->innerJoinWith('vehicleTypSub')->all(),'customer_vehicle_id','registration_no'),
                              'options' => ['placeholder' => 'Select Vehicle','id' => 'vehicle']
                              ]);
                            ?>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Vehicle Model</label>
                            <input type="text" class="form-control" id="vehicle_model_name" readonly="">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group" id="types">
                            <label>Select Type</label>
                            <select id="item_type" class="form-control" autofocus="">
                              <option value="">Select Type</option>
                              <option value="Service">Service</option>
                              <option value="Stock">Stock</option>
                            </select>
                            <input type="hidden" id="remove_amount">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div id="servic" style="display: none;">
                            <div class="form-group">
                              <label>Select Service</label>
                              <select name="services" class="form-control" id="services">
                                <option value="">Select Services</option>
                                <?php 
                                $allservices = Yii::$app->db->createCommand("
                                SELECT *
                                FROM services
                                ")->queryAll();
                                $countAll = count($allservices);
                                  for ($s=0; $s <$countAll ; $s++) { 
                                
                                ?>
                                <option value="<?php echo $allservices[$s]['service_id']; ?>"><?php echo $allservices[$s]['service_name']; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <input type="hidden" name="amount" class="form-control" value="0" id="price" readonly="" >
                            </div>
                          </div>
                          <div id="stock" style="display: none;">
                            <div class="form-group">
                              <label>Barcode </label>
                              <input type="text" id="barcode" class="form-control">
                            </div>
                            <div class="form-group">
                              <input type="hidden" class="form-control" id="selling_price" readonly="" >
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div id="pname" style="display: none;">
                            <div class="form-group">
                              <label>Product Name </label>
                              <?php 
                                echo Select2::widget([
                                'name' => 'product_name',
                                'value' => '',
                                'data' => ArrayHelper::map(Products::find()->all(),'product_id','product_name'),
                                'options' => ['placeholder' => 'Select Product','id' => 'productid']
                              ]);
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div id="quantity" style="display: none;">
                            <div class="form-group">
                              <label>Quantity</label>
                              <input type="text" id="product_quantity" class="form-control">
                              <input type="hidden" id="hide_quantity" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div id="availbleStock" style="display: none;">
                            <div class="form-group">
                              <label>Available Stock</label>
                              <input type="text" id="availble_stock" class="form-control" readonly="">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3" id="alertDiv">
                          <p id="message" style="display:none;">
                            
                          </p>
                        </div>
                      </div>
                      <div class="row" style="margin-top: 25px" id="remove_index">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                          <input type="hidden" id="remove_value">
                          <input type="text" placeholder="" class="form-control" id="removed_value" readonly="" style="display:none;">
                        </div>
                        <div class="col-md-4" style="display: none" id="check_quantity">
                          <input type="text" id="check_no" class="form-control" placeholder="Quantity To Remove" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
                          <input type="hidden" id="check_no_quantity" >
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-warning btn-flat" id="remove" style="display:none;"><i class="fa fa-times"></i> Remove</button>
                        </div>
                      </div><br>
                      <div class="row" id="mydata" style="display: none;">
                        <div class="col-md-12">
                          <table class="table table-bordered" id="myTableData">
                            <thead>
                              <th style="background-color: skyblue">Sr # </th>
                              <th style="background-color: skyblue">Vehicle </th>
                              <th style="background-color: skyblue">Item</th>
                              <th style="background-color: skyblue">Type</th>
                              <th style="background-color: skyblue">Quantity</th>
                              <th style="background-color: skyblue">Amount</th>
                              <!-- <th style="background-color: skyblue">Action</th> -->
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <input type="hidden" id="service_name">
                      <input type="hidden" id="stock_name">
                      <input type="hidden" id="vehicle_name">
                      <input type="hidden" id="serviceDetailId">
                      <input type="hidden" id="productSellingPrice">
                      <input type="hidden" id="productName">
                      <input type="hidden" id="saleInvId">
                    </div>
                  </div>
                </div> 			
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      </div>
    </div>
    <div class="col-md-3" id="bill_form" style="display: none;">
      <div class="box box-primary">
        <div class="box-body">
        	<div class="container-fluid" style="margin-bottom:8px;">
            <div class="row">
              <div class="col-md-12" style="padding:8px;text-align: center;font-weight: bolder;font-size:20px;background-color: #3C8DBC;color:white;">
                Bill
              </div>
            </div>
          </div>
          <div class="row" >
            <div class="col-md-12">
              <div class="form-group">
                <label>Total Amount</label>
                <input type="text" name="total_amount" class="form-control" readonly="" id="tp" value="0">
              </div>
              <div class="form-group">
  					     <label>Discount</label>
  					       <input type="radio" name="discountType" id="amount" checked onclick="abc()"> Amount
                  <input type="radio" name="discountType" id="percentage" onclick="abc()"> Percent
  					      <input type="text" name="discount" class="form-control" id="disc" value="0" oninput="discountFun()" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
  					     <input type="hidden" id="name" >
				      </div>
              <div class="form-group">
                <label>Net Total</label>
                <input type="text" name="net_total" class="form-control" id="nt"readonly="">
              </div>
              <div class="form-group">
                <label>Paid</label>
                <input type="text" name="paid" class="form-control"  id="paid" value="0" oninput="cal_remaining()" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
              </div>
              <div class="form-group">
                <label>Remaining</label>
                <input type="text" name="remain" class="form-control" readonly="" id="remaining">
              </div>
              <div class="form-group">
                <label>Cash Return</label>
                <input type="text" name="return" class="form-control" readonly="" id="cash_return"> 
              </div>
              <div class="form-group">
                <label>Status</label>
                <input type="text" name="status" class="form-control" readonly="" id="status" value="Unpaid">
              </div>
              <div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;" id="alert">
              </div>
              <hr>
              <button class="btn btn-success btn-block btn-flat" id="insert" >
              	<i class="glyphicon glyphicon-plus" ></i> Add Bill</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>
	
	let vehicleArray 				= new Array();
	let serviceArray 				= new Array();
	let amountArray 				= new Array();
	let ItemTypeArray       = new Array();
  let quantityArray       = new Array();
  let tempProductArray    = new Array();
  let tempquantityArray   = new Array();
	let user_id = <?php echo $id; ?>;
  let branch_id = <?php echo Yii::$app->user->identity->branch_id; ?>;
	let rIndex;
	let table;
	let index = 1;
	//var invoice_id 					= <?php //echo $saleInvoiceID; ?>;

  function abc(){
    $('#disc').val("");
    $('#disc').focus();
    var total = $('#tp').val();
    $('#nt').val(total);
    $('#remaining').val(total);
    $('#paid').val(""); 
  }
  
  function discountFun(){
    // Getting the value from the original price
    originalPrice = parseInt(document.getElementById("tp").value);

    disco = document.getElementById("disc").value;
    if (disco =="" || disco == null) {
      $('#nt').val(originalPrice);
      $('#remaining').val(originalPrice);
      $('#paid').val("0");
      $('#cash_return').val("0"); 
    }else{      
      if(document.getElementById('percentage').checked){
          	
        discount = parseInt(document.getElementById("disc").value);
        
        discountReceived = parseInt((originalPrice*discount)/100);
        
        purchasePrice = originalPrice-discountReceived;
        $('#nt').val(purchasePrice);
        if($('#paid').val()!="" || $('#paid').val()!=null){
          remaining = purchasePrice-$('#paid').val();
          $('#remaining').val(remaining);
        }       
      } else if(document.getElementById('amount').checked) {
          discount = parseInt(document.getElementById("disc").value);
          purchasePrice = originalPrice - discount;
          //alert(purchasePrice);
          //discountReceived = discount;
          $('#nt').val(purchasePrice);
             
          if($('#paid').val()!="" || $('#paid').val()!=null){
            remaining = purchasePrice-$('#paid').val();
            $('#remaining').val(remaining);
          }
      }
        //$('#insert').show(); 
        //$("#insert").removeAttr("disabled");
        if (purchasePrice < 0) {
          //$('#insert').hide();
          $("#insert").attr("disabled", true);
          $('#alert').css("display","block");
          $('#alert').html("&ensp;Discount Cannot Be Greater Than Total Amount");
        }else{
          $('#alert').css("display","none");
          $("#insert").removeAttr("disabled");
        }
        $('#paid').val("0"); 
        $('#remaining').val(purchasePrice);
    }
  }

      function deleteRow(tableID) 
      {
            try {
            var table = document.getElementById('myTableData');
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox&& true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }
            }catch(e) {
                alert(e);
            }
        }
      function cal_remaining(){
      	var paid = $('#paid').val();
      	var nt = $('#nt').val();
      	var remaining = nt - paid;
      	 
      	if (remaining == 0) {
      		$('#status').val('Paid');
      	}

      	 if (remaining == nt && paid == 0) {
      		$('#status').val('Unpaid');
      	}        
         if (paid > 0 && remaining > 0) {
          $('#status').val('Partially');
        }
        
      	//$('#insert').show();
        //$("#insert").removeAttr("disabled");
        if (remaining < 0) {
          //$('#insert').hide();
          $("#cash_return").attr("readonly", false);
         // $("#cash_return").removeAttr("readonly");
          // $('#alert').css("display","block");
          // $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
          var cash_return = paid - nt;
           $('#cash_return').val(cash_return);
           $('#remaining').val(0);
           $('#status').val('Paid');
        }else{
          $('#remaining').val(remaining);
          $('#cash_return').val(0);
          // $('#alert').css("display","none");
          // $("#insert").removeAttr("disabled");
        }

        // if(remaining < 0){
        //   $("#insert").attr("disabled", true);
        //   $('#alert').css("display","block");
        //   $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
        // }

      }

      function bill(){
        var saleId = $('#saleInvId').val();
        
        window.location = './paid-sale-invoice?sihID='+saleId;
      }
//       function remove(index){
//        var a=index.parentNode.parentNode.rowIndex;
// alert(a);
//        //document.getElementById("myTableData").deleteRow(a);
       
//       }
</script>
<?php
$url = \yii\helpers\Url::to("customer/fetch-info");

$script = <<< JS

$(document).ready(function(){
  $('#types').show();
  var vehicle = $("#vehicle").val();
  $.ajax({
    type:'post',
    data:{vehicle:vehicle},
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
      $('#vehicle_name').val(jsonResult[0]['registration_no']);
    }      
  });
});

$("#customer_name").change(function(){
  var customer_id = $('#customer_name').val();
  
  $.ajax({
    type:'post',
    data:{customer_id:customer_id},
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));

      $('#customer_contact').empty();
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['customer_id']+'">'+jsonResult[i]['customer_contact_no']+'</option>';
      }
      // Append to the html
      $('#customer_contact').append(options);

      $('#vehicle').empty();
      $('#vehicle').append("<option>"+""+"</option>");
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['customer_vehicle_id']+'">'+jsonResult[i]['registration_no']+'</option>';
      }
      // Append to the html
      $('#vehicle').append(options);

    }      
  });
});

$("#customer_contact").change(function(){
  var customer_id = $('#customer_contact').val();
  
  $.ajax({
    type:'post',
    data:{customer_id:customer_id},
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));

      $('#customer_name').empty();
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['customer_id']+'">'+jsonResult[i]['customer_name']+'</option>';
      }
      // Append to the html
      $('#customer_name').append(options);

      $('#vehicle').empty();
      $('#vehicle').append("<option>"+""+"</option>");
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['customer_vehicle_id']+'">'+jsonResult[i]['registration_no']+'</option>';
      }
      // Append to the html
      $('#vehicle').append(options);

    }      
  });
});

$("#cash_return").on('input', function(){
  var cashReturn  = $('#cash_return').val();
  var paid        = $('#paid').val();
  var nt          = $('#nt').val();
  var previous_value = paid-nt;
  var temp = cashReturn-previous_value;
  $('#remaining').val(temp);

  if(cashReturn == previous_value){
    $('#status').val('Paid');
    $("#insert").attr("disabled", false);
    $('#alert').css("display","none"); 
  }
  if(temp > 0){
    $('#status').val('Partially Paid');
    $("#insert").attr("disabled", false);
    $('#alert').css("display","none"); 
  }

  if(temp < 0){
    $("#insert").attr("disabled", true);
    $('#alert').css("display","block");
    $('#status').val('');
    $('#alert').html("&ensp;Invalid Amount");
  }
});

$("#vehicle").on('focus', function(){
  $('#item_type').val("");
  $('#servic').hide();
  $('#stock').hide();
  $('#pname').hide();
  $('#quantity').hide();
});

$("#paid").on('focus', function(){
  $('#paid').val("");
  $('#cash_return').val(0);
  var paid = $('#paid').val();
  // if(paid == "" || paid == null)
  //     {
  //     $("#insert").attr("disabled", true);
  //     $('#alert').css("display","block");
  //     $('#alert').html("&ensp;Paid Amount Cannot Be Empty");
  //   }
});

$("#cash_return").on('focus', function(){
  $('#cash_return').val("");
});

$("#item_type").change(function(){
  $('#servic').val("SelectServices");
  $('#selling_price').val("");
  $('#price').val("");
	var item_type = $('#item_type').val();
	if(item_type == "Service"){
	 	$('#servic').show();
    $('#services').focus();
	 	$('#stock').hide();
    $('#pname').hide();
    $('#quantity').hide();
    $('#availbleStock').hide();
    $('#message').hide();
	} else if(item_type == "Stock") {
	 	$('#stock').show();
    $('#pname').show();
    $('#barcode').focus();
    $('#barcode').val("");
    $('#servic').hide();
    $('#productid').val('').trigger("change");
	} else{
	 	$('#stock').hide();
	 	$('#servic').hide();
    $('#pname').hide();
	}
});

$("#pname").focusin(function(){
  $('#quantity').show();
  $('#availbleStock').show();
  $('#availbleStock').val("");
  $('#barcode').val("");
});

$("#barcode").focusin(function(){
  $('#quantity').hide();
  $('#availbleStock').hide();
  $('#availble_stock').val("");
  $('#message').hide();
  $('#productid').val('').trigger("change");  
});

$("#services").on('click',function(){
	var serviceID = $("#services").val();
  $('#product_quantity').val("");
  var customerVehicle = $("#vehicle").val();
	
	$.ajax({
    type:'post',
    data:{
        serviceID:serviceID,
        customerVehicle:customerVehicle
    },
    url: "$url",
    success: function(result){
        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
          console.log(jsonResult);
        	
          $('#price').val(jsonResult[0]['price']);
          $('#serviceDetailId').val(jsonResult[0]['service_detail_id']);
          $('#service_name').val(jsonResult[0]['service_name']);

          var totalAmount = parseInt($('#tp').val());
			    var tprice = jsonResult[0]['price'];
			    var tp = parseInt(totalAmount)+parseInt(tprice);
          $('#tp').val(tp);
          $('#disc').val("");
          discountFun();

			    var vehicle 						= $('#vehicle').val();
					var services 						= $('#serviceDetailId').val();
					var price 							= $('#price').val();
					var servicesName				= $('#service_name').val();
					var reg_name 						= $('#vehicle_name').val();
          var reg_model_name      = $('#vehicle_model_name').val();
					var type                = $('#item_type').val();
          var quantity            = 1;
					
					if (vehicle=="" || vehicle==null) {
						alert("Select the Vehicle name ");
					} else if (services =="" || services==null) {
								//alert("Select the Services ");
					} else {
						vehicleArray.push(vehicle);
						serviceArray.push(services);
						amountArray.push(price);
						ItemTypeArray.push(type);
            quantityArray.push(quantity);

						$("#mydata").show();
						$('#bill_form').show();
						$('#insertdata').attr("disabled", false);
						let table = document.getElementById("myTableData");

						//count the table row
						let rowCount = table.rows.length;
						
						//insert the new row
						let row = table.insertRow(1);
						
						//insert the coulmn against the row
						row.insertCell(0).innerHTML=rowCount;
            row.insertCell(1).innerHTML=reg_model_name+' - '+reg_name;
						row.insertCell(2).innerHTML= servicesName;
						row.insertCell(3).innerHTML= type;
            row.insertCell(4).innerHTML= quantity;
						row.insertCell(5).innerHTML= price;
            //row.insertCell(6).innerHTML= "<button class='btn btn-danger' onclick='remove(this)'>Remove</button>";
						
            $('#services').val("");
						$('#remove_index').show();
						for(var i = 1; i < table.rows.length; i++){
              table.rows[i].onclick = function() {
                $('#removed_value').show();
                $('#remove').show();
                // get the seected row index
                rIndex = this.rowIndex;
                document.getElementById("remove_value").value = rIndex;
                document.getElementById("removed_value").value = this.cells[2].innerHTML;
                document.getElementById("check_no").value = this.cells[4].innerHTML;
                document.getElementById("check_no_quantity").value = this.cells[4].innerHTML;
                document.getElementById("remove_amount").value = this.cells[5].innerHTML;
                $('#check_no').val("");
                var q = this.cells[4].innerHTML;

                $("#hide_quantity").val(q); 
                if(q>1){
                  $('#check_quantity').show();
                  $('#check_no').focus();
                } else{
                    $('#check_quantity').hide();
                }        
              };
            }
          }
  	}   
	}); 
});

// for vehicel name
$("#vehicle").on("change",function(){
	var vehicle = $("#vehicle").val();
  if(vehicle == null || vehicle ==""){  
    $('#types').hide();
    $('#servic').hide();
    $('#stock').hide();
    $('#pname').hide();
    $('#quantity').hide();
  } else{
    $('#types').val("");
    $('#types').show();
  }
	
	$.ajax({
    type:'post',
    data:{vehicle:vehicle},
    url: "$url",
    success: function(result){
    	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
    	$('#vehicle_name').val(jsonResult[0]['registration_no']);
      $('#vehicle_model_name').val(jsonResult[0]['name']);
  	}      
  }); 

  $.ajax({
    type:'post',
    data:{vehicle_id:vehicle},
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
      console.log(jsonResult);
      var vdetail = jsonResult[0]['vehicle_typ_sub_id'];
      var carmanu = jsonResult[0]['car_manufacture_id'];
      var vehtyp = jsonResult[0]['vehical_type_id'];
      var custVehid = jsonResult[0]['customer_vehicle_id'];
      $("#message").show();
      //
      
      $("#message").html("<a href='./update-vehicle-type?vdetail="+vdetail+"&carmanu="+carmanu+"&vehtyp="+vehtyp+"&custVehid="+custVehid+"' style='color:white;'>Car Data Incorrect,Please Click on Update</a>");
      $("#message").css(
        {
            //"color":"#008D4C",
            "border":"1px solid",
            "background-color":"#008D4C",
          }
      );
      
      //$('#vehicle_name').val(jsonResult[0]['registration_no']);
    }      
  }); 
   $.ajax({
    type:'post',
    data:{vehID:vehicle},
    url: "$url",
    success: function(result){
      var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
      console.log(jsonResult);

      $('#customer_contact').empty();
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['customer_id']+'">'+jsonResult[i]['customer_contact_no']+'</option>';
      }
      // Append to the html
      $('#customer_contact').append(options);

      $('#customer_name').empty();
      var options = '';
      for(var i=0; i<jsonResult.length; i++) { 
        options += '<option value="'+jsonResult[i]['customer_id']+'">'+jsonResult[i]['customer_name']+'</option>';
      }
      // Append to the html
      $('#customer_name').append(options);
    }      
  }); 
});
  
$("#barcode").on('change',function(){
	var barcode = $("#barcode").val();
  if(barcode=="" || barcode==null){

  } else{
		$.ajax({
        type:'post',
        data:{barcode:barcode},
        url: "$url",
	      success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
        	  $('#selling_price').val(jsonResult[0]['selling_price']);
	        	$('#stock_name').val(jsonResult[0]['product_name']);
                     
	        	var totalAmount = parseInt($('#tp').val());
				    var tprice = jsonResult[0]['selling_price'];
				    var tp = parseInt(totalAmount)+parseInt(tprice);
            $('#tp').val(tp);
            //$('#nt').val(tp);
				    //$('#remaining').val(tp);
            //$('#status').val('Unpaid');
            $('#disc').val("");
            discountFun();

				    var vehicle 						= $('#vehicle').val();
						var barcode             = jsonResult[0]['stock_id'];
						var stock_price 				= $('#selling_price').val();
						var servicesName				= $('#stock_name').val();
						var reg_name 						= $('#vehicle_name').val();
            var reg_model_name      = $('#vehicle_model_name').val();
						var type                = $('#item_type').val();
            var quantity            = 1;

						if (vehicle=="" || vehicle==null) {
									alert("Select the Vehicle name ");
						} else if (services=="" || services==null) {
									alert("Select the Services ");
						} else {
  						vehicleArray.push(vehicle);
  						serviceArray.push(barcode);
  						amountArray.push(stock_price);
  						ItemTypeArray.push(type);
              quantityArray.push(quantity);

  						$("#mydata").show();
  						$('#bill_form').show();
  						//document.getElementById('insertdata').disabled=false;
  						$('#insertdata').attr("disabled", false);
  						let table = document.getElementById("myTableData");

  						//count the table row
  						let rowCount = table.rows.length;

  						//insert the new row
  						let row = table.insertRow(1);
  						  
  						//insert the coulmn against the row
  						row.insertCell(0).innerHTML= rowCount;
  						row.insertCell(1).innerHTML= reg_model_name+' - '+reg_name;
  						row.insertCell(2).innerHTML= servicesName;
  						row.insertCell(3).innerHTML= type;
              row.insertCell(4).innerHTML= quantity;
  						row.insertCell(5).innerHTML= stock_price;

  						$('#barcode').val("");
  						$('#barcode').focus();
  						$('#remove_index').show();

              for(var i = 1; i < table.rows.length; i++) {
			          table.rows[i].onclick = function() {
                  $('#removed_value').show();
                  $('#remove').show();
                   // get the seected row index
                  rIndex = this.rowIndex;
                  document.getElementById("remove_value").value = rIndex;
                  document.getElementById("removed_value").value = this.cells[2].innerHTML;
                  document.getElementById("check_no").value = this.cells[4].innerHTML;
                  document.getElementById("check_no_quantity").value = this.cells[4].innerHTML;
                  document.getElementById("remove_amount").value = this.cells[5].innerHTML;
                  $('#check_no').val("");
                  var q = this.cells[4].innerHTML;
                  $("#hide_quantity").val(q); 
                  if(q>1){
                    $('#check_quantity').show();
                    $('#check_no').focus();
                  }  
                  else{ 
                    $('#check_quantity').hide();
                  }       
                };
			        }// loop
				    } // else     
        } // success
    }); 
  }
});

$('#productid').on("change",function(){
  var PRODUCTid = parseInt($('#productid').val());
  $.ajax({
      type:'post',
      data:{PRODUCTid:PRODUCTid},
      url: "$url",
      success: function(result){
        var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
        var count = jsonResult.length;
        if(count > 0){
          $("#availble_stock").val(count);
          $("#message").removeAttr("Style");
          $("#message").html("Stock available");
          $("#message").css({
            "color":"#008D4C",
            "text-align":"left",
            "margin-top":"25px",
          });
        } else if(count == 0) {
            $("#availble_stock").val(count);
            $("#message").html("Stock is not available");
            $("#message").css({
              "color":"red",
              "text-align":"left",
              "margin-top":"25px",
            });
        } 
      }      
  });
});

$('#product_quantity').on("change",function(){
  var productID  = parseInt($("#productid").val());
  var pro_quantity=parseInt($("#product_quantity").val());
  var avastock = $("#availble_stock").val();
  // var remainStock = avastock - pro_quantity;
  // $("#availble_stock").val(remainStock);
  if(pro_quantity =="" || pro_quantity == null){
  } else if(pro_quantity > avastock ) {
    alert("Enter the valid Number of quantities");
    $("#product_quantity").css("border", "1px solid red");
    $("#product_quantity").val("");
    //$("#message").html("not a valid stock");
  } else{
    $("#product_quantity").css("border", "");
    $("#product_quantity").val("");
    $.ajax({
      type:'post',
      data:{productID:productID},
      url: "$url",
      success: function(result){
        var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
        $('#productName').val(jsonResult[0]['product_name']);
        $("#productSellingPrice").val(jsonResult[0]['selling_price']);

        var totalAmount = parseInt($('#tp').val());
        var tprice = jsonResult[0]['selling_price'];
        var totalPrice = tprice*pro_quantity;
        var totalprices = parseInt(totalAmount)+parseInt(totalPrice);
        $('#tp').val(totalprices);
        $('#nt').val(totalprices);
        $('#remaining').val(totalprices);
        $('#disc').val("");
        discountFun();

        var vehicle             = $('#vehicle').val();
        var productid           = parseInt($("#productid").val());
        var stock_price         = $("#productSellingPrice").val();
        var servicesName        = $('#productName').val();
        var reg_name            = $('#vehicle_name').val();
        var reg_model_name      = $('#vehicle_model_name').val();
        var type                = "Product";
        var quantity            = pro_quantity;

        if (vehicle=="" || vehicle==null) {
          alert("Select the Vehicle name ");
        } else if (services=="" || services==null) {
          alert("Select the Services ");
        } else {
          vehicleArray.push(vehicle);
          serviceArray.push(productid);
          amountArray.push(stock_price);
          ItemTypeArray.push(type);
          quantityArray.push(quantity);

          $("#mydata").show();
          $('#bill_form').show();
          //document.getElementById('insertdata').disabled=false;
          $('#insertdata').attr("disabled", false);
          let table = document.getElementById("myTableData");

          //count the table row
          let rowCount = table.rows.length;

          //insert the new row
          let row = table.insertRow(1);
            
          //insert the coulmn against the row
          row.insertCell(0).innerHTML= rowCount;
          row.insertCell(1).innerHTML= reg_model_name+' - '+reg_name;
          row.insertCell(2).innerHTML= servicesName;
          row.insertCell(3).innerHTML= type;
          row.insertCell(4).innerHTML= pro_quantity;
          row.insertCell(5).innerHTML= stock_price;

          $("#product_quantity").val("");
          $("#product_quantity").focus("");
          $('#remove_index').show();

          for(var i = 1; i < table.rows.length; i++) {
            table.rows[i].onclick = function(){
              $('#removed_value').show();
              $('#check_quantity').show();
              $('#remove').show();
              // get the seected row index
              rIndex = this.rowIndex;
              document.getElementById("remove_value").value = rIndex;
              document.getElementById("removed_value").value = this.cells[2].innerHTML;
              document.getElementById("check_no_quantity").value = this.cells[4].innerHTML;
              document.getElementById("remove_amount").value = this.cells[5].innerHTML;
              $('#check_no').val("");
              var q = this.cells[4].innerHTML;
              $("#hide_quantity").val(q); 
              if(q>1){
                $('#check_quantity').show();
                $('#check_no').focus();
              }
              else{
                  $('#check_quantity').hide();
              }         
            };
          }
        }     
      }      
    });
  }
});

$('#remove').click(function(){
	var remove_value1= $('#remove_value').val();
  var no_quantity = Number(document.getElementById("hide_quantity").value);
  var check_quantity = Number(document.getElementById("check_no").value);
	var remain_number = no_quantity - check_quantity;
	if(remove_value1 =="" || remove_value1==null){
		alert("Please Select the Service/Item to remove");
	} else if((check_quantity>no_quantity)&&(no_quantity>1)){
    alert("Enter valid Amount");
    $("#check_no").css("border", "1px solid red");
    $('#check_no').focus();
    $('#check_no').val("");
  } else if((check_quantity=="" || check_quantity==null)&&(no_quantity>1)){
    alert("The No of item are required ");
    $("#check_no").css("border", "1px solid red");
    $('#check_no').focus();
    $('#check_no').val("");
  } else{      
    var qty = $("#hide_quantity").val();
    var nt=$('#tp').val();
    var remove_value = $('#remove_value').val();
    if((qty > 1)&&(check_quantity<no_quantity)) {
      document.getElementById("myTableData").rows[remove_value].cells[4].innerHTML = remain_number;
      var remove_amount = Number(document.getElementById("remove_amount").value);

      var remain_amount = nt - check_quantity*remove_amount;
      $("#tp").val(remain_amount);
      $("#nt").val(remain_amount);
      $("#remaining").val(remain_amount);
      var a =amountArray.length - remove_value1;
      quantityArray[a] = remain_number;
      //alert(quantityArray[a]);
      $('#checke_no').val("");
      $('#remove_value').val("");
      $('#remove_value1').val("");
    } else{
      document.getElementById("myTableData").deleteRow(remove_value1);
      var a =amountArray.length - remove_value1;
    
      if(qty > 1){
        var qty_amount = amountArray[a]*qty;
        var nta = nt-qty_amount;
        
      }else{
        var nta = nt-amountArray[a];
      }

      amountArray.splice(a,1);
      vehicleArray.splice(a,1);
      serviceArray.splice(a,1); 
      ItemTypeArray.splice(a,1);
      quantityArray.splice(a,1);

      $('#remove_value').val("");
      $('#removed_value').val("");
      $('#tp').val(nta);
      $('#nt').val(nta);
      $('#remaining').val(nta);
      $('#status').val("Unpaid");
      $('#disc').val("");
      $('#paid').val("0");

      if(amountArray.length==0){
        $('#mydata').hide();
        $('#remove_index').hide();
        $('#bill_form').hide();
        $('#price').val("");
        $('#selling_price').val("");
        $("#productSellingPrice").val("");
        //$('#vehicle').val("");
        $('#item_type').val("");
        //$('#types').hide();
        $('#stock').hide();
        $('#servic').hide();
        $('#pname').hide();
        $('#quantity').hide();
        $('#product_quantity').val("");
        $('#nta').val("");
        $("#availbleStock").hide();
        $("#message").hide();
      }
    }
  }
  $('#removed_value').hide();
  $('#remove').hide();
  $('#check_quantity').hide();
  $('#check_no').val("");
});

$('#insert').click(function(){
  // krajeeDialog.confirm('Are you sure to add bill', function(out){
  // if(out) {    
		var invoice_date = $('#invoice_date').val();
    //var payment_type = $('#payment-type').val();
		
		vehicleArray;
		serviceArray; 
		amountArray;
		ItemTypeArray;
    quantityArray;

		var total_amount = $('#tp').val();
		var net_total = $('#nt').val();
		var paid = $('#paid').val();
    var remaining = $('#remaining').val();
    var status = $('#status').val();
    //var narration = $('#narration').val();
    var cash_return = $('#cash_return').val();

    //alert(vehicleArray +"-"+ serviceArray +"-"+ amountArray +"-"+ ItemTypeArray +"-"+ quantityArray +"-"+ total_amount +"-"+ net_total +"-"+ paid +"-"+ remaining +"-"+ status +"-"+ cash_return);
    
		if(invoice_date=="" || invoice_date==null){
			alert('Please Select the date ');
			$('#invoice_date').css("border", "1px solid red");
			$('#invoice_date').focus();
		}
		else if(net_total=="" || net_total==null){
			alert('Please Enter the value Net Total');
			$('#nt').css("border", "1px solid red");
			$('#invoice_date').css("border", "1px solid ");
			$('#nt').focus();
		}
    else if(paid=="" || paid==null){
      alert('Please Enter the Paid Amount');
      $('#paid').css("border", "1px solid red");
      $('#nt').css("border", "1px solid white");
      $('#paid').focus();
    }
		else{
			$.ajax({
	      type:'post',
	      data:{
        	user_id:user_id,
          branch_id:branch_id,
    			invoice_date:invoice_date,
          vehicleArray:vehicleArray,
					serviceArray:serviceArray,
					amountArray:amountArray,
					ItemTypeArray:ItemTypeArray,
          quantityArray:quantityArray,
					total_amount:total_amount,
					net_total:net_total,
          paid:paid,
          remaining:remaining,
          cash_return:cash_return,
          status:status
      	},
        url: "$url",
        success: function(result){
          if(result){
            //console.log(result);
            var sIHId = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            $('#saleInvId').val(sIHId[0]);
            bill();
          }
        }      
  	  }); // ajax 
		} // else
    // }
  // });
}); // insert button

JS;
$this->registerJs($script);
?>

