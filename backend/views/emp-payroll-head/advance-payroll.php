<?php 
use common\models\Transactions;
use common\models\AccountNature;
use common\models\AccountHead;
use common\models\Employee;
	// branch id of login user
	$branchID = Yii::$app->user->identity->branch_id;

	// getting employees of specific branch
	$employeesData  = Yii::$app->db->createCommand("
    SELECT *
    FROM employee
    WHERE branch_id = '$branchID'
    ")->queryAll();
	$countrow = count($employeesData);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="box box-default">
				<div class="box-body">
					<p style="color:#3C8DBC;font-size:25px;text-align: center;font-family:georgia;margin-bottom:-15px;">Advance Pay</p>
					<hr style="border:1px solid #3C8DBC ;">
					<form method="post">
						<input type="hidden" name="<?= Yii::$app->request->csrfParam;?>" value="<?= Yii::$app->request->csrfToken;?>">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><i class="glyphicon glyphicon-calendar" style="color:#3C8DBC;"></i> Select Date:</label>
									<input type="month" id="month" name="month"   class="form-control" required >
								</div>
								<div class="form-group">
									<label>Select Employee</label>
									<select class="form-control" id="emp_id" name="employees">
										<option value="">Select Employee</option>
										<?php 
										for ($i=0; $i <$countrow ; $i++) { ?>
											<option value="<?php echo $employeesData[$i]['emp_id']; ?>"><?php echo $employeesData[$i]['emp_name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Pay</label>
									<input type="text" name="pay" id="emp_pay" class="form-control" readonly="" value="<?php //echo $creditInvoiceData[0]['paid_amount'];?>">

									<input type="hidden" name="pamount" id="pamount" value="<?php //echo $creditInvoiceData[0]['paid_amount'];?>">
								</div>
								
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Paid</label>
									<input type="text" name="paid" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" name="pay" id="paid" class="form-control" oninput="cal_remaining()">
								</div>
								<div class="form-group">
									<label>Remaining</label>
									<input type="text" name="remaining" id="remaining" class="form-control" readonly="">
								</div>
								<div class="form-group">
									<label>Status</label>
									<input type="text" name="status" id="status" class="form-control" readonly="">
								</div>	
							</div>	
						</div>
						<div class="row" id="msg" style="display: none;">
							<div class="col-md-12">
								<div class="alert-danger glyphicon glyphicon-ban-circle" style="padding: 10px;" id="alert">
	            				</div>
	            				<hr>								
							</div>												
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<a href="./emp-payroll-head" class="btn btn-warning" style="width: 100%;"><i class="glyphicon glyphicon-arrow-left"></i>&ensp;Back</a>
							</div>
							<div class="col-md-6">
								<button type="submit" name="insert_pay" id="insert" class="btn btn-success" disabled style="width: 100%;"><i class="fa fa-money" aria-hidden="true"></i>&ensp;Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>
	function cal_remaining(){
      	var paid = $('#paid').val();
      	var emp_pay = $('#emp_pay').val();
      	var remaining = emp_pay - paid;
      	$('#remaining').val(remaining); 
      	if (remaining == 0) {
      		$('#status').val('Paid');
      	}

      	 if (remaining == emp_pay && paid == 0) {
      		$('#status').val('Unpaid');
      	}        
         if (paid > 0 && remaining > 0) {
          $('#status').val('Partially Paid');
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
	if(isset($_POST['insert_pay']))
	{
		$month 		= $_POST['month'];
		$employee 	= $_POST['employees'];
		$pay 		= $_POST['pay'];
		$paid 		= $_POST['paid'];
		$remaining 	= $_POST['remaining'];
		$status 	= $_POST['status'];

		$m = explode('-', $month);

		// starting of transaction handling
     	$transaction = \Yii::$app->db->beginTransaction();
     	try {
     		$payRollHead = Yii::$app->db->createCommand()->insert('emp_payroll_head',[

	        'branch_id' 	=> $branchID,
	        'emp_id' 		=> $employee,
	        'payment_month' => $m[1],
	        'payment_year'  => $m[0],
	        'net_total' 	=> $pay,
	        'paid_amount' 	=> $paid,
	        'remaining' 	=> $remaining,
	        'status' 		=> $status,
	        'created_by'    => Yii::$app->user->identity->id,

	      ])->execute();


     		// transaction

     		$trans = Transactions::find()->orderBy(['transaction_id' => SORT_DESC])->One();
	if(empty($trans))
	{
		$transaction_id = '1';
	}else
	{
		$transaction_id = $trans->transaction_id + 1;
	}
	// getting current asset from Account Nature and cash debit account from account head;
    $nature = AccountNature::find()->where(['name' => 'Asset'])->One();
    $nature1 = AccountNature::find()->where(['name' => 'Expense'])->One();
    $cred = AccountHead::find()->where(['nature_id' => $nature->id])->andwhere(['account_name' => 'Cash'])->One();
    $head = AccountHead::find()->where(['nature_id' => $nature1->id])->andwhere(['account_name' => 'Salaries'])->One();
    $emplo = Employee::find()->where(['emp_id' => $employee])->One();
    Yii::$app->db->createCommand()->insert('transactions',
    [
      'transaction_id' => $transaction_id,
      'type' => 'Cash Payment',
      'narration' => 'Employee Salary Paid to <b>'.$emplo->emp_name.'</b> Rs <b>'.$paid.'</b> for the month <b>'. $m[1] .'-'.$m[0].'</b> ',
      'debit_account' => $head->id,
      'credit_account' => $cred->id,
      'amount' => $paid,
      'transactions_date' => date('Y-m-d'),
      'created_by' => \Yii::$app->user->identity->id,
      
    ])->execute();

			if ($payRollHead) {
				$payRollHeadId = Yii::$app->db->createCommand("
			    SELECT payroll_head_id
			    FROM emp_payroll_head
			    WHERE emp_id = '$employee'
			    AND branch_id = '$branchID'
			    AND payment_month = '$m[1]'
			    AND payment_year = '$m[0]'
			    ")->queryAll();
			    $headId = $payRollHeadId[0]['payroll_head_id'];

			    $payRollDetail = Yii::$app->db->createCommand()->insert('emp_payroll_detail',[

		        'payroll_head_id' 	=> $headId,
		        'transaction_date' 	=> new \yii\db\Expression('NOW()'),
		        'paid_amount' 	=> $paid,
		        'status' 		=> 'Advance',
		        'created_by'    => Yii::$app->user->identity->id,

		      	])->execute();


			}
     		// transaction commit
	            $transaction->commit();?>
	            <script>
	            	window.location = './emp-payroll-head';
	            </script> 
	   <?php  	} // closing of try block 
	     	catch (Exception $e) {
	     		echo $e;
	     		// transaction rollback
	         	$transaction->rollback();
	     	} // closing of catch block	
		
	}


?>
<?php


$script = <<< JS
$('#emp_id').on('change',function(){
    var emp_id = $('#emp_id').val();
    var emp_id = $('#emp_id').val();

    $.get('./emp-payroll-head/calculate-advance-pay',{emp_id : emp_id},function(data){
        
        var data =  $.parseJSON(data);
        $('#emp_pay').val(data);
        
	});        
});

    

    
JS;
$this->registerJs($script);
?>
</script> 