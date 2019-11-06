<?php 
use common\models\Customer; 
use common\models\Branches;
use yii\helpers\Html;

$stockTypeID = $_GET['id'];
if(isset($_POST['insert_product']))
 {
	$manufactureId  = $_POST['manufacture_id'];
	$productName  = $_POST['product_name'];
	$productDescription  = $_POST['product_description'];
	$user_id   =Yii::$app->user->identity->id;
	$count = count($productName);
	for($i=0; $i<$count; $i++){
		if(!empty($productName[$i])){
			$manufacture = $manufactureId[$i];
			$proName = $productName[$i];
			$proDescription = $productDescription[$i];
			 // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $insert_model = Yii::$app->db->createCommand()->insert('products',[
     'manufacture_id'      => $manufacture,
     'product_name'      		=> $proName,
     'description'      		=> $proDescription,
     'created_at' 		=> new \yii\db\Expression('NOW()'),
     'updated_at' 		=> '0',
     'created_by'       => $user_id,
	 'updated_by' 		=> '0',
    ])->execute();
     // transaction commit
     $transaction->commit();
    Yii::$app->session->setFlash('success', "Product added successfuly");
        
     } // closing of try block 
     catch (Exception $e) {
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
		}
	}		
}

// getting stock Type name
$stockTypeName = Yii::$app->db->createCommand("
SELECT name
FROM  stock_type
WHERE stock_type_id = $stockTypeID
")->queryAll();

// getting manufactures name
$manufactureData = Yii::$app->db->createCommand("
SELECT *
FROM  manufacture
WHERE stock_type_id = $stockTypeID
")->queryAll();
$countManufactureData = count($manufactureData);


// $this->title = 'Customer Profile';
// $this->params['breadcrumbs'][] = $this->title;

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-9" style="margin-top: -20px">

      <h2 style="color:#3C8DBC;">
      	<a href="./stock-type" class="btn btn-success">
      		<i class="glyphicon glyphicon-backward"> <b>Back</b></i>
		</a>
				&ensp;<?php echo "Stock Type: ".$stockTypeName[0]['name']; ?>
      	<!-- <a href="./update-stock" class="btn btn-info btn-xs" style="">
				<i class="glyphicon glyphicon-edit"></i>  Update Stock
			</a> -->
      </h2>
    </div>
  </div>
  <div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="nav-tabs-custom">
			            <ul class="nav nav-tabs">
			            	<?php 
									for ($i=0; $i <$countManufactureData ; $i++) { 
									$manufactureName = $manufactureData[$i]['name'];
									$manufactureID = $manufactureData[$i]['manufacture_id'];
								?>
				              	<li>
				              	<a href="#<?php echo $manufactureID; ?>" data-toggle="tab">
				              		<?php echo $manufactureName; ?>
				              	</a>
				              	</li>
			            	<?php } ?>
			            </ul>
			           
			            <div class="tab-content" style="background-color:#EFEFEF;">
			            	 <?php 
									for ($i=0; $i <$countManufactureData ; $i++) { 
									$manufactureName = $manufactureData[$i]['name'];
									$manufactureID = $manufactureData[$i]['manufacture_id'];
									//getting products
									$productData = Yii::$app->db->createCommand("
									SELECT *
									FROM  products
									WHERE manufacture_id = $manufactureID
									")->queryAll();

									$countProducts = count($productData);


									?>
					            <div class="tab-pane" id="<?php echo $manufactureID; ?>">
					               <div class="row">
					               	<div class="col-md-2">
					               		 <p style="color:#3C8DBC;font-size:20px;"><?php echo $manufactureName; ?>
					               		 </p>
					               	</div>
					               	<form action="" method="POST" accept-charset="utf-8">
					               	<div class="col-md-1">
				               			<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">

				               			<input type="hidden" name="manufacture_id[]" id="manufactureID" class="form-control" value="<?php echo $manufactureID; ?>">

				               			<label class="pull-right">Product Name</label>
				               		</div>
					               	<div class="col-md-3">
					               		<div class="form-group">
											<input type="text" name="product_name[]" id="productName" class="form-control">
										</div>
					               	</div>
					               	<div class="col-md-1">
					               		<label>Product Description</label>
					               	</div>
					               	<div class="col-md-3">
					               		<div class="form-group">
											<input type="text" name="product_description[]" id="productDescription" class="form-control">
										</div>
					               	</div>
					               	<div class="col-md-2">
					               		<button type="submit" name="insert_product" id="insert_btn" class="btn btn-success glyphicon glyphicon-plus"> Add Product</button>
					               	</div>
					               	</form>
					               </div>
					               <div class="row">
					               	<div class="col-md-12">
					               		<table class="table table-bordered">
					               			<thead>
					               				<tr style="background-color:#3C8DBC;">
					               					<th rowspan="2" style="vertical-align:middle;text-align: center;color:white;">Sr.#
					               					</th>
					               					<th rowspan="2" style="vertical-align:middle;text-align: center;color:white;">Products
					               					</th>
					               					<th colspan="6" style="text-align: center;color:white;">
					               					Status
					               					</th>
					               				</tr>
					               				<tr>
					               					<th style="text-align: center;background-color: white;">In-Stock</th>
					               					<th style="text-align: center;background-color: white;">Sold</th>
					               					<th style="text-align: center;background-color: white;">Damaged</th>
					               					<!-- <th style="text-align: center;background-color: white;">Repair</th>
					               					<th style="text-align: center;background-color: white;">Expired</th> -->
					               					<th style="text-align: center;background-color: white;">Return</th>
					               				</tr>
					               			</thead>
					               			<tbody>
					               				<?php 
					               				$instockSum = 0;
					               				$soldSum 	= 0;
					               				$damagedSum = 0;
					               				//$repairSum 	= 0;
					               				//$expiredSum = 0;
					               				$retuendSum = 0;
					               				for ($j=0; $j <$countProducts ; $j++) { 
					               				$productID = $productData[$j]['product_id'];
					               				$prodName = $productData[$j]['product_name'];

					               				// getting in-stock details
														$inStockData = Yii::$app->db->createCommand("
														SELECT COUNT(name)
														FROM  stock
														WHERE manufacture_id = $manufactureID
														AND name = '$productID'
														AND status = 'In-stock'
														")->queryAll();
														// getting sold stock details
														$soldStockkData = Yii::$app->db->createCommand("
														SELECT COUNT(name)
														FROM  stock
														WHERE manufacture_id = $manufactureID
														AND name = '$productID'
														AND status = 'Sold'
														")->queryAll();
														// getting damaged stock details
														$damageStockkData = Yii::$app->db->createCommand("
														SELECT COUNT(name)
														FROM  stock
														WHERE manufacture_id = $manufactureID
														AND name = '$productID'
														AND status = 'Damaged'
														")->queryAll();
														// getting expired stock details
														// $expiredStockkData = Yii::$app->db->createCommand("
														// SELECT COUNT(name)
														// FROM  stock
														// WHERE manufacture_id = $manufactureID
														// AND name = '$productID'
														// AND status = 'Expired'
														// ")->queryAll();
														// getting returned stock details
														$returnedStockkData = Yii::$app->db->createCommand("
														SELECT COUNT(name)
														FROM  stock
														WHERE manufacture_id = $manufactureID
														AND name = '$productID'
														AND status = 'Returned'
														")->queryAll();
														// getting repaired stock details
														// $repairedStockkData = Yii::$app->db->createCommand("
														// SELECT COUNT(name)
														// FROM  stock
														// WHERE manufacture_id = $manufactureID
														// AND name = '$productID'
														// AND status = 'Repaired'
														// ")->queryAll();
					               				?>
					               				<tr style="text-align: center;">
					               					<td><?php echo $j+1; ?></td>
					               					<td><?php echo $prodName; ?></td>
					               					<?php 
					               					$totalInstock = $inStockData[0]['COUNT(name)'];
					               					$instockSum += $totalInstock;
					               					if ($totalInstock == 0) {
					               						echo "<td class='danger'>"."Not available"."</td>";
					               					}
					               					else{
					               						echo "<td class='info'>".$totalInstock."</td>";
					               					}
					               					?>
					               					<?php 
					               					$totalSold = $soldStockkData[0]['COUNT(name)'];
					               					$soldSum += $totalSold;
					               					if ($totalSold == 0) {
					               						echo "<td class='danger'>"."0"."</td>";
					               					}
					               					else{
					               						echo "<td class='success'>".$totalSold."</td>";
					               					}

					               					?>
					               					<td class="warning">
					               						<?php 
					               						$totalDamaged = $damageStockkData[0]['COUNT(name)'];
					               						$damagedSum += $totalDamaged;
					               						echo $totalDamaged;
					               						?>
					               					</td>
					               					<td>
					               						<?php
					               						$totalReturned = $returnedStockkData[0]['COUNT(name)'];
					               						$retuendSum += $totalReturned;
					               						echo $totalReturned;
					               						?>
					               					</td>
					               				</tr>
					               				<?php } ?>
					               				<tr style="text-align: center;background-color:white;font-weight:bolder;">
					               					<th colspan="2" style="text-align: center;background-color:#3C8DBC;color:white;vertical-align:middle;">Total</th>
					               					<td><?php echo $instockSum;?></td>
					               					<td><?php echo $soldSum; ?></td>
					               					<td><?php echo $damagedSum; ?></td>
					               					<td><?php echo $retuendSum; ?></td>
					               				</tr>
					               			</tbody>
					               		</table>
					               	</div>
					               </div>
					            </div>
			            <?php } ?>
					              <!-- /.tab-pane -->
			            </div>
			            <!-- /.tab-content -->
	      		</div>
	      			<!-- /.nav-tabs-custom -->
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
