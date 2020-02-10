<?php 
	use common\models\RouteVoucherHead;
	use common\models\RouteVoucherEmployee;
	use common\models\RouteVoucherDetails;
	use common\models\FuelConsumption;
	use common\models\Cities;
	use common\models\Transactions;
	use common\models\AccountNature;
	use yii\helpers\Json;
	use common\models\AccountHead;
?>
<?PHP
$returndata = "";
$i=0;
$arr=[];
if(isset($_POST['sdate']) && isset($_POST['edate']))
{

		$start_date = $_POST['sdate'];
		$end_date =$_POST['edate'];
		$acc_title = AccountNature::find()->where(['name' => 'Asset'])->One();
		if(isset($acc_title))
		{
		$head_query = AccountHead::find()->where(['nature_id'=>$acc_title->id])->andwhere(['account_name' => 'Cash'])->all();
		if(isset($head_query))
		{
			$returndata.='<div class="row">
							<div class="col-md-12"> <tr id="printrow"><td colspan="4" ><button style="float: right;" onclick="printContent(\'show-record\')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Print
								</button></td></tr> </div>
						</div>
						<div class="row" id="show-record">
						<div class="row">
							<div class="col-md-2">
								<img src="images/techno.png" height="80px" width="80px" style="float: left">
							</div>
							<div class="col-md-7 text-center">
								<h3 style="text-align:center;" class="float-left"><h1><b style="color:#FAB61C">TECHNO</b><b style="color:White">WASH</b></h1>.</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="row text-center" style="margin-top:5px !important;margin-bottom:5px !important;"><div class="col-md-12 bg-success"><h4 class="text-info font-wight-bold">Showing Report Against Date: <b class="text-danger" id="s_date"></b> to <b class="text-danger" id="e_date"></b></h4>
												<b>CashBook(Receipts)</b></div></div>
							</div>
						</div>';
			$returndata.='<table style="margin-top:10px !important" class="table table-responsive tbale-bordered table-striped">';
			$returndata.='<tr>
							<th class="text-center text-dark bg-success">sr#</th>
							<th class="text-center text-dark bg-success">TransID</th>
							<th class="text-center text-dark bg-success">Date</th>
							<th class="text-center text-dark bg-success">Type</th>
							<th class="text-center text-dark bg-success">Account Name</th>
							<th class="text-center text-dark bg-success">Narration</th>
							<th class="text-center text-dark bg-success">Payment</th>
							<th class="text-center text-dark bg-success">Bank</th>
						</tr>';
			$sum=0;
			$bank=0;
			foreach ($head_query as $val) {

			// $returndata.='
			// 			<tr><td colspan="2" value="'.$id = $val->id.'" id="'.  $val->account_name.'" class="font-wight-bold text-center">'. $val->account_name.'</td></tr>';
			$sum_credit=0;
			$sum_debit=0;
			$debit_transactions = Transactions::find()->where(['between', 'transactions_date', "$start_date", "$end_date"])->andwhere(["debit_account" => $val->id])->all();
			// $credit_transactions = Transactions::find()->where(['between', 'date', "$start_date", "$end_date"])->andwhere(["credit_account" => $id])->andwhere(['account_title_id' => $acc_title->id])->all();
			$a=0;
			
			foreach($debit_transactions as $val1)
			{
				$a=$a+1;
				$head_model_debit = AccountHead::find()->where(["id" => $val1->debit_account])->One();
				$sum_debit = $sum_debit + $val1->amount;
		
				$returndata.='<tr class="text-center"><td>'.$a.'</td><td>'.$val1->transaction_id.'</td>
				<td>'.$val1->transactions_date.'</td><td>'.$val1->type.'</td>
					<td>'. $head_model_debit->account_name.'</td><td>'.$val1->narration.'</td>';
					if($val1->type == "Cash Payment")
					{
						$sum = $sum + $val1->amount;
						$returndata.='<td>'.number_format($val1->amount).'</td>
						<td>0</td>
						</tr>';
					}
					else if($val1->type == "Bank Payment")
					{
						$bank = $bank + $val1->ebit_amount;
						$returndata.='<td>0</td>
						<td>'.number_format($val1->amount).'</td>
						</tr>';
					}
			}
			}
			$returndata.='<tr class="text-primary"><th colspan="6" class="text-right">Total Receipt</th><th class="text-center">'.number_format($sum).'</th><th class="text-cenetr">'.number_format($bank).'</th></tr></table></div>';
		}
	}
}
echo $returndata;
?>
