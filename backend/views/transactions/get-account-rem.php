<?PHP
use common\models\SaleInvoiceHead;
use common\models\PurchaseInvoice;
use yii\helpers\Json;
if(isset($_POST['end_date']))
{
	$end_date = $_POST['end_date'];
    $date = strtotime($end_date .' -5 months');
    $start_date=date('Y-m-d', $date);
    $end_date = date('Y-m-31',strtotime($end_date));
 	$debit_transactions = SaleInvoiceHead::find()->where(['between', 'date', "$start_date", "$end_date"])->sum('remaining_amount');
 	$credit_transactions = PurchaseInvoice::find()->where(['between', 'purchase_date', "$start_date", "$end_date"])->sum('remaining_amount');
 	$arr = ['acc_rec' => $debit_transactions , 'acc_pay'=> $credit_transactions];
 	echo Json::encode($arr);
}
else if(isset($_POST['year']))
{
	$year = $_POST['year'];
	$start_date = $year .'-01-01';
	$end_date = $year . '-12-31';
	$debit_transactions = SaleInvoiceHead::find()->where(['between', 'date', "$start_date", "$end_date"])->sum('remaining_amount');
	$credit_transactions = PurchaseInvoice::find()->where(['between', 'purchase_date', "$start_date", "$end_date"])->sum('remaining_amount');
 	$arr = ['acc_rec' => $debit_transactions , 'acc_pay'=> $credit_transactions];
 	echo Json::encode($arr);
}

?>