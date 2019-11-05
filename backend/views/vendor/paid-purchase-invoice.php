<?php 

  if (isset($_GET['piID']) && isset($_GET['vendorID'])) {
	$purchaseInvID = $_GET['piID'];
	$vendorID = $_GET['vendorID'];

	$paidinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice 
    WHERE vendor_id = '$vendorID' 
    AND  purchase_invoice_id = '$purchaseInvID'
    AND (status = 'Paid' OR status = 'paid')
    ")->queryAll();
    $date = date('d-M-Y',strtotime($paidinvoiceData[0]['created_at']));
    $time = date('h:i a',strtotime($paidinvoiceData[0]['created_at']));

    // echo $date."<br>";
    // echo $time;
    
    $vendorId = $paidinvoiceData[0]['vendor_id'];

    $vendorData  = Yii::$app->db->createCommand("
    SELECT name
    FROM vendor
    WHERE vendor_id = '$vendorId'
    ")->queryAll();
    $vendor_name = $vendorData[0]['name'];

    $stockTypeid = Yii::$app->db->createCommand("
    SELECT DISTINCT(stock_type_id)
    FROM stock
    WHERE purchase_invoice_id = '$purchaseInvID'
    ")->queryAll();
    $countstockTypeid = count($stockTypeid);

    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Paid Purchase Invoice</title>
</head>
<body onload="window.print();"  onafterprint="returnBack();">
	<style type="text/css" media="print">
		footer,#print_button{
			display: none;
		}
	</style>
	<div class="container-fluid">
		<!-- <div class="row">
			<div class="col-md-2">
				<a href="./purchase-invoice-view?vendor_id=<?php //echo $vendorID; ?>" class="btn btn-danger btn-flat" style="width: 70%;"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
			</div>
			<div class="col-md-8"></div>
			<div class="col-md-2">
				<button type="button" onclick="printContent('div1')" class="btn btn-warning btn-flat" id="print_button"><i class="glyphicon glyphicon-print"></i> Print Content</button>
			</div>
		</div> -->
		<div id="div1">
			
		
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h3  style="text-align: center;">
						TECHNO WASH
					</h3>
					<p style="text-align: center;">
						Opearted By: Bahawal Vehicle Services<br>9- Railway link road, Bahawalpur<br>Contact #: +92 (300) 060 0106<br>http://www.facebook.com/technowashbwp/
					</p>
					<h3 style="text-align: center;background-color: lightgray !important;padding:10px;">Paid Purchase Memo</h3>
					
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered">
								
								<thead>
									<tr>
										<th style="vertical-align: top;">Name:</th>
										<td style="text-align: center;"><?php echo $vendor_name; ?></td>
										<th>Date</th>							
										<td style="text-align: center;"><?php echo $date; ?></td>
									</tr>
									<tr>
										<th><b>INV #</b></th>
										<td style="text-align: center;"><?php echo $purchaseInvID; ?></td>
										<th>Time</th>
										<td style="text-align: center;"><?php echo $time; ?></td>
									</tr>
								</thead>
								
							</table>
							
							
						</div>
					</div>
					<?php 
						$quantity = 0;
						$totalAmount = 0;
						$totalProducts = 0;
						for ($i=0; $i <$countstockTypeid ; $i++) {
						$stocktypeid = $stockTypeid[$i]['stock_type_id'];

						$stockTypeName = Yii::$app->db->createCommand("
						    SELECT name
						    FROM stock_type
						    WHERE stock_type_id = '$stocktypeid'
						    ")->queryAll();
					 ?>
					<table class="table">
						<thead style="background-color: #3C8DBC !important;color:white;">
							<tr>
								<th colspan="6" style="text-align: center;"> Stock: <i><?php echo $stockTypeName[0]['name'];?> </i> (Bill No. <i><?=$paidinvoiceData[0]['bill_no'];?></i>)</th>
							</tr>
							<tr>
								<th>Sr #</th>
								<th>Product</th>
								<th>Manufacturer</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<?php

							$stockDetails = Yii::$app->db->createCommand("
						    SELECT DISTINCT(name)
						    FROM stock
						    WHERE purchase_invoice_id = '$purchaseInvID'
						    AND stock_type_id = '$stocktypeid'
						    ")->queryAll();
						    $countStockDetails = count($stockDetails);			  

						    for ($j=0; $j <$countStockDetails ; $j++) { 

						    $stockName = $stockDetails[$j]['name'];
						    
						    $stockData = Yii::$app->db->createCommand("
						    SELECT name,purchase_price
						    FROM stock
						    WHERE purchase_invoice_id = '$purchaseInvID'
						    ")->queryAll();

						    $stockCount = Yii::$app->db->createCommand("
						    SELECT *
						    FROM stock
						    WHERE purchase_invoice_id = '$purchaseInvID'
						    AND name = '$stockName'
	 					    ")->queryAll();
	 					    $countStock= count($stockCount);
	 					    $quantity += $countStock;

	 					    $productData = Yii::$app->db->createCommand("
						    SELECT product_name,manufacture_id
						    FROM products
						    WHERE product_id = '$stockName'
	 					    ")->queryAll();
	 					    $countproductData= count($productData);
	 					    $totalProducts += $countproductData;

	 					    $manufactureID = $productData[0]['manufacture_id'];
	 					    $manufacturerName = Yii::$app->db->createCommand("
						    SELECT name
						    FROM manufacture
						    WHERE manufacture_id = '$manufactureID'
						    ")->queryAll();

							?>
							<tr>
								<td style="text-align: center;"><?php echo $j+1; ?></td>
								<td style="text-align: center;"><?php echo $productData[0]['product_name']; ?></td>
								<td style="text-align: center;"><?php echo $manufacturerName[0]['name']; ?></td>
								<td style="text-align: center;"><?php echo $stockData[0]['purchase_price']; ?></td>
								<td style="text-align: center;"><?php echo $countStock; ?></td>
								<td style="text-align: center;">
									<?php echo $total = $stockData[0]['purchase_price']*$countStock; 
									$totalAmount += $total;
									?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>
				<div class="col-sm-6 col-md-offset-3">
					<table class="table table-bordered" >
						<thead>
							<tr>
								<th style="text-align: center;background-color: lightgray;">Total Products: </th>
								<th style="background-color: white;text-align: center;"><?php echo $totalProducts; ?></th>
								<th style="text-align: center;background-color: lightgray;">Total Qty: </th>
								<th style="background-color:white;text-align: center;"><?php echo $quantity; ?></th>
							</tr>
						</thead>
					</table>

				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					
				</div>
				<div class="col-sm-3">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Total Amount</th>
								<th style="text-align: center;"><?php echo $paidinvoiceData[0]['total_amount']; ?></th>
							</tr>
							<tr>
								<th>Invoice Discount</th>
								<th style="text-align: center;"><?php echo $paidinvoiceData[0]['discount']; ?></th>
							</tr>
							<tr>
								<th>Net Bill</th>
								<th style="text-align: center;"><?php echo $paidinvoiceData[0]['net_total']; ?></th>
							</tr>
							<tr>
								<th>Paid</th>
								<th style="text-align: center;"><?php echo $paidinvoiceData[0]['paid_amount']; ?></th>
							</tr>
							<tr>
								<th>Remaining</th>
								<th style="text-align: center;"><?php echo $paidinvoiceData[0]['remaining_amount']; ?></th>
							</tr>
							<tr>
								<th>Status</th>
								<th style="text-align: center;"><?php echo $paidinvoiceData[0]['status']; ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					
				</div>
				<div class="col-md-6">
					<h4 style="text-align: center;background-color: #3C8DBC !important;padding:10px;color: white !important;"><i>Honor To Work With You!</i></h4>
					<p style="text-align: center;">
						<i>IT Consultancy Provoided By:</i>&nbsp;<b>DEXDEVS</b><br>Contact #: +92 (300) 699 9824<br><b>Email: </b><i>info@dexdevs.com</i>
					</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php } ?>
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
function returnBack() {
  window.location='purchase-invoice-view?vendor_id=<?php echo $vendorID; ?>';
}
</script>
