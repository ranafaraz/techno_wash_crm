
<?php 
$paidID = $_GET['paid_id'];
$paidinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE sale_inv_head_id = '$paidID' AND (status = 'paid' OR status = 'Paid')
    ")->queryAll();
    $customerID = $paidinvoiceData[0]['customer_id'];

$customervehicleID = Yii::$app->db->createCommand("
    SELECT DISTINCT(sid.customer_vehicle_id)
    FROM sale_invoice_head as sih
    INNER JOIN sale_invoice_detail as sid
    ON sih.sale_inv_head_id = sid.sale_inv_head_id
    WHERE sih.customer_id = '$customerID'
    ")->queryAll();
    $countcustomervehicleID = count($customervehicleID);

    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Paid Sale Invoice</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">	
			<h3 class="text-center"><b style="color: #FAB61C;">TECHNO</b> WASH</h3>			
			
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			
			<tbody>
				<tr>
					<th style="background-color: #3C8DBC;color: white;">Name:</th>
					<td></td>
					<th style="background-color: #3C8DBC;color: white;">Vehicle:</th>
					<td></td>
				</tr>
				<tr>
					<th style="background-color: #3C8DBC;color: white;">Invoice:</th>
					<td></td>
					<th style="background-color: #3C8DBC;color: white;">Date:</th>
					<td></td>

				</tr>
				</tbody>
			</table>
		</div>
			<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<?php for($i=0; $i<$countcustomervehicleID; $i++)
    				{

    		?>
		
    
				<thead style="background-color: #3C8DBC;color: white;">
					<tr>
						<th style="max-width: 10px;">Sr#</th>
						<th>ITEM/SERVICE</th>
						<th>QUANTITY</th>
						<th>PRICE</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>

					<tr>
						<td>
						<?php  ?>							
						</td>
						<td>
							
						</td>
						<td></td>
						<td>
						</td>
						<td></td>
					</tr>
					
	
					<tr>
						<td>
						</td>
						<th style="background-color: lightgray;">
							GRAND TOTAL:
						</th>
						<td style="background-color: lightgray;">
							<!-- &emsp;&emsp;PKR -->
						</td>
					</tr>
				</tbody>
				<?php } ?>			
		</table>
		
		</div>
	   </div>		
	  </div>		
	</div>

</body>
</html>