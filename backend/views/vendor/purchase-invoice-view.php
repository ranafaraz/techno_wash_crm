<?php  
use common\models\Branches;
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
use yii\helpers\Html;
use kartik\dialog\Dialog;

?>
<?php 

 if(isset($_POST['insert_pay']))
 {
   $piID        = $_POST['piID'];
   $vendorID    = $_POST['vendorID'];
   $netTotal    = $_POST['net_total'];
   $paid_amount = $_POST['paid_amount'];
   $remaining   = $_POST['remaining'];
   $pay         = $_POST['pay'];
   $status      = $_POST['status'];
   $narration   = $_POST['narration'];
   $transaction_date = $_POST['transaction_date'];

   $id   =Yii::$app->user->identity->id;

     // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {

      $trans = Transactions::find()->orderBy(['transaction_id' => SORT_DESC])->One();
    if(empty($trans))
    {
      $transaction_id = '1';
    }else
    {
      $transaction_id = $trans->transaction_id + 1;
    }
      $insert_purchase_invoice = Yii::$app->db->createCommand()->update('purchase_invoice',[

     'net_total'        => $netTotal,
     'paid_amount'      => $paid_amount,
     'remaining_amount' => $remaining,
     'status'           => $status,
     'created_by'       => $id,
    ],
       ['vendor_id' => $vendorID ,'purchase_invoice_id' => $piID]

    )->execute();

    $purchase_invoice_amount = Yii::$app->db->createCommand()->insert('purchase_invoice_amount_detail',[

    'purchase_invoice_id' => $piID,
    'transaction_date'    => $transaction_date,
    'paid_amount'       => $pay,
    'transaction_id'    => $transaction_id,
    'created_by'      => $id,

  ])->execute();
   // getting transaction id with one increment ;
    
    
    // getting current asset from Account Nature and cash debit account from account head;
    $head = AccountHead::find()->where(['account_name' => 'Cash'])->One();
    $cred = AccountHead::find()->where(['account_name' => 'Account Payable'])->One();
    Yii::$app->db->createCommand()->insert('transactions',
    [
      'transaction_id' => $transaction_id,
      'type' => 'Cash Payment',
      'narration' => $narration,
      'credit_account' => $head->id,
      'debit_account' => $cred->id,
      'amount' => $pay,
      'transactions_date' => $transaction_date,
      'created_by' => $id,
    ])->execute();
  
     // transaction commit
     $transaction->commit();
     \Yii::$app->response->redirect(['./purchase-invoice-view', 'customer_id' => $customerID]);
        
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
   $piID                  = $_POST['piID'];
   $vendorID              = $_POST['vendorID'];
   //$bilty_no              = $_POST['bilty_no'];
   $bill_no               = $_POST['bill_no'];
   $purchase_date         = $_POST['purchase_date'];
   //$dispatch_date         = $_POST['dispatch_date'];
   //$receiving_date        = $_POST['receiving_date'];
   $updateDiscount        = $_POST['update_discount'];
   $updatepaidAmount      = $_POST['paid_amount'];
   $updatetotalamount     = $_POST['total_amount'];
   $updatenetTotal        = $_POST['net_total'];
   $updateremainingAmount = $_POST['remaining_amount'];
   $updatestatus          = $_POST['status'];
   $transactionDateArray    = $_POST['transaction_date'];
   $paidAmountArray         = $_POST['detail_paid_amount'];
   $purchaseInvAmountIDArray    = $_POST['purchaseInvAmountID'];
   $transaction_update_id  = $_POST['transaction_id'];

   $id   =Yii::$app->user->identity->id;

     // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $insert_purchase_invoice = Yii::$app->db->createCommand()->update('purchase_invoice',[
     //'bilty_no' => $bilty_no,
     'bill_no' => $bill_no,
     'purchase_date' => $purchase_date,
     //'dispatch_date' => $dispatch_date,
     //'receiving_date' => $receiving_date,
     'total_amount' => $updatetotalamount,
     'discount' => $updateDiscount,
     'net_total' => $updatenetTotal,
     'paid_amount' => $updatepaidAmount,
     'remaining_amount' => $updateremainingAmount,
     'status' => $updatestatus,
    ],
       ['vendor_id' => $vendorID ,'purchase_invoice_id' => $piID]

    )->execute();



    $countpaidAmountArray = count($paidAmountArray);
    $counttransid = count($transaction_update_id);
    for($j=0; $j<$counttransid; $j++)
    {
     $tran = Yii::$app->db->createCommand()->update('transactions',
        [
          'transactions_date' => $transactionDateArray[$j],
          'amount' => $paidAmountArray[$j],
          'narration' => 'After Updation paid '.$paidAmountArray[$j].' out of total ' .$updatetotalamount,
        ],['transaction_id' => $transaction_update_id[$j]]
      )->execute();
    }



    for($i=0; $i<$countpaidAmountArray; $i++){
      $p_inv_amount_detail = Yii::$app->db->createCommand()->update('purchase_invoice_amount_detail',[
        
      'transaction_date' => $transactionDateArray[$i],
      'paid_amount' => $paidAmountArray[$i],
      ],
         ['purchase_invoice_id' => $piID , 'p_inv_amount_detail' => $purchaseInvAmountIDArray[$i]]

      )->execute();
    }
     // transaction commit
     $transaction->commit();
     \Yii::$app->response->redirect(['./purchase-invoice-view', 'customer_id' => $customerID]);
        
     } // closing of try block 
     catch (Exception $e) {
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
}

 ?>

 <?php

  $vendorID = $_GET['vendor_id'];

  $id=Yii::$app->user->identity->id;

  // getting customer name
  $vendorData = Yii::$app->db->createCommand("
    SELECT *
    FROM vendor
    WHERE vendor_id = $vendorID
    ")->queryAll();

  $branchId = $vendorData[0]['branch_id'];
  $branchData = Branches::find()->where(['branch_id' => $branchId])->one();

   // getting stock type
  $stockType = Yii::$app->db->createCommand("
    SELECT *
    FROM stock_type
    ")->queryAll();
  $countStockType = count($stockType);

   // getting manufacturer
  $manufacture = Yii::$app->db->createCommand("
    SELECT *
    FROM manufacture
    ")->queryAll();
  $countManufacture = count($manufacture);

  $paid_invoice = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice 
    WHERE vendor_id = '$vendorID'
    AND (status = 'Paid' OR status = 'paid')
    ORDER BY purchase_invoice_id DESC
    ")->queryAll();
  $count_piad_invoice = count($paid_invoice);

  $credit_invoice = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice 
    WHERE vendor_id = '$vendorID' 
    AND (status = 'Partially')
    ORDER BY purchase_invoice_id DESC
    ")->queryAll();
  $count_credit_invoice = count($credit_invoice);

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<style type="text/css" media="screen">
#myTableData thead tr:hover{
      background-color: #ECF0F5;
      cursor: pointer;
    }
body th{
  vertical-align:middle !important;
} 
body td{
  vertical-align:middle !important;
}    
</style>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4" style="margin-top:0px">
              <p style="color:#3C8DBC;font-size:1.3em;"><label style="color: #000000;">Vendor:&ensp;</label><b><i><?php echo $vendorData[0]['name']; ?></i></b></p>
            </div>
            <div class="col-md-4" style="margin-top: 10px">
              <label style="float: right;">Purchase Date:</label>
            </div> 
            <div class="col-md-4" style="margin-top:0px">
                <input type="date"  class="form-control" id="purchase_date" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#invoice" data-toggle="tab">New Invoice</a>
              </li>
              <li><a href="#paid_invoices" data-toggle="tab">Paid Invoices <span class="badge"><?=$count_piad_invoice?></span></a></li>
              <li><a href="#payable" data-toggle="tab">Payable <span class="badge"><?=$count_credit_invoice?></span></a></li>
              <li><a href="#profile" data-toggle="tab">Vendor Profile</a></li>
            </ul>
            <div class="tab-content" style="background-color: #efefef;">
              <div class="active tab-pane" id="invoice"  style="background-color:lightgray;padding:10px;">
               
                  <div class="form-group">
                    <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">   

                        <input type="hidden"  class="form-control" id="dispatch_date">  
                        <input type="hidden"  class="form-control" id="receiving_date"> 
                        <input type="hidden"  class="form-control" id="bilty_no" onkeypress="return checkSpcialChar(event)">
                        <input type="hidden"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="original_price" class="form-control">   
                  </div> 
                </form>
                <div class="row">
                	<div class="col-md-12">
        				<div class="container-fluid" style="margin-bottom:;">
                    <?php echo Dialog::widget([
                         'libName' => 'krajeeDialog',
                         'options' => [], // default options
                      ]); ?>
                    <div class="row" style="font-weight: bolder;font-size:20px;background-color:#3C8DBC;color:white;">
                      <div class="col-md-6">
                        <p style="margin-top:12px;text-align: center;">Add Stock</p>
                      </div>
                      <div class="col-md-2" style="margin-top:12px;">
                        <label style="float: right;">Bill:</label>
                      </div>
                      <div class="col-md-4" style="margin-top:8px;">
                        <div class="form-group>">
                          <input type="text"  class="form-control" id="bill_no" onkeypress="return checkSpcialChar(event)">
                        </div>
                      </div>
                    </div>
						    </div><br>
			            <div class="row">
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Select Stock Type</label>
				            		<select class="form-control" id="stock_type">
				            			<option value="">Select Stock Type</option>
				            			<?php 
				            			for ($i=0; $i <$countStockType ; $i++) {
				            			?>
				            			<option value="<?php echo $stockType[$i]['stock_type_id']; ?>"><?php echo $stockType[$i]['name'];  ?></option>
				            			<?php } ?>
				            		</select>
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Manufacture</label>
				            		<select class="form-control" id="manufacture_type">
				            			<option value="">First Select StockType</option>
				            		</select>
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Product Name</label>
				            		<select class="form-control" id="product_name">
                          <option value="">First Select Manufacturer</option>
                        </select>
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Expiry Date</label>
				            		<input type="date" class="form-control" id="expiry_date">
			            		</div>
			            	</div>
			            </div>
			            <div class="row">
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Purchase Price</label>
                        <input type="text"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="purchase_price" class="form-control">
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Selling Price</label>
                        <input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="selling_price" class="form-control" >
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Barcode</label>
				            		<input type="text" class="form-control" id="barcode">
			            		</div>
			            	</div>
                    <div class="col-md-3">
                      <div class="fomr-group">
                        <label>Quantity</label>
                        <input type="text" name="" class="form-control" id="quantity" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
                      </div>
                    </div>
			            	<input type="hidden" id="stockTypeName">
			            	<input type="hidden" id="manufactreName">
                    <input type="hidden" id="productName">
			            </div>		
                	</div>
                </div><hr>			
                <div class="row">
                    <div class="col-md-12" >
                        <div class="row" id="mydata" style="display:none;">
                          <div class="col-md-1"></div>
                          <div class="col-md-4">
                             <input type="text" class="form-control" id="remove_value" style="display: none;" readonly="">
                             <input type="text"  id="remove_value1" style="display: none;">
                             <input type="text" id="hide_quantity" style="display: none;">
                             <input type="text" id="get_purchase_value" style="display: none;">
                          </div>
                          <div class="col-md-4" style="display: none" id="quantity_no_div">
                            <input type="text" class="form-control" id="check_no" placeholder="Enter quantity to remove" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
                          </div>
                          <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-flat" id="remove" style="display: none;"> <i class="fa fa-times"></i> Remove</button>
                          </div>
                        
							<div class="col-md-12">
                <br>
								<table class="table table-bordered" id="myTableData">
									<thead>
										<tr>
											<th style="background-color: #3C8DBC;color:white;">Sr #</th>
											<th style="background-color: #3C8DBC;color:white;">ST.</th>
											<th style="background-color: #3C8DBC;color:white;">Mnu.</th>
											<th style="background-color: #3C8DBC;color:white;">Name</th>
											<th style="background-color: #3C8DBC;color:white;">Exp. Date</th>
											<!-- <th style="background-color: #3C8DBC;color:white;">Org. Price</th> -->
											<th style="background-color: #3C8DBC;color:white;">Purch Price</th>
											<th style="background-color: #3C8DBC;color:white;">Sale Price</th>
                      						<th style="background-color: #3C8DBC;color:white;">Qty</th>
										</tr>
									</thead>
									<tbody style="background-color:lightgray;color:black;">
										
									</tbody>
								</table>
							</div>
						</div>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="paid_invoices"  style="background-color:lightgray;padding:10px;">
                <div class="row">
                  <div class="col-md-12">
                      <h3 class="text-info" style="vertical-align: middle; margin-bottom: 25px !important;text-align: center;">Paid Invoices Detail</h3>
                    </div>    
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">                      
                        <table class="table table-bordered">
                            <thead style="background-color: #367FA9;color:white;">
                                <tr>
                                    <th style="text-align: center;">Sr.#</th>
                                    <!-- <th class="t-cen">Invoice #</th> -->
                                    <!-- <th class="t-cen">Bilty No#</th> -->
                                    <th style="text-align: center;">Bill No#</th>
                                    <th style="text-align: center;">Paid Amount</th>
                                    <th style="text-align: center;">Purchase Date</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody style="background-color:#b0e0e6;font-family:arial;font-weight:bolder;">
                              <?php 
                                  
                                  
                                    for ($i=0; $i <$count_piad_invoice ; $i++) {

                                      ?>
                                      <tr>
                                        <td  style="text-align: center;"><?php echo $i+1; ?></td>
                                        <!-- <td><?php echo $paid_invoice[$i]['bilty_no']; ?></td> -->
                                        <td  style="text-align: center;"><?php echo $paid_invoice[$i]['bill_no']; ?></td>
                                        <td  style="text-align: center;"><?php echo $paid_invoice[$i]['paid_amount']; ?></td>
                                        <td  style="text-align: center;"><?php $date = date('d-M-Y',strtotime($paid_invoice[$i]['purchase_date']));
                                            echo $date; ?></td>
                                            <td class="text-center">
                                              <a href="./paid-purchase-invoice?piID=<?=$paid_invoice[$i]['purchase_invoice_id']?>&vendorID=<?=$vendorID?>" title="View" class="label label-warning"><i class="fa fa-eye"></i> Bill
                                              </a><br>
                                              <a href="./update-purchase-invoice?piID=<?php echo $paid_invoice[$i]['purchase_invoice_id'];?>&vendorID=<?php echo $vendorID;?>" class="label label-info" title="Edit"><i class="fa fa-edit"></i> Update</a><br>
                                              <a href="./purchase-invoice-transaction?purchaseinvoiceID=<?=$paid_invoice[$i]['purchase_invoice_id'];?>&vendorID=<?=$vendorID?>" title="Transaction" class="label label-success"><i class="glyphicon glyphicon-transfer"></i> Transactions</a>
                                            </td>
                                      </tr>

                                    <?php
                                  }
                                 ?>
                              
                            </tbody>
                          </table>
                        </div>
                      
                    </div>
                  </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="payable" style="background-color:lightgray;padding:10px;">
                  <div class="row">
                    <div class="col-md-8">
                        <h3 class="text-info" style="">Payable Invoices</h3>
                    </div>
                            <?php
                              $totalcreditAmount=0;
                                for ($i=0; $i <$count_credit_invoice ; $i++) {
                                     $totalcreditAmount += $credit_invoice[$i]['remaining_amount'];
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
                                    <th style="text-align: center;">Sr.#</th>
                                    <!-- <th class="t-cen">Invoice #</th> -->
                                    <!-- <th class="t-cen">Bilty No#</th> -->
                                    <th style="text-align: center;">Bill No#</th>                              
                                    <th style="text-align: center;">Net<br>Total</th>
                                    <th style="text-align: center;">Paid<br>Amount</th>
                                    <th style="text-align: center;">Remaining<br>Amount</th>
                                    <th style="text-align: center;">Purchase<br>Date</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody style="background-color:#b0e0e6;font-family:arial;font-weight:bolder;">
                                <?php 

                                    for ($i=0; $i <$count_credit_invoice ; $i++) {
                                        
                                        ?>
                                        
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i+1; ?></td>
                                        <!-- <td><?php echo $credit_invoice[$i]['bilty_no']; ?></td> -->
                                        <td style="text-align: center;"><?php echo $credit_invoice[$i]['bill_no']; ?></td>
                                        <td style="text-align: center;"><?php echo $credit_invoice[$i]['net_total']; ?></td>
                                        <td style="text-align: center;"><?php echo $credit_invoice[$i]['paid_amount']; ?></td>
                                        <td style="text-align: center;"><?php echo $credit_invoice[$i]['remaining_amount']; ?></td>
                                        <td style="text-align: center;"><?php $date = date('d-M-Y',strtotime($credit_invoice[$i]['purchase_date']));
                                            echo $date; ?></td>
                                        <td style="text-align: center;"><?php echo $credit_invoice[$i]['status']; ?></td>
                                        <td class="text-center" style="vertical-align:middle;">
                                          <a href="./credit-purchase-invoice?piID=<?=$credit_invoice[$i]['purchase_invoice_id']?>&vendorID=<?=$vendorID?>" title="View" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> Bill
                                              </a><br>
                                          <a href="./pay-purchase-invoice?piID=<?php echo $credit_invoice[$i]['purchase_invoice_id'];?>&vendorID=<?php echo $vendorID;?>" title="Pay" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Pay</a><br>
                                           <a href="./update-purchase-invoice?piID=<?php echo $credit_invoice[$i]['purchase_invoice_id'];?>&vendorID=<?php echo $vendorID;?>" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Update</a>
                                        </td>
                                      </tr>   
                                
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
              </div>
              <!--- close tab pane --->
              <div class="tab-pane" id="profile"  style="background-color:lightgray;padding:10px;">
            	<div class="row">
            		<div class="col-md-12">
            			 <a href="./vendor-update?id=<?php echo $vendorID;?>" class="btn btn-info" style="float:right; margin-right: 3px; margin-bottom: 3px; margin-top: 15px;"> 
            				<i class="glyphicon glyphicon-edit"></i> Edit
            			</a>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-12">
            			<table class="table table-bordered">
            				<thead>
                      <tr>
                        <th class="text-info" colspan="2" style="text-align: center;font-size:20px;background-color:#367FA9;color:#ffffff;">
                            Vendor Details
                        </th>
                      </tr>
            					<tr>
            						<th style="background-color:lightgray;color:black;">Branch Name:</th>
            						<td class="t-cen" style="background-color:#b0e0e6;font-family:arial;font-weight:bolder;text-align: center;">
            							<?php echo $branchData->branch_name; ?>
            						</td>
            					</tr>
                      <tr>
                        <th style="background-color:lightgray;color:black;">Vendor Name:</th>
                        <td class="t-cen" style="background-color:#b0e0e6;font-family:arial;font-weight:bolder;text-align: center;">
                          <?php echo $vendorData[0]['name']; ?>
                        </td>
                      </tr>
            					<tr>
            						<th style="background-color:lightgray;color:black;">Vendor NTN:</th>
            						<td class="t-cen" style="background-color:#b0e0e6;font-family:arial;font-weight:bolder;text-align: center;">
            							<?php echo $vendorData[0]['ntn']; ?>
            						</td>
            					</tr>
            				</thead>
            			</table>
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
      <div class="box box-success">
        <div class="box-body">
        	<div class="container-fluid" style="margin-bottom:8px;">
            <div class="row">
              <div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
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
          					 <input type="radio" name="discountType" id="percentage"  onclick="abc()"> Percentage
          	
          					<input type="text" name="discount" class="form-control" id="disc" oninput="discountFun()" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57">
          					<input type="hidden" id="name" >
          					<input type="hidden" id="vehicle_name" >
          				</div>
                <div class="form-group">
                  <label>Net Total</label>
                  <input type="text" name="net_total" class="form-control" id="nt"readonly="" >
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
                  <label>status</label>
                  <input type="text" name="status" class="form-control" readonly="" id="status">
                </div>
                <div class="form-group">
                  <label>Narration</label>
                  <input type="text" name="narration" class="form-control"  id="narration">
                </div>
                <div class="form-group">
                <div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;" id="alert">
                </div>
                <hr>
                <button class="btn btn-success btn-block btn-flat" id="insert">
                	<i class="glyphicon glyphicon-plus" ></i> Add Bill</button>
                </div>
               
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

	let barcodeArray   		= new Array();
	let stockTypeArray 		= new Array();
	let manufacturerArray 	= new Array();
	let nameArray 			= new Array();
	let expiryDateArray   	= new Array();
	let originalPriceArray  = new Array();
	let purchasePriceArray  = new Array();
	let sellingPriceArray   = new Array();
	let quantityArray   = new Array();
	let vendorID 			= <?php echo $vendorID; ?>;

	let user_id= <?php echo $id; ?>;
  function abc(){
    $('#disc').val("");
    $('#disc').focus();
    var total = $('#tp').val();
    $('#nt').val(total);
    $('#remaining').val(total);
    $('#paid').val("0");
     
  }
  function checkSpcialChar(event){
            if(!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57) || (event.keyCode == 92) || (event.keyCode == 47) || (event.keyCode == 45))){
               event.returnValue = false;
               return;
            }
            event.returnValue = true;
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

       // alert(originalPrice);
      //discountType  = parseInt(document.getElementById("discountType").value);
        
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
            //alert(purchasePrice);
              }
            else if(document.getElementById('amount').checked)
            {
            	
            discount = parseInt(document.getElementById("disc").value);
                  
            purchasePrice = originalPrice - discount;
            //alert(purchasePrice);
              //discountReceived = discount;
             $('#nt').val(purchasePrice);
             $('#paid').val("0");
             
              if($('#paid').val()!="" || $('#paid').val()!=null){
                remaining = purchasePrice-$('#paid').val();
                $('#remaining').val(remaining);
              }
            } 
            $('#insert').show();
            if (purchasePrice < 0) {
              //$('#insert').hide();
              $("#insert").attr("disabled", true);
              $('#alert').css("display","block");
              $('#alert').html("&ensp;Discount Cannot Be Greater Than Total Amount");
            }else{
              
              $('#alert').css("display","none");
              $("#insert").removeAttr("disabled");
            }
            var paid = $('#paid').val();
            if(paid == "" || paid == null)
                    {
                    $("#insert").attr("disabled", true);
                    $('#alert').css("display","block");
                    $('#alert').html("&ensp;Paid Amount Cannot Be Empty");
                  }
      }
    }
      //
      //   var input1 = Number(document.getElementById( "original_price" ).value);
      //   var input2 = Number(document.getElementById( "purchase_price" ).value);
      //   if (input1<input2) {
      //     alert("The Purchase Price can not be greater than the original price")
      //     $('#purchase_price').val("");
      //     $('#purchase_price').css("border", "1px solid red");
      //   }
      // }
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


