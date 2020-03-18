<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css" media="print">
		footer{
			display: none;
		}
		.btn{
			display: none;
		}
		body{
			font-size:18px;
		}
		#footer1{
			color: white;
		}
		#t_border{
			border: 1px solid black;
		}
	</style>
	<style type="text/css">
		table, tr, th, td {
		  border: 1px solid black;
		}
	</style>
</head>
<body>
<?php 

		if(isset($_POST['items_report']))
		{
			$vendor_id  = $_POST['vendorID'];
	   		$branch_id  = $_POST['branchId'];
	   		$items_list = $_POST['items_list'];
	   		if ($items_list == 'All') {

		   		$reportHeader = Yii::$app->db->createCommand("
			    SELECT org.*,b.*
			    FROM organization as org
				INNER JOIN branches as b
				ON b.org_id = org.org_id
				WHERE b.branch_id = '$branch_id'
			    ")->queryAll();

			    $vendorName = Yii::$app->db->createCommand("
			    SELECT *
			    FROM vendor
				WHERE vendor_id = '$vendor_id'
			    ")->queryAll();

			?>
			<div class="row">
				<div class="col-md-12">
					<a href="./purchase-invoice-view?vendor_id=<?php echo $vendor_id; ?>" class="btn btn-xs btn-danger">Back</a>
					<!-- <button type="button" onclick="printContent('print-report')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Print Invoice</button> -->
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
				  		<div class="col-md-4" style="padding:20px;">
				  			<img style="margin-right:auto;margin-left:auto; display: block;" height="40px" src="<?php echo $reportHeader[0]['org_logo']; ?>">
				  		</div>
				  		<div class="col-md-8" style="text-align:left;">
				  			<h2  style="font-weight: bolder;font-family: arial;">
							<?php  echo $reportHeader[0]['org_name']."<br>"; ?>
							</h2>
							<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
								<?php echo $reportHeader[0]['branch_location']; ?>
							</p>
							<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
								<?php echo $reportHeader[0]['branch_contact_no']; ?>
							</p>
							<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
								https://technowashbwp.pk/
							</p>
				  		</div>
				  	</div>
				  	<p style="font-size:20px;font-family:arial;font-weight: bolder;text-align: right;"><?php echo "Vendor : <u>".$vendorName[0]['name']."</u>";?> </p>
				  	<h3 style="text-align: center;background-color:#000000 !important;color:white !important;padding:10px;">Items List
					</h3>
					<table class="table" style="font-family:arial;font-size:25px;">
				        <tbody>
				        	<tr>
					            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Sr #</th>
					            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Items</th>
					            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Total Qty</th>
					            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Sold Qty</th>
					            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Rmaining Qty</th>
				          	</tr>
				          	<?php 
				          		$totalItems = Yii::$app->db->createCommand("
								SELECT DISTINCT(s.name)
								FROM (purchase_invoice as pi
								INNER JOIN stock as s
								ON pi.purchase_invoice_id = s.purchase_invoice_id)
								WHERE pi.vendor_id = '$vendor_id'
								AND s.stock_status = 'Partnership'
							    ")->queryAll();
							    $counttotalItems = count($totalItems);
				          		for ($i=0; $i <$counttotalItems ; $i++) {
				          			$prod_id = $totalItems[$i]['name'];
								    $itemName = Yii::$app->db->createCommand("
								    SELECT *
								    FROM products
									WHERE product_id = '$prod_id'
								    ")->queryAll();

									$totalQty = Yii::$app->db->createCommand("
									SELECT *
									FROM (purchase_invoice as pi
									INNER JOIN stock as s
									ON pi.purchase_invoice_id = s.purchase_invoice_id)
									WHERE pi.vendor_id = '$vendor_id'
									AND s.stock_status = 'Partnership'
									AND s.name = '$prod_id'
								    ")->queryAll();
								    $countTotalIQty = count($totalQty);

								    $soldQty = Yii::$app->db->createCommand("
									SELECT *
									FROM (purchase_invoice as pi
									INNER JOIN stock as s
									ON pi.purchase_invoice_id = s.purchase_invoice_id)
									WHERE pi.vendor_id = '$vendor_id'
									AND s.stock_status = 'Partnership'
									AND s.name = '$prod_id'
									AND s.status = 'Sold'
								    ")->queryAll();
								    $countSoldQty = count($soldQty);
								    $countRemainQty = $countTotalIQty-$countSoldQty;
				          	?>
				          	<tr>
				          		<td style="text-align: center;"><?php echo $i+1; ?></td>
				          		<td><?php echo $itemName[0]['product_name']; ?></td>
				          		<td style="text-align: center;"><?php echo $countTotalIQty; ?></td>
				          		<td style="text-align: center;"><?php echo $countSoldQty; ?></td>
				          		<td style="text-align: center;"><?php echo $countRemainQty; ?></td>
				          	</tr>
				          	<?php } // items loop close ?>
				        </tbody>
				    </table>
				</div>
			</div>
	   		<?php } // closing if of all items
		} // items report isset close
		if(isset($_POST['partnership_report']))
		{
		    $vendor_id  = $_POST['vendorID'];
	   		$branch_id  = $_POST['branchId'];
	   		$start_date = $_POST['start_date'];
	      	$end_date   = $_POST['end_date'];

	      	$reportHeader = Yii::$app->db->createCommand("
		    SELECT org.*,b.*
		    FROM organization as org
			INNER JOIN branches as b
			ON b.org_id = org.org_id
			WHERE b.branch_id = '$branch_id'
		    ")->queryAll();

		    $vendorName = Yii::$app->db->createCommand("
		    SELECT *
		    FROM vendor
			WHERE vendor_id = '$vendor_id'
		    ")->queryAll();

	      	$start_date 	= date('y-m-d',strtotime($start_date));
	      	$end_date 	= date('y-m-d',strtotime($end_date));

	      	$saleDates = Yii::$app->db->createCommand("
			SELECT DISTINCT(sih.date)
			FROM (((purchase_invoice as pi
			INNER JOIN stock as s
			ON pi.purchase_invoice_id = s.purchase_invoice_id)
			INNER JOIN sale_invoice_detail as sid
			ON s.stock_id = sid.item_id)
			INNER JOIN sale_invoice_head as sih
			ON sid.sale_inv_head_id = sih.sale_inv_head_id)
			WHERE DATE(sih.date) >= '$start_date' AND DATE(sih.date) <= '$end_date'
			AND sid.item_type = 'Stock'
			AND pi.vendor_id = '$vendor_id'
		    ")->queryAll();
		    if (!empty($saleDates)) {
		    $countSalesDate = count($saleDates);
		?>
		<div class="row">
			<div class="col-md-12">
				<a href="./purchase-invoice-view?vendor_id=<?php echo $vendor_id; ?>" class="btn btn-xs btn-danger">Back</a>
				<!-- <button type="button" onclick="printContent('print-report')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Print Invoice</button> -->
			</div>
		</div>
	<div class="row">
	  <div class="col-md-12">
	  	<div class="row">
	  		<div class="col-md-4" style="padding:20px;">
	  			<img style="margin-right:auto;margin-left:auto; display: block;" height="40px" src="<?php echo $reportHeader[0]['org_logo']; ?>">
	  		</div>
	  		<div class="col-md-8" style="text-align:left;">
	  			<h2  style="font-weight: bolder;font-family: arial;">
				<?php  echo $reportHeader[0]['org_name']."<br>"; ?>
				</h2>
				<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
					<?php echo $reportHeader[0]['branch_location']; ?>
				</p>
				<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
					<?php echo $reportHeader[0]['branch_contact_no']; ?>
				</p>
				<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
					https://technowashbwp.pk/
				</p>
	  		</div>
	  	</div>
		<p style="font-size:20px;font-family:arial;font-weight: bolder;text-align: right;"><?php echo "Vendor : <u>".$vendorName[0]['name']."</u>";?> </p>
		<h3 style="text-align: center;background-color:#000000 !important;color:white !important;padding:10px;">Partner Sales Report ( From : <?php echo $startdate = date('d-M-Y',strtotime($start_date))." To ".$enddate = date('d-M-Y',strtotime($end_date)); ?> )
		</h3>
		<div>
	      <table class="table" style="font-family:arial;font-size:25px;">
	        <tbody>
	        	<tr>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Sr #</th>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Items</th>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Sold Qty</th>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">P.P</th>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">S.P</th>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Total Profit</th>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Partner</th>
		            <th id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;">Techno</th>
	          	</tr><br>
	        	<?php 
	        		$qtySum = 0;
	        		$pPSum = 0;
	        		$sPSum = 0;
	        		$profitSum = 0;
	          		$totalPartnerAmount = 0;
	          		$totalTechnoAmount = 0;
	        		for ($i=0; $i <$countSalesDate ; $i++) {
	        		$sale_date = date('d-M-Y',strtotime($saleDates[$i]['date']));
	        		$saleDateDb = $saleDates[$i]['date'];
	        		$saleItems = Yii::$app->db->createCommand("
					SELECT DISTINCT(s.name)
					FROM (((purchase_invoice as pi
					INNER JOIN stock as s
					ON pi.purchase_invoice_id = s.purchase_invoice_id)
					INNER JOIN sale_invoice_detail as sid
					ON s.stock_id = sid.item_id)
					INNER JOIN sale_invoice_head as sih
					ON sid.sale_inv_head_id = sih.sale_inv_head_id)
					WHERE DATE(sih.date) = '$saleDateDb'
					AND sid.item_type = 'Stock'
					AND pi.vendor_id = '$vendor_id'
				    ")->queryAll();
				    $countSalesItems = count($saleItems);
				   
	        	?>
	        	<tr>
	        		<td id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;font-weight:bolder;" colspan="2">
	        			<?php
	        			echo $sale_date;
	        			?>
	        		</td>
	        		<td colspan="6">
	        			Datewise Items Detail
	        		</td>
	        	</tr>
	          	<?php 
	          		for ($j=0; $j <$countSalesItems ; $j++) { 

	          		$prod_id = $saleItems[$j]['name'];

				    $itemName = Yii::$app->db->createCommand("
				    SELECT *
				    FROM products
					WHERE product_id = '$prod_id'
				    ")->queryAll();

				    $totalItems = Yii::$app->db->createCommand("
					SELECT *
					FROM (purchase_invoice as pi
					INNER JOIN stock as s
					ON pi.purchase_invoice_id = s.purchase_invoice_id)
					WHERE pi.vendor_id = '$vendor_id'
					AND s.stock_status = 'Partnership'
				    ")->queryAll();
				    $counttotalItems = count($totalItems);

				    $soldItems = Yii::$app->db->createCommand("
					SELECT *
					FROM (((purchase_invoice as pi
					INNER JOIN stock as s
					ON pi.purchase_invoice_id = s.purchase_invoice_id)
					INNER JOIN sale_invoice_detail as sid
					ON s.stock_id = sid.item_id)
					INNER JOIN sale_invoice_head as sih
					ON sid.sale_inv_head_id = sih.sale_inv_head_id)
					WHERE DATE(sih.date) = '$saleDateDb'
					AND sid.item_type = 'Stock'
					AND pi.vendor_id = '$vendor_id'
					AND s.name = '$prod_id'
					AND s.stock_status = 'Partnership'
					AND s.status = 'Sold'
				    ")->queryAll();
				    $countsoldItems = count($soldItems);
	          	?>
	          	<tr>
	          		<td id="t_border" style="text-align: center;background-color:lightgray !important;border-top:1px solid;"><?php echo $j+1; ?></td>
	          		<td><?php echo $itemName[0]['product_name'];?></td>
	          		<td id="t_border" style="text-align: center;border-top:1px solid;"><?php echo $countsoldItems;?></td>
	          		<td id="t_border" style="text-align: center;border-top:1px solid;"><?php
	          		$totalPp = $countsoldItems*$soldItems[0]['purchase_price'];
	          		 echo $countsoldItems."*".$soldItems[0]['purchase_price']."=".$totalPp;?></td>
	          		<td id="t_border" style="text-align: center;border-top:1px solid;"><?php
	          		$totalSp = $countsoldItems*$soldItems[0]['selling_price'];
	          		 echo $countsoldItems."*".$soldItems[0]['selling_price']."=".$totalSp;?></td>
	          		<td id="t_border" style="text-align: center;border-top:1px solid;">
	          			<?php 
	          			$perItemProfit = $totalSp-$totalPp;
	          			echo $perItemProfit."*".$countsoldItems."=".$perItemProfit*$countsoldItems;
	          			$totalProfit = $perItemProfit*$countsoldItems;
	          			$divideProfit = $totalProfit/2;
	          			$partnerAmount = $countsoldItems*$soldItems[0]['purchase_price']+$divideProfit;
	          			?>
	          		</td>
	          		<td id="t_border" style="text-align: center;border-top:1px solid;">
	          			<?php echo $countsoldItems*$soldItems[0]['purchase_price']."+".$divideProfit."=".$partnerAmount; ?>
	          		</td>
	          		<td id="t_border" style="text-align: center;border-top:1px solid;">
	          			<?php echo $divideProfit; 
	          			$totalTechnoAmount+=$divideProfit;
	          			$totalPartnerAmount+=$partnerAmount;
	          			$qtySum+=$countsoldItems;
	          			$pPSum+=$totalPp;
	          			$sPSum+=$totalSp;
	          			$profitSum+=$totalProfit;
	          			?>
	          		</td>
	          	</tr>
	        	<?php 
	        			} // item loop closed 
	        		} // date loop closed ?>
	        		<tr>
	        			<td colspan="2" style="text-align: center;font-weight: bolder;">Total</td>
	        			<td style="text-align: center;font-weight: bolder;background-color:lightgray !important;"><?php echo $qtySum; ?></td>
	        			<td style="text-align: center;font-weight: bolder;background-color:lightgray !important;"><?php echo $pPSum; ?></td>
	        			<td style="text-align: center;font-weight: bolder;background-color:lightgray !important;"><?php echo $sPSum; ?></td>
	        			<td style="text-align: center;font-weight: bolder;background-color:lightgray !important;"><?php echo $profitSum; ?></td>
	        			<td style="text-align: center;font-weight: bolder;background-color:lightgray !important;border:3px solid;"><?php echo $totalPartnerAmount;  ?></td>
	        			<td style="text-align: center;font-weight: bolder;background-color:lightgray !important;border:3px solid;"><?php echo $totalTechnoAmount;  ?></td>
	        		</tr>
	        		
	        	<?php 
	    		} else{ // closing of dates if?>
	    			<div class="row">
						<div class="col-md-12">
							<a href="./purchase-invoice-view?vendor_id=<?php echo $vendor_id; ?>" class="btn btn-xs btn-danger">Back</a>
							<!-- <button type="button" onclick="printContent('print-report')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-print"></i> Print Invoice</button> -->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="row">
						  		<div class="col-md-4" style="padding:20px;">
						  			<img style="margin-right:auto;margin-left:auto; display: block;" height="40px" src="<?php echo $reportHeader[0]['org_logo']; ?>">
						  		</div>
						  		<div class="col-md-8" style="text-align:left;">
						  			<h2  style="font-weight: bolder;font-family: arial;">
									<?php  echo $reportHeader[0]['org_name']."<br>"; ?>
									</h2>
									<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
										<?php echo $reportHeader[0]['branch_location']; ?>
									</p>
									<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
										<?php echo $reportHeader[0]['branch_contact_no']; ?>
									</p>
									<p style="text-align: left;font-weight: bolder;font-family: arial;font-size:20px;">
										https://technowashbwp.pk/
									</p>
						  		</div>
						  	</div>
							<p style="font-size:20px;font-family:arial;font-weight: bolder;text-align: right;"><?php echo "Vendor : <u>".$vendorName[0]['name']."</u>";?> </p>
							<h3 style="text-align: center;background-color:#000000 !important;color:white !important;padding:10px;">Partner Sale Report ( From : <?php echo $startdate = date('d-M-Y',strtotime($start_date))." To ".$enddate = date('d-M-Y',strtotime($end_date)); ?> )
							</h3>
							<h1 style="text-align: center;font-family: arial;margin-top:10px;">No Sale Yet</h1>
						</div>
					</div>
	    		<?php } // closing of else ?>
	        </tbody>
	      </table>
	    </div>
	  </div>
	</div>
<?php } ?>
</body>
</html>
<script type="text/javascript">
// 	function printContent(el){
// 	var restorepage = document.body.innerHTML;
// 	var printcontent = document.getElementById(el).innerHTML;
// 	document.body.innerHTML = printcontent;
// 	window.print();
// 	document.body.innerHTML = restorepage;
// }
</script>