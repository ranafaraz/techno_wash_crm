<?php 
use common\models\Customer; 
use common\models\Branches;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Products;

  $customerID = $_GET['customer_id'];
  $regNoID = $_GET['regno'];

  ?>

  <?php 

 if(isset($_POST['insert_collect']))
 {
   $customerID  = $_POST['custID'];
   $invID       = $_POST['invID'];
   $regNoID     = $_POST['regno'];
   $netTotal    = $_POST['net_total'];
   $paid_amount = $_POST['paid_amount'];
   $remaining   = $_POST['remaining'];
   $collect     = $_POST['collect'];
   $status      = $_POST['status'];

   $id   =Yii::$app->user->identity->id;

     // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $insert_invoice_head = Yii::$app->db->createCommand()->update('sale_invoice_head',[

     'net_total'        => $netTotal,
     'paid_amount'      => $paid_amount,
     'remaining_amount' => $remaining,
     'status'           => $status,
     'created_by'       => $id,
    ],
       ['customer_id' => $customerID,'sale_inv_head_id' => $invID ]

    )->execute();

      $insert_invoice_amount = Yii::$app->db->createCommand()->insert('sale_invoice_amount_detail',[

        'sale_inv_head_id' => $invID,
        'transaction_date'      => new \yii\db\Expression('NOW()'),
        'paid_amount'       => $collect,
        'created_by'      => $id,

      ])->execute();


     // transaction commit
     $transaction->commit();
     header("Location: ./sale-invoice-view?customer_id=$customerID&&regno=$regNoID");
        
     } // closing of try block 
     catch (Exception $e) {
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
}

 ?>

 <?php 

 if(isset($_POST['update_invoice']))
 {
   $customerID              = $_POST['custID'];
   $invID                   = $_POST['invID'];
   $regNoID                 = $_POST['regno'];
  // $net_total               = $_POST['net_total'];
   $updateDate              = $_POST['date'];
   $updateDiscount          = $_POST['update_discount'];
   $updatetotalamount       = $_POST['total_amount'];
   $updatedpaidAmount       = $_POST['paid_amount'];
   $updatenetTotal          = $_POST['net_total'];
   $updateremainingAmount   = $_POST['remaining_amount'];
   $updatestatus            = $_POST['status'];

   $transactionDateArray    = $_POST['transaction_date'];
   $paidAmountArray         = $_POST['detail_paid_amount'];
   $saleInvAmountIDArray    = $_POST['saleInvAmountID'];
   

   $id   =Yii::$app->user->identity->id;

     // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $insert_invoice_head = Yii::$app->db->createCommand()->update('sale_invoice_head',[

     'date' => $updateDate,
     'total_amount' => $updatetotalamount,
     'discount' => $updateDiscount,
     'net_total' => $updatenetTotal,
     'paid_amount' => $updatedpaidAmount,
     'remaining_amount' => $updateremainingAmount,
     'status' => $updatestatus,
    ],
       ['customer_id' => $customerID,'sale_inv_head_id' => $invID ]

    )->execute();

    $countpaidAmountArray = count($paidAmountArray);

    for($i=0; $i<$countpaidAmountArray; $i++){
      $s_inv_amount_detail = Yii::$app->db->createCommand()->update('sale_invoice_amount_detail',[
      'transaction_date' => $transactionDateArray[$i],
      'paid_amount' => $paidAmountArray[$i],
      ],
         ['sale_inv_head_id' => $invID , 's_inv_amount_detail' => $saleInvAmountIDArray[$i]]

      )->execute();
    }
     // transaction commit
     $transaction->commit();
      header("Location: ./sale-invoice-view?customer_id=$customerID&&regno=$regNoID");
     
        
     } // closing of try block 
     catch (Exception $e) {
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
}

 ?>
  <?php

  // getting customer name
  $customerData = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = $customerID
    ")->queryAll();

  // getting vehicle
  $customerVehicles = Yii::$app->db->createCommand("
    SELECT *
    FROM customer_vehicles
    WHERE customer_id = '$customerID'
    ")->queryAll();
    $countcustomerVehicles = count($customerVehicles);

 // getting services
  $services = Yii::$app->db->createCommand("
    SELECT *
    FROM services
    ")->queryAll();
    $countServices = count($services);

 // getting customer name
 
  $paidinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE customer_id = '$customerID' AND (status = 'paid' OR status = 'Paid')
    ORDER BY `date` DESC
    ")->queryAll();

    $countpaidinvoiceData = count($paidinvoiceData);

     $creditinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE customer_id = '$customerID' AND (status = 'Partially' OR status = 'Unpaid')
    ORDER BY `date` DESC
    ")->queryAll();
    $countcreditinvoiceData = count($creditinvoiceData);
    $id =  Yii::$app->user->identity->id;

    $branchId = $customerData[0]['branch_id'];

    $branchData = Branches::find()->where(['branch_id' => $branchId])->one();

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
            <div class="col-md-6" style="margin-top:0px">
              <p style="color:#3C8DBC;font-size:1.3em;"><label style="color: #000000;">Customer:&ensp;</label><b><i><?php echo $customerData[0]['customer_name']; ?></i></b></p>
            </div>
            <div class="col-md-2" style="margin-top: 10px">
              <label style="float: right;">Date:</label>
            </div>  
            <div class="col-md-4" style="margin-top: 10px">
              <?php $date = date("m/d/Y"); ?>
              <input type="date" name="invoice_date"  class="form-control" id="invoice_date" value="<?php echo date('Y-m-d'); ?>" style="margin-top: -6px;">      
            </div>
          </div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#invoice" data-toggle="tab">New Invoice</a>
              </li>
              
              <li><a href="#paidd" data-toggle="tab">Paid Invoices <span class="badge"><?=$countpaidinvoiceData?></span></a></li>
              <li><a href="#credit" data-toggle="tab">Credit <span class="badge"><?=$countcreditinvoiceData?></span></a></li>
              <li><a href="#customer" data-toggle="tab">Customer Profile</a></li>
              <li><a href="#customer_vehicles" data-toggle="tab">Customer Vehicles</a></li>
              <!-- <li><a href="#details" data-toggle="tab">Account Details</a></li> -->
            </ul>
            <div class="tab-content" style="background-color: #efefef;">
              <div class="active tab-pane" id="invoice">
                <div class="form-group">
                        <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="container-fluid" style="margin-bottom:8px;">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Select Vehicle</label>
                            <select name="customer_vehicle" class="form-control" id="vehicle">
                              <?php 
                              for ($i=0; $i <$countcustomerVehicles ; $i++) { 
                              $customerVehicleType = $customerVehicles[$i]['vehicle_typ_sub_id'];
                              $VehicleReg = $customerVehicles[$i]['registration_no'];

                              // getting vehicle type name
                              $VehiclesName = Yii::$app->db->createCommand("
                                SELECT *
                                FROM vehicle_type_sub_category
                                WHERE vehicle_typ_sub_id = '$customerVehicleType'
                                ")->queryAll();
                               ?>
                              <option <?php if ($customerVehicles[$i]['customer_vehicle_id'] == $regNoID) {
                                    echo "selected";
                                  }?> value="<?php echo $customerVehicles[$i]['customer_vehicle_id']; ?>"><?php echo $VehicleReg; ?> <?php echo "- ". $VehiclesName[0]['name']; ?> </option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
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
                            <input type="hidden" name="amount" class="form-control" id="price" readonly="" >
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
                    </div>
                  </div>
                </div> 			
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="paidd">
                  <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-info" style="vertical-align: middle; margin-bottom: 25px !important;">Paid Invoices Details</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">                      
                        <table class="table table-bordered table-striped">
                            <thead style="background-color: #367FA9;color:white;">
                                <tr>
                                    <th class="t-cen" style="vertical-align:middle;">Sr #</th>
                                    <!-- <th class="t-cen" style="vertical-align:middle; width: 100px;">Invoice #</th> -->
                                    <th class="t-cen" style="vertical-align:middle;">Date</th>
                                    <th class="t-cen" style="vertical-align:middle;">Amount</th>
                                    <th class="text-center" style="vertical-align:middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                    for ($i=0; $i <$countpaidinvoiceData ; $i++) {
                                        
                                        ?>
                                        
                                    <tr>
                                        <td style="vertical-align:middle;"><?php echo $i+1; ?></td>
                                        <!-- <td style="vertical-align:middle;"><?php echo $paidinvoiceData[$i]['sale_inv_head_id']; ?></td> -->
                                        <td style="vertical-align:middle;"><?php $date = date('d-M-Y',strtotime($paidinvoiceData[$i]['date']));
                                            echo $date; ?></td>
                                        <td style="vertical-align:middle;"><?php echo $paidinvoiceData[$i]['paid_amount']; ?></td>
                                        <td class="text-center" style="vertical-align:middle;">
                                          <a href="paid-sale-invoice?sihID=<?=$paidinvoiceData[$i]['sale_inv_head_id']?>&regno=<?=$regNoID?>" title="View" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Bill</a>
                                          <a href="update-sale-invoice?saleinvheadID=<?=$paidinvoiceData[$i]['sale_inv_head_id'];?>&customerid=<?=$paidinvoiceData[$i]['customer_id'];?>&regno=<?=$regNoID?>" title="Edit" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Update</a>
                                           <a href="sale-invoice-transaction?saleinvheadID=<?=$paidinvoiceData[$i]['sale_inv_head_id'];?>&customerid=<?=$paidinvoiceData[$i]['customer_id'];?>&regno=<?=$regNoID?>" title="Transaction" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-transfer"></i> Transactions</a>
                                        </td>
                                    </tr>   
                                
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
              </div>
              <div class="tab-pane" id="credit">
                  <div class="row">
                    <div class="col-md-8">
                        <h3 class="text-info" style="vertical-align: middle;">Partially & Unpaid Invoices Details</h3>
                    </div>
                            <?php
                              $totalcreditAmount=0;
                                for ($i=0; $i <$countcreditinvoiceData ; $i++) {
                                     $totalcreditAmount += $creditinvoiceData[$i]['remaining_amount'];
                                }        
                            ?>
                    <div class="col-md-4">
                        <h3 class="text-danger" style="vertical-align: middle; margin-bottom: 20px !important;background-color: white;padding: 6px;border-radius: 3px;">Total Credit: <?= $totalcreditAmount;?></h3>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">                      
                        <table class="table table-bordered table-striped">
                            <thead style="background-color: #367FA9;color:white;">
                                <tr>
                                    <!-- <th class="t-cen" style="vertical-align:middle;">Sr #</th> -->
                                    <!-- <th class="t-cen" style="vertical-align:middle;width: 100px;">Invoice #</th> -->
                                    <th class="t-cen" style="vertical-align:middle;">Date</th>
                                    <th class="t-cen" style="vertical-align:middle;">Total Amount</th>
                                    <th class="t-cen" style="vertical-align:middle;">Paid Amount</th>
                                    <th class="t-cen" style="vertical-align:middle;">Remaining Amount</th>
                                    <th class="t-cen" style="vertical-align:middle;">Status</th>
                                    <th class="t-cen" style="vertical-align:middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                    for ($i=0; $i <$countcreditinvoiceData ; $i++) {
                                        
                                        ?>
                                        
                                    <tr>
                                        <!-- <td style="vertical-align:middle;"><?php //echo $i+1; ?></td> -->
                                        <!-- <td style="vertical-align:middle;"><?php echo $creditinvoiceData[$i]['sale_inv_head_id']; ?></td> -->
                                        <td style="vertical-align:middle;"><?php $date = date('d-M-Y',strtotime($creditinvoiceData[$i]['date']));
                                            echo $date;?></td>
                                        <td style="vertical-align:middle;"><?php echo $creditinvoiceData[$i]['total_amount']; ?></td>
                                        <td style="vertical-align:middle;"><?php echo $creditinvoiceData[$i]['paid_amount']; ?></td>
                                         <td style="vertical-align:middle;"><?php echo $creditinvoiceData[$i]['remaining_amount']; ?></td>
                                        <td style="vertical-align:middle;"><?php echo $creditinvoiceData[$i]['status']; ?></td>
                                        <td class="text-center" style="vertical-align:middle;"><a href="./credit-sale-invoice?sihID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>&regno=<?=$regNoID?>" title="View" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> Bill</a>
                                        <a href="./update-sale-invoice?saleinvheadID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>&customerid=<?php echo $customerID;?>&regno=<?=$regNoID?>" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Update</a>
                                        <a href="./collect-sale-invoice?sihID=<?php echo $creditinvoiceData[$i]['sale_inv_head_id'];?>&customerID=<?php echo $customerID;?>&regno=<?=$regNoID?>" title="Collect" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Collect</a>
                                        </td>
                                    </tr>   
                                
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
              </div>
              <div class="tab-pane" id="customer">
                <div class="row">
                <div class="col-md-11">
                  <h3 class="text-info" style="vertical-align: middle; margin-bottom: 25px !important;">Customer Details</h3>
                </div>
                <div class="col-md-1">
                   <a href="./customer-update?id=<?php echo $customerID;?>&regno=<?=$regNoID?>" class="btn btn-info" style="float:right; margin-right: 3px; margin-bottom: 3px; margin-top: 15px;"> 
                    <i class="glyphicon glyphicon-edit"></i> Edit
                  </a>
                </div>
              </div>
              <div class="row" style="margin-bottom:10px;">
                <div class="col-md-12">
                  <table class="table table-bordered">
                    <thead style="background-color: #367FA9;color:white;">
                      <tr>
                        <th class="text-center">
                    <?php
                          echo "Customer Name: <b style='font-size:15px; font-family:georgia;'>".$customerData[0]['customer_name']."</b>";
                    ?>
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Branch Name:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $branchData->branch_name; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Gender:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_gender']; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">CNIC:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_cnic']; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Address:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_address']; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Contact No:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_contact_no']; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Registration Date:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_registration_date']; ?>
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Age:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_age']; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Email:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_email']; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="bg-color" style="padding: 12px;">Occupation:</th>
                        <th class="t-cen" style="background-color: white;">
                          <?php echo $customerData[0]['customer_occupation']; ?>
                        </th>
                      </tr>
                      <tr>
                        <th class="text-center bg-color" style="vertical-align:middle;">Image:</th>
                        <th class="t-cen" style="background-color: white;">
                          <img src="<?php echo $customerData[0]['customer_image']; ?>" class="img-rounded" alt="Image" style="width:160px; height:150px;"/>
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div> 
              </div>
              <div class="tab-pane" id="customer_vehicles">
                <div class="row">
                <div class="col-md-11">
                  <h3 class="text-info" style="vertical-align: middle; margin-bottom: 25px !important;">Customer Vehicles Details</h3>
                </div>
                <div class="col-md-1">
                  <a href="./customer-vehicles-create?id=<?php echo $customerID;?>&regno=<?=$regNoID?>" class="btn btn-success" style="float:right; margin-right: 3px; margin-bottom: 3px; margin-top: 15px;">
                    <i class="glyphicon glyphicon-plus"></i> Insert
                  </a>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">                
                  <table class="table table-bordered table-striped">
                    <thead style="background-color: #367FA9;color:white;">
                      <tr>
                        <th class="t-cen" style="vertical-align:middle;">Sr #.</th>
                        <th class="t-cen" style="vertical-align:middle;">Customer Name</th>
                        <th class="t-cen" style="vertical-align:middle;">Vehicle Sub Type</th>
                        <th class="t-cen" style="vertical-align:middle;">Registration No</th>
                        <th class="t-cen" style="vertical-align:middle;">Vehicle Color</th>
                        <th class="t-cen" style="vertical-align:middle;">Vehicle Image</th>
                        <th class="t-cen" style="vertical-align:middle;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                        for ($i=0; $i <$countcustomerVehicles ; $i++) {

                      $vehicleSubTypId = $customerVehicles[$i]['vehicle_typ_sub_id'];

                      
                    $vehicleSubType = Yii::$app->db->createCommand("
                      SELECT *
                      FROM vehicle_type_sub_category
                      WHERE vehicle_typ_sub_id = '$vehicleSubTypId'
                      ")->queryAll();

                          ?>
                          
                        <tr>
                          <td style="vertical-align:middle;"><?php echo $i+1; ?></td>
                          <td style="vertical-align:middle;"><?php echo $customerData[0]['customer_name']; ?></td>
                          <td style="vertical-align:middle;"><?php echo $vehicleSubType[0]['name']; ?></td>
                          <td style="vertical-align:middle;"><?php echo $customerVehicles[$i]['registration_no']; ?></td>
                          <td style="vertical-align:middle;"><?php echo $customerVehicles[$i]['color']; ?></td>
                          <td class="text-center" style="vertical-align:middle;"><img src="<?php echo $customerVehicles[$i]['image']; ?>" class="img-thumbnail" alt="Image" style="width:140px; height:100px;"/></td>
                          <td class="text-center" style="vertical-align:middle;"><a href="customer-vehicles-update?id=<?php echo $customerVehicles[$i]['customer_vehicle_id'] ?>&regno=<?=$regNoID?>" title="Edit" class="label label-info"><i class="glyphicon glyphicon-edit"></i> Edit</a></td>
                        </tr> 
                      
                      <?php } ?>
                    </tbody>
                      
                  </table>
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
              <div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: #3C8DBC;color:white;">
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
					<input type="hidden" id="vehicle_name" >
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
                  <label>status</label>
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
	let customer_id        = <?php echo $customerID; ?>;
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
          }else{      
        
          if(document.getElementById('percentage').checked)
              {
              	
            discount = parseInt(document.getElementById("disc").value);
            
            discountReceived = parseInt((originalPrice*discount)/100);
            
            purchasePrice = originalPrice-discountReceived;
            $('#nt').val(purchasePrice);
            if($('#paid').val()!="" || $('#paid').val()!=null){
              remaining = purchasePrice-$('#paid').val();
              $('#remaining').val(remaining);
            }

              
            }
            else if(document.getElementById('amount').checked)
            {
            	
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
      	$('#remaining').val(remaining); 
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
          $("#insert").attr("disabled", true);
          $('#alert').css("display","block");
          $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
        }else{
          $('#alert').css("display","none");
          $("#insert").removeAttr("disabled");
        }

      }
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
             //alert(jsonResult[0]['vehical_type_id']);
          }      
      });
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
  var paid = $('#paid').val();
  if(paid == "" || paid == null)
      {
      $("#insert").attr("disabled", true);
      $('#alert').css("display","block");
      $('#alert').html("&ensp;Paid Amount Cannot Be Empty");
    }
  });

