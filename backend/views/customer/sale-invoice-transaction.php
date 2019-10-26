<?php 

if (isset($_GET['saleinvheadID']) && isset($_GET['customerid'])) {
$saleinvHeadID = $_GET['saleinvheadID'];
$customerid = $_GET['customerid'];

$updateinvoiceData = Yii::$app->db->createCommand("
SELECT *
FROM sale_invoice_head as sih
INNER JOIN sale_invoice_amount_detail as siad
ON sih.sale_inv_head_id = siad.sale_inv_head_id
WHERE sih.sale_inv_head_id = '$saleinvHeadID'
AND siad.sale_inv_head_id = '$customerid'
")->queryAll();


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<table class="table table-bordered">
				<thead>
					<th>Sr.#</th>
					<th>Date</th>
					<th>Amount</th>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>