</script>
<?php
$url = \yii\helpers\Url::to("vendor/fetch-vendor-info");


$script = <<< JS

	$("#stock_type").change(function(){
		 var stockType = $('#stock_type').val();

		 $.ajax({
          type:'post',
          data:{
            stockType:stockType
            },
          url: "$url",
          success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            //console.log(jsonResult);

            $('#manufacture_type').empty();
            $('#manufacture_type').append("<option>"+"Select Manufacturer"+"</option>");
            var options = '';
                for(var i=0; i<jsonResult.length; i++) { 
                    options += '<option value="'+jsonResult[i]['manufacture_id']+'">'+jsonResult[i]['name']+'</option>';
                }
            // Append to the html
            $('#manufacture_type').append(options);
                    
          }      
      });
	});

  $("#manufacture_type").change(function(){
     var manufactureType = $('#manufacture_type').val();

     $.ajax({
          type:'post',
          data:{
            manufactureType:manufactureType
            },
          url: "$url",
          success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            console.log(jsonResult);

            $('#product_name').empty();
            $('#product_name').append("<option>"+"Select Product"+"</option>");
            var options = '';
                for(var i=0; i<jsonResult.length; i++) { 
                    options += '<option value="'+jsonResult[i]['product_id']+'">'+jsonResult[i]['product_name']+'</option>';
                }
            // Append to the html
            $('#product_name').append(options);
                    
          }      
      });
  });

	$("#barcode").change(function(){
		var barcode 			= $("#barcode").val();
		var stock_type 			= $("#stock_type").val();
		var manufacture_type 	= $("#manufacture_type").val();
		var name 				= $("#product_name").val();
		var expiry_date 		= $("#expiry_date").val();
		var original_price 		= $("#original_price").val();
		var purchase_price 		= $("#purchase_price").val();
		var selling_price 		= $("#selling_price").val();
		var qty					      = 1;
		var stockTypeName 		=  $('#stockTypeName').val();
		var manufactreName 		=  $('#manufactreName').val();
    var product_name    	=  $('#productName').val();

		var totalAmount = parseInt($('#tp').val());

		var tp = parseInt(totalAmount)+parseInt(purchase_price);
		  $('#tp').val(tp);
      $('#nt').val(tp);
      $('#disc').val("");
      $('#paid').val("0");
      $('#remaining').val(tp);
      $('#status').val('Unpaid');

		if(stock_type == "" || stock_type == null)
		{
			alert('Please Select the Stock Type');
      $('#stock_type').css("border", "1px solid red");
      $('#stock_type').focus();
		}
		else if(manufacture_type == "" || manufacture_type == null)
		{
			alert('Please Select the Manufacture Type');
      $('#manufacture_type').css("border", "1px solid red");
      $('#manufacture_type').focus();
		}
		else if(name == "" || name == null)
		{
			alert('Please Select the Name');
      $('#product_name').css("border", "1px solid red");
      $('#product_name').focus();
		}
		else if(expiry_date == "" || expiry_date == null)
		{
			alert('Please Select the Expiry Date');
      $('#expiry_date').css("border", "1px solid red");
      $('#expiry_date').focus();
		}
		// else if(original_price == "" || original_price == null)
		// {
		// 	alert('Please fill the Original Price');
  //     $('#original_price').css("border", "1px solid red");
  //     $('#original_price').focus();
		// }
		else if(purchase_price == "" || purchase_price == null)
		{
			alert('Please fill the Purchase Price');
      $('#purchase_price').css("border", "1px solid red");
      $('#purchase_price').focus();
		}
		else if(selling_price == "" || selling_price == null)
		{
			alert('Please fill the Selling Price');
      $('#selling_price').css("border", "1px solid red");
      $('#selling_price').focus();
		}

		else{
      discountFun();
		barcodeArray.push(barcode);
		stockTypeArray.push(stock_type);
		manufacturerArray.push(manufacture_type);
		nameArray.push(name);
		expiryDateArray.push(expiry_date);
		originalPriceArray.push(original_price);
		purchasePriceArray.push(purchase_price);
		sellingPriceArray.push(selling_price);
		quantityArray.push(qty);

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
		row.insertCell(1).innerHTML= stockTypeName;
		row.insertCell(2).innerHTML= manufactreName;
		row.insertCell(3).innerHTML= product_name;
		row.insertCell(4).innerHTML= expiry_date;
		//row.insertCell(5).innerHTML= original_price;
		row.insertCell(5).innerHTML= purchase_price;
		row.insertCell(6).innerHTML= selling_price;
    row.insertCell(7).innerHTML= qty;

		$('#barcode').val("");
		$('#barcode').focus();
		}
    table = document.getElementById("myTableData");
    for(var i = 1; i < table.rows.length; i++) {
      table.rows[i].onclick = function()
        {
          $('#remove_value').show();
          $('#remove').show();
         
          // get the seected row index
          rIndex = this.rowIndex;
          document.getElementById("remove_value1").value = rIndex;
          document.getElementById("remove_value").value = this.cells[3].innerHTML;
          document.getElementById("hide_quantity").value = this.cells[7].innerHTML;
          document.getElementById("get_purchase_value").value = this.cells[5].innerHTML;
          $('#check_no').val("");
           $('#check_no').focus();
          var q = Number(document.getElementById("hide_quantity").value);
        if(q>1){
          $('#quantity_no_div').show();
        } else {
          $('#quantity_no_div').hide();
        }
      };
    }


	});

	$("#quantity").change(function(){

		var qty 				= parseInt($('#quantity').val());
		var stock_type 			= $("#stock_type").val();
		var manufacture_type 	= $("#manufacture_type").val();
		var name 				= $("#product_name").val();
		var expiry_date 		= $("#expiry_date").val();
		var original_price 		= $("#original_price").val();
		var purchase_price 		= $("#purchase_price").val();
		var selling_price 		= $("#selling_price").val();
		var stockTypeName 		= $('#stockTypeName').val();
		var manufactreName 		= $('#manufactreName').val();
    	var product_name    	= $('#productName').val();
    	var barcode				= ''; 

    	var totalAmount = parseInt($('#tp').val());
		var pp = parseInt(purchase_price)*qty;
		var tp = parseInt(totalAmount)+pp;
		$('#tp').val(tp);
        $('#nt').val(tp);
        $('#disc').val("");
        $('#paid').val("0");
        $('#remaining').val(tp);
        $('#status').val('Unpaid');
        discountFun();


        if(stock_type == "" || stock_type == null)
		{
			alert('Please Select the Stock Type');
		    $('#stock_type').css("border", "1px solid red");
		    $('#stock_type').focus();
		}
		else if(manufacture_type == "" || manufacture_type == null)
		{
			alert('Please Select the Manufacture Type');
	      	$('#manufacture_type').css("border", "1px solid red");
	      	$('#manufacture_type').focus();
		}
		else if(name == "" || name == null)
		{
			alert('Please Select the Name');
	      	$('#product_name').css("border", "1px solid red");
	      	$('#product_name').focus();
		}
		else if(expiry_date == "" || expiry_date == null)
		{
			alert('Please Select the Expiry Date');
	      	$('#expiry_date').css("border", "1px solid red");
	      	$('#expiry_date').focus();
		}
		// else if(original_price == "" || original_price == null)
		// {
		// 	alert('Please fill the Original Price');
	 //      	$('#original_price').css("border", "1px solid red");
	 //      	$('#original_price').focus();
		// }
		else if(purchase_price == "" || purchase_price == null)
		{
			alert('Please fill the Purchase Price');
		    $('#purchase_price').css("border", "1px solid red");
		    $('#purchase_price').focus();
		}
		else if(selling_price == "" || selling_price == null)
		{
			alert('Please fill the Selling Price');
	      	$('#selling_price').css("border", "1px solid red");
	      	$('#selling_price').focus();
		}
		else
		{
			barcodeArray.push(barcode);
			stockTypeArray.push(stock_type);
			manufacturerArray.push(manufacture_type);
			nameArray.push(name);
			expiryDateArray.push(expiry_date);
			originalPriceArray.push(original_price);
			purchasePriceArray.push(purchase_price);
			sellingPriceArray.push(selling_price);
			quantityArray.push(qty);

			$("#mydata").show();
			$('#bill_form').show();
			$('#insertdata').attr("disabled", false);

			let table = document.getElementById("myTableData");

			//count the table row
			let rowCount = table.rows.length;

			//insert the new row
			let row = table.insertRow(1);
		  
			//insert the coulmn against the row

			row.insertCell(0).innerHTML= rowCount;
			row.insertCell(1).innerHTML= stockTypeName;
			row.insertCell(2).innerHTML= manufactreName;
			row.insertCell(3).innerHTML= product_name;
			row.insertCell(4).innerHTML= expiry_date;
			//row.insertCell(5).innerHTML= original_price;
			row.insertCell(5).innerHTML= purchase_price;
			row.insertCell(6).innerHTML= selling_price;
	    	row.insertCell(7).innerHTML= qty;

			$('#quantity').val("");
			$('#quantity').focus();
		}
			table = document.getElementById("myTableData");
	    	for(var i = 1; i < table.rows.length; i++)
            {
	              table.rows[i].onclick = function()
	              {
                  $('#remove_value').show();
                  $('#remove').show();
                  
	                // get the seected row index
	                rIndex = this.rowIndex;
	                document.getElementById("remove_value1").value = rIndex;
                  document.getElementById("remove_value").value = this.cells[3].innerHTML;
                   document.getElementById("hide_quantity").value = this.cells[7].innerHTML;
                    document.getElementById("get_purchase_value").value = this.cells[5].innerHTML;
                    $('#check_no').val("");
                    $('#check_no').focus();
                   var q = Number(document.getElementById("hide_quantity").value);
                   if(q>1){
                    $('#quantity_no_div').show();
                   }
                   else{
                    $('#quantity_no_div').hide();
                   }
	              };
            }
	});

 $("#cash_return").on('input', function(){
    var cashReturn  = $('#cash_return').val();
    var paid        = $('#paid').val();
    var nt          = $('#nt').val();
    var previous_value = paid-nt;
    var temp = cashReturn-previous_value;
    $('#remaining').val(temp);

    
    if(cashReturn == previous_value)
    {
     $('#status').val('Paid');
    $("#insert").attr("disabled", false);
    $('#alert').css("display","none"); 
    }
    if(temp > 0)
    {
     $('#status').val('Partially Paid');
    $("#insert").attr("disabled", false);
    $('#alert').css("display","none"); 
    }

    if(temp < 0)
    {
      $("#insert").attr("disabled", true);
      $('#alert').css("display","block");
      $('#status').val('');
      $('#alert').html("&ensp;Invalid Amount");
    }

  });

 

