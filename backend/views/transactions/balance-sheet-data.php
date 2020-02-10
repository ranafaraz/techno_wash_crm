<?php 
	use common\models\AccountNature;
	use common\models\Transactions;
	use common\models\AccountTitle;
	use yii\helpers\Json;
	use common\models\AccountHead;

?>
<?PHP
if(isset($_POST['end_date']))
{
	$retundata = '';
	$retundata1 = '';
	$end_date = $_POST['end_date'];
	$date = strtotime($end_date .' -5 months');
	$start_date=date('Y-m-d', $date);
 	$end_date = date('Y-m-31',strtotime($end_date));
	$account_nature_earning_query = AccountNature::find()->where(['name' =>'Asset'])->One();
	$account_head_earning_query = AccountHead::find()->where(['account_name' => 'Cash'])->all();
	$sum1=0;
	$retundata.='<div class="row text-center" style="margin-top:5px !important;margin-bottom:5px !important;"><div class="col-md-12 bg-success"><h4 class="text-info font-wight-bold;margin-top:20px;">Income Statement (6 Months Report)   '.$start_date.' -- '.$end_date.'</h4></div></div>';
	$retundata.='<div class="row" id="show-record">
							<div class="col-md-1">
								<img src="images/cargo.png" height="80px" width="80px">
							</div>
							<div class="col-md-9 text-center">
								<h3 style="text-align:center;" class="float-left">AZAAD AWAN Trailer Service Private LTD.</h3>
								<small >Chowk Bahadurpur | Rahim Yar Khan</small>
							</div>';
		$retundata.='<div class="row">
						<div class="col-md-12">
						<h2 class="text-success" style="font-weight:bold"><u>Revenues</u></h2>
						<table class="table table-responsive text-center">';
	if(isset($account_head_earning_query))
	{ 

		foreach ($account_head_earning_query as $value) {
			$sdate = date('Y-m-d', strtotime($start_date));
			$edate = date('Y-m-30', strtotime($end_date));
			$transaction_query = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["debit_account" => $value->id])->all();
			$sum = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["debit_account" => $value->id])->sum('amount');

			if(isset($transaction_query))
			{
				foreach ($transaction_query as $value1) {
					$account_head = AccountHead::find()->where(['id' => $value1->credit_account])->One();
					$retundata.= '<tr><th class="text-center">'.$account_head->account_name.'</td>';
					break;
				}
				
			}
			$retundata.= '<th>'.$sum.'<th></tr>';
			$sum1 = $sum1 + $sum ;
		}
		
		$retundata.='<tr><td colspan="3"><hr style="border:1px dotted green"></td></tr><tr><th>Total</th><th>'.number_format($sum1).'</th></tr></table></div></div>';
	}
	$account_nature_expense_query = AccountNature::find()->where(['name' =>'Expense'])->One();
	$account_head_expense_query = AccountHead::find()->where(['account_name' => 'Cash'])->all();
	$sum1_exp=0;
	$retundata.='<div class="row">
						<div class="col-md-12">
					<h2 class="text-success" style="font-weight:bold"><u>Expenses</u></h2>
					<table class="table table-responsive text-center">';
	if(isset($account_head_expense_query))
	{

		foreach ($account_head_expense_query as $value2) {
			$sdate = date('Y-m-d', strtotime($start_date));
			$edate = date('Y-m-30', strtotime($end_date));
			$transaction_exp_query = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["credit_account" => $value2->id])->all();
			$sum_exp = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["credit_account" => $value2->id])->sum('amount');
			if(isset($transaction_exp_query))
			{
				foreach ($transaction_exp_query as $value3) {
					$account_head = AccountHead::find()->where(['id' => $value3->debit_account])->One();
					$retundata.= '<tr><th class="text-center">'.$account_head->account_name.'</td>';
					break;
				}
				
			}
			$retundata.= '<th>'.$sum_exp.'<th></tr>';
			$sum1_exp = $sum1_exp + $sum_exp ;
		}
		
		$retundata.='<tr><td colspan="3"><hr style="border:1px dotted green"></td></tr><tr><th>Total</th><th>'.number_format($sum1_exp).'</th></tr></table></div></div>';
	}
	$retundata.='</div>';
	$sum_income = $sum1 - $sum1_exp;
	echo $sum_income;
}else if(isset($_POST['year']))
{

	$retundata = '';
	$retundata1 = '';
	$year = $_POST['year'];
	$start_date=date($year.'-'.'01'.'-'.'01');
	$end_date = date($year.'-'.'12'.'-'.'31');
	$account_nature_earning_query = AccountNature::find()->where(['name' =>'Asset'])->One();
	$account_head_earning_query = AccountHead::find()->where(['account_name' => 'Cash'])->all();
	$sum1=0;

		$retundata.='<div class="row" id="show-record"><div class="row text-center" style="margin-top:5px !important;margin-bottom:5px !important;"><div class="col-md-12 bg-success"><h4 class="text-info font-wight-bold;margin-top:20px;">Income Statement (Yearly Report <b class="text-warning">'.$year.'</b>)</h4></div></div>';
	$retundata.='
							<div class="col-md-1">
								<img src="images/cargo.png" height="80px" width="80px">
							</div>
							<div class="col-md-11 text-center">
								<h3 style="text-align:center;" class="float-left"><h1><b style="color:#FAB61C">TECHNO</b><b style="color:White">WASH</b></h1>.</h3>
								
							</div>';
		$retundata.='<div class="row">
						<div class="col-md-12">
							<table class="table table-responsive table-borderd">
							<tr class="text-left"><th><h3>Revenues</h3></th></tr>';
	if(isset($account_head_earning_query))
	{ 

		foreach ($account_head_earning_query as $value) {
			$sdate = date('Y-m-d', strtotime($start_date));
			$edate = date('Y-m-30', strtotime($end_date));
			$transaction_query = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["debit_account" => $value->id])->all();
			$sum = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["debit_account" => $value->id])->sum('amount');
			if(isset($transaction_query))
			{
				foreach ($transaction_query as $value1) {
					$account_head = AccountHead::find()->where(['id' => $value1->credit_account])->One();
					$retundata.= '<tr><th class="text-center">'.$account_head->account_name.'</th>';
					break;
				}
				
			}
			$retundata.= '<th>'.$sum.'<th></tr>';
			$sum1 = $sum1 + $sum ;
		}
		
		$retundata.='<tr><td colspan="3"></td></tr><tr><th class="text-center">Total</th><th>'.number_format($sum1).'</th></tr>';
	}
	$account_nature_expense_query = AccountNature::find()->where(['name' =>'Expense'])->One();
	$account_head_expense_query = AccountHead::find()->where(['account_name' =>'Cash'])->all();
	$sum1_exp =0;
	$retundata.='<tr class="text-left"><th colspan="2"><h3>Expense</h3></th></tr>';
	if(isset($account_head_expense_query))
	{

		foreach ($account_head_expense_query as $value2) {
			$sdate = date('Y-m-d', strtotime($start_date));
			$edate = date('Y-m-30', strtotime($end_date));
			$transaction_exp_query = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["credit_account" => $value2->id])->all();
			$sum_exp = Transactions::find()->where(["between","transactions_date" , $sdate , $edate])->andwhere(["credit_account" => $value2->id])->sum('amount');
			if(isset($transaction_exp_query))
			{
				foreach ($transaction_exp_query as $value3) {
					$account_head = AccountHead::find()->where(['id' => $value3->credit_account])->One();
					$retundata.= '<tr><th class="text-center">'.$account_head->account_name.'</th>';
					break;
				}
				
			}
			$retundata.= '<th class="">'.$sum_exp.'<th></tr>';
			$sum1_exp = $sum1_exp + $sum_exp ;
		}
		
		$retundata.='<tr><td colspan="3"><hr style="border:1px dotted green"></td></tr><tr><th class="text-center">Total</th><th>'.number_format($sum1_exp).'</th></tr></table></div></div>';
	}
	$sum_income = $sum1 - $sum1_exp;
	echo $sum_income;
}

?>