$("#item_type").change(function(){
  $('#servic').val("SelectServices");
  $('#selling_price').val("");
  $('#price').val("");
		var item_type = $('#item_type').val();
		 if(item_type == "Service")
		 {
		 	$('#servic').show();
		 	$('#stock').hide();
      $('#pname').hide();
      $('#quantity').hide();
      $('#availbleStock').hide();
      $('#message').hide();
		 }
		 else if(item_type == "Stock")
		 {
		 	$('#stock').show();
      $('#pname').show();
      $('#barcode').val("");
		 	$('#servic').hide();
      $('#productid').val('').trigger("change");
		 }
		 else{
		 	$('#stock').hide();
		 	$('#servic').hide();
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
    var customerVehicle = $("#vehicle").val()
		//alert(serviceID);
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
            //var after_disc =  $('#disc').val();
            //$('#nt').val(tp);
            //$('#remaining').val(tp);
				    //$('#status').val('Unpaid');

            $('#disc').val("");
            discountFun();

				    var vehicle 						= $('#vehicle').val();
						var services 						= $('#serviceDetailId').val();
						var price 							= $('#price').val();
						var servicesName				= $('#service_name').val();
						var reg_name 						= $('#vehicle_name').val();
						var type                = $('#item_type').val();
            var quantity            = 1;
						
						if (vehicle=="" || vehicle==null)
						{
							alert("Select the Vehicle name ");
						}
						else if (services =="" || services==null) {
									//alert("Select the Services ");
						} else {
  						vehicleArray.push(vehicle);
  						serviceArray.push(services);
  						amountArray.push(price);
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
  						row.insertCell(0).innerHTML=rowCount;
              row.insertCell(1).innerHTML=reg_name;
  						row.insertCell(2).innerHTML= servicesName;
  						row.insertCell(3).innerHTML= type;
              row.insertCell(4).innerHTML= quantity;
  						row.insertCell(5).innerHTML= price;
  						
  					  // $('#vehicle').val("");
              $('#services').val("");

  						$('#remove_index').show();
  						for(var i = 1; i < table.rows.length; i++){
                table.rows[i].onclick = function()
                {
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
    }
    else{
      $('#types').val("");
      $('#types').show();
      
    }
		
		//alert(vehicle);
		$.ajax({
	        type:'post',
	        data:{vehicle:vehicle},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	 $('#vehicle_name').val(jsonResult[0]['registration_no']);
             //alert(jsonResult[0]['vehical_type_id']);
        	}      
    	}); 
     
	});
  
	$("#barcode").on('change',function(){
		var barcode = $("#barcode").val();
    if(barcode=="" || barcode==null){
  
    }
    else{
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
						var type                = $('#item_type').val();
            var quantity            = 1;

						
						if (vehicle=="" || vehicle==null)
						{
									alert("Select the Vehicle name ");
						}
						else if (services=="" || services==null) {
									alert("Select the Services ");
						}
						else
						{
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
						row.insertCell(1).innerHTML= reg_name;
						row.insertCell(2).innerHTML= servicesName;
						row.insertCell(3).innerHTML= type;
            row.insertCell(4).innerHTML= quantity;
						row.insertCell(5).innerHTML= stock_price;


						$('#barcode').val("");
						$('#barcode').focus();
						$('#remove_index').show();

                
                for(var i = 1; i < table.rows.length; i++)
			                {
			                    table.rows[i].onclick = function()
			                    {

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
                          else{  $('#check_quantity').hide();}       
			                    };
			                }
				}
        	}      
    	}); 
          }
	});
   $('#productid').on("change",function(){
   var PRODUCTid = parseInt($('#productid').val());
   

   //$('#message').val("");
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
              
             }
             else if(count == 0){
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

        var vehicle             = $('#vehicle').val();
        var productid           = parseInt($("#productid").val());
        var stock_price         = $("#productSellingPrice").val();
        var servicesName        = $('#productName').val();
        var reg_name            = $('#vehicle_name').val();
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
          row.insertCell(1).innerHTML= reg_name;
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
			}
      
      else if((check_quantity>no_quantity)&&(no_quantity>1)){
        alert("Enter valid Amount");
        $("#check_no").css("border", "1px solid red");
        $('#check_no').focus();
        $('#check_no').val("");
      } 
       else if((check_quantity=="" || check_quantity==null)&&(no_quantity>1)){
        alert("The No of item are required ");
        $("#check_no").css("border", "1px solid red");
        $('#check_no').focus();
        $('#check_no').val("");
        }  


			else{      
         var qty = $("#hide_quantity").val();
         var nt=$('#tp').val();
         var remove_value = $('#remove_value').val();
      if((qty > 1)&&(check_quantity<no_quantity)){
    // alert(remain_number);
      document.getElementById("myTableData").rows[remove_value].cells[4].innerHTML = remain_number;
      var remove_amount = Number(document.getElementById("remove_amount").value);

      var remain_amount = nt - check_quantity*remove_amount;
      $("#tp").val(remain_amount);
      $("#tp").val(remain_amount);
      $("#remaining").val(remain_amount);
      var a =amountArray.length - remove_value1;
      quantityArray[a] = remain_number;
      //alert(quantityArray[a]);
      $('#checke_no').val("");
      $('#remove_value').val("");
      $('#remove_value1').val("");
      
      } 
        else{
          document.getElementById("myTableData").deleteRow(remove_value1);
      var a =amountArray.length - remove_value1;
      
     
      //var nta = nt-amountArray[a];

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
        $('#vehicle').val("");
        $('#item_type').val("");
        $('#types').hide();
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
			var invoice_date = $('#invoice_date').val();
      //pro_quantity
			customer_id;
			vehicleArray;
			serviceArray; 
			amountArray;
 			ItemTypeArray;
      quantityArray;
      //alert(quantityArray);

 			var total_amount = $('#tp').val();
 			var net_total = $('#nt').val();
 			var paid = $('#paid').val();
		    var remaining = $('#remaining').val();
		    var status = $('#status').val();
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
						    vehicleArray:vehicleArray,
	        			invoice_date:invoice_date,
    						customer_id:customer_id,
    						paid:paid,
    						remaining:remaining,
    						status:status,
    						serviceArray:serviceArray,
    						amountArray:amountArray,
    						ItemTypeArray:ItemTypeArray,
    						total_amount:total_amount,
                quantityArray:quantityArray,
    						net_total:net_total,
						
	        	},
	        url: "$url",
	        success: function(result){
            console.log(result);
            if(result){
              alert('Bill is Added');
            window.location = './sale-invoice-view?customer_id=$customerID&regno=$regNoID';
            } else {
              alert('Something wrong.!');
            }
	        }      
    	  });
			}
				

		});

JS;
$this->registerJs($script);
?>
