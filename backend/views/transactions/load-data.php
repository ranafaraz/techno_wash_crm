<?php 
	use common\models\RouteVoucherHead;
	use common\models\RouteVoucherEmployee;
	use common\models\RouteVoucherDetails;
	use common\models\FuelConsumption;
	use common\models\Cities;
	use common\models\Transactions;
	use common\models\AccountTitle;
	use yii\helpers\Json;
	use common\models\AccountHead;

?>
<?PHP
$returndata = "";
$i=0;
$arr=[];
if (isset($_POST['date']) && isset($_POST['title'])){

		$date = $_POST['date'];
		$title= $_POST['title'];
		$acc_title = AccountTitle::find()->where(['id' => $title])->One();
		if(isset($acc_title))
		{
		$head_query = AccountHead::find()->orderBy(['id'=>SORT_DESC])->all(); 
		if(isset($head_query))
		{
			$returndata.='<div class="row text-center" style="margin-top:5px !important;margin-bottom:5px !important;"><div class="col-md-12 bg-success"><h4 class="text-info font-wight-bold">Showing Report Against Date: ' .$date.'</h4> <b class="text-danger">Account</b>: ' .$acc_title->title_name.'</div></div>';
			$returndata.='<div class="row">
							<div class="col-md-2">
								<img src="images/cargo.png" height="80px" width="80px">
							</div>
							<div class="col-md-7 text-center">
								<h3 style="text-align:center;" class="float-left">AZAAD AWAN Trailer Service Private LTD.</h3>
								<small >Chowk Bahadurpur | Rahim Yar Khan</small>
							</div>
						</div>';
			foreach ($head_query as $val) {
			$returndata.='<div class="col-md-4" style="display:none !important" style="padding: 10px;height:auto !important;">
				<table class="table table-reponsive table-striped table-borderd tbale-hover" value="'.$id = $val->id.'" id="'.  $val->account_name.'">
					<thead>
						<th class="font-wight-bold text-center">'. $val->account_name.'</th>
					</thead>
					<tbody>
						<tr>
							<th class="text-left text-dark bg-success">Debit</th>
						</tr>'; 
						$sum_credit=0;
						$sum_debit=0;
							$debit_transactions = Transactions::find()->where(["transactions_date" => $date])->andwhere(["debit_account" => $id])->andwhere(['account_title_id' => $acc_title->id])->all();
							$credit_transactions = Transactions::find()->where(["transactions_date" => $date])->andwhere(["credit_account" => $id])->andwhere(['account_title_id' => $acc_title->id])->all();
							foreach($debit_transactions as $val1)
							{
								$head_model_credit = AccountHead::find()->where(["id" => $val1->credit_account])->One();
								$sum_debit = $sum_debit + $val1->credit_amount;
						
								$returndata.='<tr>
									<td><h5 class="text-left">'. $head_model_credit->account_name.'</h5><h5 class="text-right">'.number_format($val1->credit_amount).'</h5></td>
								</tr>';
							}
							$returndata.='<tr>
								<th class="text-left" style="color:white;background-color: black">Credit</th>
							</tr>';
							$amount_cradit=0;
							
							foreach ($credit_transactions as  $val2) {

								$head_model_debit = AccountHead::find()->where(["id" => $val2->debit_account])->One();
								$sum_credit = $sum_credit + $val2->credit_amount;
							$returndata.='
							<tr>
								<td><h5 class="text-left">'. $head_model_debit->account_name.'</h5><h5 class="text-right">'.number_format($val2->credit_amount).'</h5></td>
							</tr>';
							}

							if(empty($sum_credit) && empty($sum_debit))
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Balance Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}else
							if($sum_credit > $sum_debit)
							{
								$balance_caried_down = (int)$sum_credit - (int)$sum_debit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Debit" , "amount" => $balance_caried_down];
							
								$returndata.='<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Debit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							elseif($sum_debit > $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							elseif($sum_debit == $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							$i=$i+1;
							$returndata.='
					</tbody>
				</table>
			</div>';
			}
		}
	}
}else
if(isset($_POST['month_date']) && isset($_POST['title']))
{
		$month = $_POST['month_date'];
		$start_date = date('Y-m-1',strtotime($month));
		$end_date = date('Y-m-t',strtotime($month));
		$title= $_POST['title'];
		$acc_title = AccountTitle::find()->where(['id' => $title])->One();
		if(isset($acc_title))
		{
		$head_query = AccountHead::find()->orderBy(['id'=>SORT_DESC])->all(); 
		if(isset($head_query))
		{
			$returndata.='<div class="row text-center" style="margin-top:5px !important;margin-bottom:5px !important;"><div class="col-md-12 bg-success"><h4 class="text-info font-wight-bold">Showing Report Against Month: ' .date('M-Y',strtotime($month)).'</h4>
						<b class="text-danger">Account</b>: ' .$acc_title->title_name.'</div></div>';
			$returndata.='<div class="row">
							<div class="col-md-2">
								<img src="images/cargo.png" height="80px" width="80px">
							</div>
							<div class="col-md-7 text-center">
								<h3 style="text-align:center;" class="float-left">AZAAD AWAN Trailer Service Private LTD.</h3>
								<small >Chowk Bahadurpur | Rahim Yar Khan</small>
							</div>
						</div>';
			foreach ($head_query as $val) {
			$returndata.='<div class="col-md-4" style="display:none !important" style="padding: 10px;height:auto !important;">
				<table class="table table-reponsive table-striped table-borderd tbale-hover" value="'.$id = $val->id.'" id="'.  $val->account_name.'">
					<thead>
						<th class="font-wight-bold text-center">'. $val->account_name.'</th>
					</thead>
					<tbody>
						<tr>
							<th class="text-left text-dark bg-success">Debit</th>
						</tr>'; 
						$sum_credit=0;
						$sum_debit=0;
							$debit_transactions = Transactions::find()->where(['between', 'transactions_date', "$start_date", "$end_date"])->andwhere(["debit_account" => $id])->andwhere(['account_title_id' => $acc_title->id])->all();
							$credit_transactions = Transactions::find()->where(['between', 'transactions_date', "$start_date", "$end_date"])->andwhere(["credit_account" => $id])->andwhere(['account_title_id' => $acc_title->id])->all();
							foreach($debit_transactions as $val1)
							{
								$head_model_credit = AccountHead::find()->where(["id" => $val1->credit_account])->One();
								$sum_debit = $sum_debit + $val1->credit_amount;
						
								$returndata.='<tr>
									<td><h5 class="text-left">'. $head_model_credit->account_name.'</h5><h5 class="text-right">'.number_format($val1->credit_amount).'</h5></td>
								</tr>';
							}
							$returndata.='<tr>
								<th class="text-left" style="color:white;background-color: black">Credit</th>
							</tr>';
							$amount_cradit=0;
							
							foreach ($credit_transactions as  $val2) {

								$head_model_debit = AccountHead::find()->where(["id" => $val2->debit_account])->One();
								$sum_credit = $sum_credit + $val2->credit_amount;
							$returndata.='
							<tr>
								<td><h5 class="text-left">'. $head_model_debit->account_name.'</h5><h5 class="text-right">'.number_format($val2->credit_amount).'</h5></td>
							</tr>';
							}

							if(empty($sum_credit) && empty($sum_debit))
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Balance Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}else
							if($sum_credit > $sum_debit)
							{
								$balance_caried_down = (int)$sum_credit - (int)$sum_debit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Debit" , "amount" => $balance_caried_down];
							
								$returndata.='<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Debit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							elseif($sum_debit > $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							elseif($sum_debit == $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							$i=$i+1;
							$returndata.='
					</tbody>
				</table>
			</div>';
			}
		}
	}
}else
if(isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['title']))
{

		$start_date = $_POST['startdate'];
		$end_date =$_POST['enddate'];
		$title= $_POST['title'];
		$acc_title = AccountTitle::find()->where(['id' => $title])->One();
		if(isset($acc_title))
		{
		$head_query = AccountHead::find()->orderBy(['id'=>SORT_DESC])->all(); 
		if(isset($head_query))
		{
			$returndata.='<div class="row text-center" style="margin-top:5px !important;margin-bottom:5px !important;"><div class="col-md-12 bg-success"><h4 class="text-info font-wight-bold">Showing Report Against Date: <b class="text-danger">' .$start_date.'</b> to <b class="text-danger">'.$end_date.'</b></h4>
						Account</b>: ' .$acc_title->title_name.'</div></div>';
			$returndata.='<div class="row">
							<div class="col-md-2">
								<img src="images/cargo.png" height="80px" width="80px">
							</div>
							<div class="col-md-7 text-center">
								<h3 style="text-align:center;" class="float-left">AZAAD AWAN Trailer Service Private LTD.</h3>
								<small >Chowk Bahadurpur | Rahim Yar Khan</small>
							</div>
						</div>';
			foreach ($head_query as $val) {
			$returndata.='<div class="col-md-4" style="display:none !important" style="padding: 10px;height:auto !important;">
				<table class="table table-reponsive table-striped table-borderd tbale-hover" value="'.$id = $val->id.'" id="'.  $val->account_name.'">
					<thead>
						<th class="font-wight-bold text-center">'. $val->account_name.'</th>
					</thead>
					<tbody>
						<tr>
							<th class="text-left text-dark bg-success">Debit</th>
						</tr>'; 
						$sum_credit=0;
						$sum_debit=0;
							$debit_transactions = Transactions::find()->where(['between', 'transactions_date', "$start_date", "$end_date"])->andwhere(["debit_account" => $id])->andwhere(['account_title_id' => $acc_title->id])->all();
							$credit_transactions = Transactions::find()->where(['between', 'transactions_date', "$start_date", "$end_date"])->andwhere(["credit_account" => $id])->andwhere(['account_title_id' => $acc_title->id])->all();
							foreach($debit_transactions as $val1)
							{
								$head_model_credit = AccountHead::find()->where(["id" => $val1->credit_account])->One();
								$sum_debit = $sum_debit + $val1->credit_amount;
						
								$returndata.='<tr>
									<td><h5 class="text-left">'. $head_model_credit->account_name.'</h5><h5 class="text-right">'.number_format($val1->credit_amount).'</h5></td>
								</tr>';
							}
							$returndata.='<tr>
								<th class="text-left" style="color:white;background-color: black">Credit</th>
							</tr>';
							$amount_cradit=0;
							
							foreach ($credit_transactions as  $val2) {

								$head_model_debit = AccountHead::find()->where(["id" => $val2->debit_account])->One();
								$sum_credit = $sum_credit + $val2->credit_amount;
							$returndata.='
							<tr>
								<td><h5 class="text-left">'. $head_model_debit->account_name.'</h5><h5 class="text-right">'.number_format($val2->credit_amount).'</h5></td>
							</tr>';
							}

							if(empty($sum_credit) && empty($sum_debit))
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Balance Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}else
							if($sum_credit > $sum_debit)
							{
								$balance_caried_down = (int)$sum_credit - (int)$sum_debit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Debit" , "amount" => $balance_caried_down];
							
								$returndata.='<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Debit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							elseif($sum_debit > $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							elseif($sum_debit == $sum_credit)
							{
								$balance_caried_down = (int)$sum_debit - (int)$sum_credit;
								$arr[$i] = ["AccountName" => $val->account_name , "nature" => "Credit" , "amount" => $balance_caried_down];
								$returndata.='
								<tr class="" style="font-weight: bold;background-color: crimson !important;color: white !important;"><td><h5>Credit Caried Down : '. number_format($balance_caried_down).'</h5></td></tr>';
							}
							$i=$i+1;
							$returndata.='
					</tbody>
				</table>
			</div>';
			}
		}
	}
}
// $returndata=''; 
// TRAIL BALANCE
$returndata.='<div class="row">
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
					<th>Debit</th>
					<th>Credit</th>
				</tr>
			</thead>
			<tbody>';
				$j=0;
				$sum=0;
				$sum1=0;
					for($j=0;$j<$i;$j++) {
						// echo mysqli_error();
						$returndata.="<tr><td>".$arr[$j]['AccountName']."</td>";
						if($arr[$j]['nature'] == 'Debit')
							{
							 $sum1 = $sum1 + $arr[$j]['amount'];
							$returndata.='<td></td><td>'.number_format($arr[$j]['amount']).'</td>';
							}
							elseif($arr[$j]['nature'] == 'Credit')
							{
							$sum = $sum + $arr[$j]['amount'];
							$returndata.='<td>'.number_format($arr[$j]['amount'])
							.'</td><td></td>';
							}
						$returndata.="</tr>";
					}
				$returndata.='<tr class="bg-danger text-success">
					<td style="font-weight: bold;">Total Amount</td>
					<td  style="font-weight: bold;">'.number_format($sum1).'</td>
					<td style="font-weight: bold;">'. number_format($sum).'</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>';

echo $returndata;
?>