$("#paid").on('focus', function(){
  $('#paid').val("");
  $('#cash_return').val(0);
  var paid = $('#paid').val();
  // if(paid == "" || paid == null)
  //         {
  //         $("#insert").attr("disabled", true);
  //         $('#alert').css("display","block");
  //         $('#alert').html("&ensp;Paid Amount Cannot Be Empty");
  //       }
  });

   $("#cash_return").on('focus', function(){
    $('#cash_return').val("");
  });

	$('#stock_type').change(function(){

		var stock_type = $("#stock_type").val();

		$.ajax({
	        type:'post',
	        data:{
	        	stock_type:stock_type
	        	},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	$('#stockTypeName').val(jsonResult[0]['name']);
        		      	
        	}      
    	}); 

	});

	$('#manufacture_type').change(function(){

		var manufacture_type = $("#manufacture_type").val();

		$.ajax({
	        type:'post',
	        data:{
	        	manufacture_type:manufacture_type
	        	},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	$('#manufactreName').val(jsonResult[0]['name']);
        		      	
        	}      
    	}); 

	});

  $('#product_name').change(function(){

    var product_name = $("#product_name").val();

    $.ajax({
          type:'post',
          data:{
            product_name:product_name
            },
          url: "$url",
          success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            $('#productName').val(jsonResult[0]['product_name']);
                    
          }      
      }); 

  });
  $('#remove').click(function(){
      var remove_value = $('#remove_value1').val();  
      var hide_quantity = Number(document.getElementById("hide_quantity").value);
      var check_no = Number(document.getElementById("check_no").value);
      var remain_quantity = hide_quantity-check_no;
        if(remove_value=="" || remove_value==null){
          alert("Please select the row");
        }
        else if((check_no>hide_quantity) && (hide_quantity>1)){
          alert("Enter the valid Number of Items");
        }
        else if((check_no=="" || check_no == null) && (hide_quantity>1)){
           alert("Item to be remove can not be empty");
        }
        else{
            if((hide_quantity>1) && (check_no<hide_quantity)){
             //alert(remain_quantity);
              document.getElementById("myTableData").rows[remove_value].cells[7].innerHTML = remain_quantity;
              var remove_amount = Number(document.getElementById("get_purchase_value").value);
              var nt = Number(document.getElementById("tp").value);
              var remain_amount = nt - check_no*remove_amount;
              //alert(remain_amount);
              $('#tp').val(remain_amount);$("#tp").val(remain_amount);
              $("#nt").val(remain_amount);
              $("#remaining").val(remain_amount);
              // $("#disc").val("");
              // $("#paid").val("0");
              var a =quantityArray.length - remove_value;
              
              quantityArray[a] =remain_quantity;
              $('#checke_no').val("");
              $('#remove_value').val("");
              $('#remove_value1').val("");

            }
            else if(check_no == hide_quantity){
              var nt=$('#tp').val(); 
              var a =barcodeArray.length- remove_value; 

              var remove_amount = Number(document.getElementById("get_purchase_value").value);
              document.getElementById("myTableData").deleteRow(remove_value); 
              var remove_amount = Number(document.getElementById("get_purchase_value").value);
              net_of_remove_amount = remove_amount*hide_quantity;
              //alert(quantityArray);
              nt=nt - net_of_remove_amount;
              $('#tp').val(nt); 
              $('#nt').val(nt); 
              $('#remaining').val(nt); 
              barcodeArray.splice(a,1);
              stockTypeArray.splice(a,1);
              manufacturerArray.splice(a,1);
              nameArray.splice(a,1);
              expiryDateArray.splice(a,1);
              originalPriceArray.splice(a,1);
              purchasePriceArray.splice(a,1);
              sellingPriceArray.splice(a,1);
              quantityArray.splice(a,1);
              //alert(quantityArray);

              }

            else{document.getElementById("myTableData").deleteRow(remove_value);
          var a =barcodeArray.length- remove_value;
           // alert(sellingPriceArray[a]);
             //alert(sellingPriceArray);
            var nt=$('#tp').val();
            var nta = nt-purchasePriceArray[a];
            //alert(barcodeArray.length);
            barcodeArray.splice(a,1);
            stockTypeArray.splice(a,1);
            manufacturerArray.splice(a,1);
            nameArray.splice(a,1);
            quantityArray.splice(a,1);
            expiryDateArray.splice(a,1);
            originalPriceArray.splice(a,1);
            purchasePriceArray.splice(a,1);
            sellingPriceArray.splice(a,1);
             //alert(barcodeArray.length);
             $('#tp').val(nta);
             $('#remaining').val(nta);
             $('#nt').val(nta);
             $('#remove_value1').val("");
             $('#remove_value').val("");
            // alert(sellingPriceArray);
             if(barcodeArray.length==0){
              $('#bill_form').hide();
              $('#mydata').hide();
             }
           }
          }
          $('#check_no').val("");
          $('#paid').val("0");
          $('#disc').val("");
          $('#status').val("Unpaid");
          $('#remove_value').hide();
          $('#remove').hide();
          $('#quantity_no_div').hide();
      });


	$('#insert').click(function(){
    krajeeDialog.confirm('Are you sure to add bill', function(out){
    if(out) {
		user_id;
		vendorID;
    var bilty_no    = $('#bilty_no').val();
		var bill_no 		= $('#bill_no').val();
		var purchase_date 	= $('#purchase_date').val();
		var dispatch_date 	= $('#dispatch_date').val();
		var receiving_date 	= $('#receiving_date').val();
		var total_amount 	= $('#tp').val();
		var net_total 		= $('#nt').val();
		var paid 			= $('#paid').val();
	  var remaining 		= $('#remaining').val();
    var cash_return = $('#cash_return').val();
		var status 			= $('#status').val();
    var narration = $('#narration').val();
    barcodeArray;
	 	stockTypeArray;
	 	manufacturerArray;
	 	nameArray;
	 	expiryDateArray;
	 	originalPriceArray;
	 	purchasePriceArray;
	 	sellingPriceArray;
	 	quantityArray;

 		// if(bilty_no == "" || bilty_no == null )
 		// {
 		// 	alert('Please fill Bilty no');
   //    $('#bilty_no').css("border", "1px solid red");
   //    $('#bilty_no').focus();
 		// }
   //  else
    if(bill_no == "" || bill_no == null )
    {
      alert('Please fill Bill no');
      $('#bill_no').css("border", "1px solid red");
      $('#bill_no').focus();
    }
 		else if(purchase_date == "" || purchase_date == null )
 		{
 			alert('Please select purchase date');
      $('#purchase_date').css("border", "1px solid red");
      $('#purchase_date').focus();
 		}
 		// else if(dispatch_date == "" || dispatch_date == null )
 		// {
 		// 	alert('Please select dispatch date');
   //    $('#dispatch_date').css("border", "1px solid red");
   //    $('#dispatch_date').focus();
 		// }
 		// else if(receiving_date == "" || receiving_date == null )
 		// {
 		// 	alert('Please select receiving date');
   //    $('#receiving_date').css("border", "1px solid red");
   //    $('#receiving_date').focus();
 		// }
 		else
 		{
 			$.ajax({
		        type:'post',
		        data:{
              narration:narration,
		        	user_id:user_id,
		        	vendorID:vendorID,
              bilty_no:bilty_no,    
    					bill_no:bill_no, 		
    					purchase_date:purchase_date,
    					dispatch_date:dispatch_date, 	
    					receiving_date:receiving_date, 	
    					total_amount:total_amount, 	
    					net_total:net_total, 		
    					paid:paid, 			
    			    remaining:remaining,
              cash_return:cash_return,
    			    status:status, 		
    			    barcodeArray:barcodeArray,
    			 	  stockTypeArray:stockTypeArray,
    				 	manufacturerArray:manufacturerArray,
    				 	nameArray:nameArray,
    				 	expiryDateArray:expiryDateArray,
    				 	originalPriceArray:originalPriceArray,
    				 	purchasePriceArray:purchasePriceArray,
    				 	sellingPriceArray:sellingPriceArray,
    				 	quantityArray:quantityArray
		        	},
		        url: "$url",
		        success: function(result){ 
              console.log(result);
	        		if(result){
                window.location = './purchase-invoice-view?vendor_id=$vendorID';
        			}     	
	        	}      
    		}); 	
 		}
    }
  });
	});

JS;
$this->registerJs($script);
?>