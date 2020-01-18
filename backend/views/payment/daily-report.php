<?PHP

use dosamigos\datepicker\DatePicker;
use backend\models\AccountHead;
use backend\models\Transactions;
use yii\helpers\Json;
use backend\models\AccountPayable;
use backend\models\AccountRecievable;
use backend\models\Customer;
$this->title = 'REMS (Daily Report)';
$this->params['breadcrumbs'][] = $this->title;
$id = null;
?>
<div class="row">
	<!-- <div class="col-md-12">
		<h4 class="text-primary">REMS (DAILY REPORTS).</h4>
	</div> -->
	<div class="col-md-5">
		
			<div class="row">
				<form action="index.php?r=payment/daily-report" method="POST">
					<div class="col-md-10">
						<label>Select Date</label>
	                	<input type="date" id="fetch_date" name="date" class="form form-control">
					</div>
					<div class="col-md-2">
						<button class="btn" id="button" style="margin-top:24px;color:white;padding: 7px !important; border-radius: 2px !important;background-color: #7C9494;">Search Report</button>
					</div>
				</form>
			</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?PHP
			if(isset($_POST['date']))
			{
				$date = $_POST['date'];
				echo '<h3 class="text-success font-wight-bold">Showing Report Against Date: ' .$date.'</h3>';
			}
		?>
	</div>
</div>
<div class="row" id="print_data" >
	<?PHP $head_query = AccountHead::find()->orderBy(['account_name' => SORT_ASC])->all(); 
		if(isset($head_query))
		{
			
			$i=0;
			$arr=[];
			foreach($head_query as $val){
		?>
			<div class=" col-md-4" style="padding: 10px;height:auto !important;">
				<table class="table table-reponsive table-striped table-borderd tbale-hover" value="<?PHP echo $id = $val->id;?>" id="<?PHP echo $account_name =  $val->account_name;?>">
					<thead>
						<th class="font-wight-bold text-center"><?PHP echo $val->account_name; ?></th>
					</thead>
					<tbody>
						<tr>
							<th class="text-left text-dark bg-success">Debit</th>
						</tr>
						<?PHP 
						$sum_credit=0;
						$sum_debit=0;
						if(isset($_POST['date']))
						{
							$date = $_POST['date'];
							$debit_transactions = Transactions::find()->where(['debit_account' => $id])->andwhere(['transactions_date' => $date])->andwhere(['organization_id' => \Yii::$app->user->identity->organization_id])->all();
							$credit_transactions = Transactions::find()->where(['credit_account' => $id])->andwhere(['transactions_date' => $date])->andwhere(['organization_id' => \Yii::$app->user->identity->organization_id])->all();
							foreach($debit_transactions as $val1)
							{
								$head_model_credit = AccountHead::find()->where(['id' => $val1->credit_account])->One();
								$sum_debit = $sum_debit + $val1->credit_amount;
							?>
								<tr>
									<td><h5 class="text-left"><?PHP echo $head_model_credit->account_name;?></h5><h5 class="text-right"><?PHP echo number_format($val1->credit_amount);?></h5></td>
								</tr>
							<?PHP
							}
							?>
							<tr>
								<th class="text-left" style="color:white;background-color: black">Credit</th>
							</tr>
							<?PHP

							$amount_cradit=0;
							
							foreach ($credit_transactions as  $val2) {

								$head_model_debit = AccountHead::find()->where(['id' => $val2->debit_account])->One();
								// $account_pay = AccountPayable::find()->where(['created_at' => $date])->andwhere(['transaction_id' => $val2->id])->andwhere(['organization_id' => \Yii::$app->user->identity->organization_id])->One();
								
								// if (!empty($account_pay)) {
								// 	 $sum_credit = $sum_credit + $val2->credit_amount + $account_pay->amount;
								// }
								// else
								// {
								// 	$sum_credit = $sum_credit + $val2->credit_amount;
								//}
								$sum_credit = $sum_credit + $val2->credit_amount;
							?>
							<tr>
								<td><h5 class="text-left"><?PHP echo $head_model_debit->account_name;?></h5><h5 class="text-right"><?PHP echo number_format($val2->credit_amount);?></h5></td>
							</tr>
							<?PHP
							}

							if(empty($sum_credit) && empty($sum_debit))
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ['Account Name' => $account_name , 'nature' => 'Credit' , 'amount' => $balance_caried_down];
								?>
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Balance Caried Down : <?PHP echo number_format($balance_caried_down);?></h5></td></tr>
								<?PHP
							}else
							if($sum_credit > $sum_debit)
							{
								$balance_caried_down = (int)$sum_credit - (int)$sum_debit;
								$arr[$i] = ['Account Name' => $account_name , 'nature' => 'Debit' , 'amount' => $balance_caried_down];
								?>
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Debit Caried Down : <?PHP echo number_format($balance_caried_down);?></h5></td></tr>
								<?PHP
							}
							elseif($sum_debit > $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ['Account Name' => $account_name , 'nature' => 'Credit' , 'amount' => $balance_caried_down];
								?>
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : <?PHP echo number_format($balance_caried_down);?></h5></td></tr>
								<?PHP
							}
							elseif($sum_debit == $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ['Account Name' => $account_name , 'nature' => 'Credit' , 'amount' => $balance_caried_down];
								?>
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : <?PHP echo number_format($balance_caried_down);?></h5></td></tr>
								<?PHP
							}
							$i=$i+1;	
						}
						?>
					</tbody>
				</table>
			</div>
			<?php
			}
			
		}
	?>	
</div>
<!--  -->
<div class="row">
	<div class="col-md-12 text-center text-danger">
		<h4 style="font-weight: bold;">Trail Balance</h4>
	</div>
</div>
<div class="row">
	<div class="table-reponsive">
		<table class="table table-borderd table-striped tbale-hover">
			<thead>
				<tr class="bg-primary">
					<th>Account Name</th>
					<th>Credit</th>
					<th>Debit</th>
				</tr>
			</thead>
			<tbody>
				<?PHP
				$j=0;
				$sum=0;
				$sum1=0;
					for($j=0;$j<$i;$j++) {
						// echo mysqli_error();
						?>
						<tr>
							<td><?PHP echo $arr[$j]['Account Name'];?></td>
							
							<?PHP
							if($arr[$j]['nature'] == 'Credit')
							{
							?>
							<td></td>
							<?PHP $sum = $sum + $arr[$j]['amount']?>
							<td><?PHP echo number_format($arr[$j]['amount']);?></td>
							<?PHP }elseif($arr[$j]['nature'] == 'Debit')
							{
								?>
								<?PHP $sum1 = $sum1 + $arr[$j]['amount']?>
								<td><?PHP echo number_format($arr[$j]['amount']);?></td>
								<td></td>
								<?PHP
							}?>
						</tr>
						<?PHP	
					}
				?>
				<tr class="bg-danger text-success">
					<td style="font-weight: bold;">Total Amount</td>
					<td  style="font-weight: bold;"><?PHP echo number_format($sum1) ; ?></td>
					<td style="font-weight: bold;"><?PHP echo number_format($sum);?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?PHP
$script = <<< JS
$('document').ready(function()
{
	$('#button').on('click',function()
	{
		var date = $('#fetch_date').val();
		if(date == "")
		{
			$('#fetch_date').css("border","1px dotted red");
			$('#fetch_date').focus();
			return false;
		}
		// window.location = "index.php?r=payment/daily-report?date="+date;
		
	})
})

JS;
$this->registerJs($script);
?>