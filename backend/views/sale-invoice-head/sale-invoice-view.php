<?php 

	$customerID = $_GET['customer_id'];
	//$saleInvoiceID = $_GET['sale_invoice_id'];
	// /echo $customerID;

	// getting customer name
	$customerName = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = $customerID
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
		<div class="col-md-12">
			<h2 style="color:#3C8DBC;">Sale Invoice: <?php echo $customerName[0]['customer_name']; ?></h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="box box-default">
				<div class="box-body">
					<div class="nav-tabs-custom">
			            <ul class="nav nav-tabs">
			              <li class="active">
			              	<a href="#invoice" data-toggle="tab">New Invoice</a>
			              </li>
			              <li><a href="#previous" data-toggle="tab">Prevoius Invoices</a></li>
			              <!-- <li><a href="#details" data-toggle="tab">Account Details</a></li> -->
			            </ul>
			            <div class="tab-content">
					            <div class="active tab-pane" id="invoice">
					            	<form method="post" action="./sale-invoice-view">
					            		<div class="form-group">
							                    <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
							            </div> 
					             	<div class="row">
					             		<div class="col-md-4">
					             			<div class="form-group">
					             				<label>Date</label>
					             				<input type="date" name="date" class="form-control">
					             			</div>
					             		</div>
					             		<div class="col-md-8">
					             			<button style="margin-top:24px;" class="btn btn-info" type="submit" name="service">
					             				<i class="glyphicon glyphicon-plus"></i> Add Service
					             			</button>
					             			<button style="margin-top:24px;" class="btn btn-warning" type="submit" name="stock">
					             				<i class="glyphicon glyphicon-plus"></i> Add Stock
					             			</button>
					             		</div>
					             	</div>
					             	</form>
					             	<?php 
					             	if(isset($_POST['service'])) { ?>
					             	 	<div class="row">
						             		
						             	</div>
						            
					             	<?php } ?>
					             	<div class="row">
					             		<div class="col-md-8">
					             			<table class="table">
					             				<thead>
					             					<tr>
					             						<th>name</th>
					             						<th>name</th>
					             						<th>name</th>
					             						<th>name</th>
					             					</tr>
					             				</thead>
					             				<tbody>
					             					<tr>
					             						<td>Ali</td>
					             						<td>Ali</td>
					             						<td>Ali</td>
					             						<td>Ali</td>
					             					</tr>
					             				</tbody>
					             			</table>
					             		</div>
				             		</div>
					              <!-- /.tab-pane -->
					            <div class="tab-pane" id="previous">
					              	

					                    
					            </div>
					              <!-- /.tab-pane -->

			              		<div class="tab-pane" id="details">
			              			<h1>tab 3</h1>
			               
					            </div>
					              <!-- /.tab-pane -->
			            </div>
			            <!-- /.tab-content -->
          			</div>
          			<!-- /.nav-tabs-custom -->
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-default">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<form>
								<div class="form-group">
									<label></label>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>