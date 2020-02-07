<?php 

	use common\models\Transactions;
	use common\models\AccountNature;
	use yii\helpers\Json;
	use common\models\AccountHead;
?>
<?PHP
$branchId = Yii::$app->user->identity->branch_id;

if(isset($_POST['sdate']) && isset($_POST['edate']))
{

		$start_date = $_POST['sdate'];
		$end_date =$_POST['edate'];

		$transactionDEtails = Yii::$app->db->createCommand("
		SELECT *
		FROM transactions
		WHERE amount != 0
		AND transactions_date >= '$start_date' AND transactions_date <= '$end_date'
		AND branch_id = '$branchId'
		")->queryAll();
		$accountName = array();
		foreach ($transactionDEtails as $key => $value) {
			$accountId = $value['debit_account'];
			$accountHead = Yii::$app->db->createCommand("
			SELECT *
			FROM account_head
			WHERE id = '$accountId'
			")->queryAll();
			$accountName[] = $accountHead[0]['account_name'];

		}
		 	$obj = (object) array($transactionDEtails,$accountName);
 			echo json_encode($obj);
	}
?>
