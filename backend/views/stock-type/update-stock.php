<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<h3>Stock Update</h3>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-default">
				<div class="box-body">
					<form>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Barcode</label>
								<input type="text" id="barcode" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Stock Type</label>
								<input type="text" id="stock_type_name" class="form-control" readonly="">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Manufacturer</label>
								<input type="text" id="manufacture_name" class="form-control" readonly="">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Product Name</label>
								<input type="text" id="product_name" class="form-control" readonly="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Expiry Date</label>
								<input type="date" id="expiry_date" class="form-control">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Original Price</label>
								<input type="number" id="original_price" class="form-control">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Purchasing Price</label>
								<input type="number" id="purchasing_price" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Selling Price</label>
								<input type="number" id="selling_price" class="form-control">	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Status</label>
								<select id="status" class="form-control">
								<option value="">Select Status</option>
								<option value="In-stock">
									In-stock
								</option>
								<option value="Sold">
									Sold
								</option>
								<option value="Damaged">
									Damaged
								</option>
								<option value="Repaired">
									Repaired
								</option>
								<option value="Expired">
									Expired
								</option>
								<option value="Returned">
									Returned
								</option>
							</select>
							</div>
						</div>
					</div>
					<input type="hidden" id="stock_type_id">
					<input type="hidden" id="manufacture_id">
					<input type="hidden" id="product_id">
					<input type="hidden" id="stock_id">

					</form>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-success" style="display: none;" id="update_stock">
									<i class="glyphicon glyphicon-edit"></i> Update
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
$url = \yii\helpers\Url::to("stock-type/fetch-stock-info");


$script = <<< JS
	
	$("#barcode").change(function(){
		var barcode = $("#barcode").val();
		$.ajax({
	        type:'post',
	        data:{
	        	barcode:barcode
	        	},
	        url: "$url",
	        success: function(result){
        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
        	console.log(jsonResult);

        	$('#stock_type_id').val(jsonResult[0]);
        	$('#manufacture_id').val(jsonResult[1]);
        	$('#product_id').val(jsonResult[2]);
        	$('#stock_type_name').val(jsonResult[3]);
        	$('#manufacture_name').val(jsonResult[4]);
        	$('#product_name').val(jsonResult[5]);
			var splitarray = new Array();
			splitarray= jsonResult[6].split(" ");
        	$('#expiry_date').val(splitarray[0]);

			
        	$('#original_price').val(jsonResult[7]);
        	$('#purchasing_price').val(jsonResult[8]);
        	$('#selling_price').val(jsonResult[9]);
        	$('#status').val(jsonResult[10]);
        	$('#stock_id').val(jsonResult[11]);
        	
	        	
        	}

    	}); 
    	$("#update_stock").show(); 
	});

	$("#update_stock").click(function(){

		var stock_id 			= $("#stock_id").val();
		var stock_type_id 		= $("#stock_type_id").val();
		var manufacture_id 		= $("#manufacture_id").val();
		var product_id 			= $("#product_id").val();

		var barcode 			= $("#barcode").val();
		var expiry_date 		= $("#expiry_date").val();
		var original_price 		= $("#original_price").val();
		var purchasing_price 	= $("#purchasing_price").val();
		var selling_price 		= $("#selling_price").val();
		var status 				= $("#status").val();

		$.ajax({
	        type:'post',
	        data:{
	        	stock_id:stock_id,
	        	stock_type_id:stock_type_id,
	        	manufacture_id:manufacture_id,
	        	product_id:product_id,
	        	barcode:barcode,
	        	expiry_date:expiry_date,
	        	original_price:original_price,
	        	purchasing_price:purchasing_price,
	        	selling_price:selling_price,
	        	status:status
	        	},
	        url: "$url",
	        success: function(result){
        	// var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
        	if(result)
        	{
        		 window.location = './stock-type';
        	}

        	}      
    	}); 
	});

JS;
$this->registerJs($script);
?>
<?php 

//  if(isset($_POST['insert_collect']))
//  {
//    $customerID  = $_POST['custID'];
//    $invID       = $_POST['invID'];
//    $netTotal    = $_POST['net_total'];
//    $paid_amount = $_POST['paid_amount'];
//    $remaining   = $_POST['remaining'];
//    $collect     = $_POST['collect'];
//    $status      = $_POST['status'];
//    $netTotal    = $_POST['net_total'];

//    $id   =Yii::$app->user->identity->id;

//      // starting of transaction handling
//      $transaction = \Yii::$app->db->beginTransaction();
//      try {
//       $insert_invoice_head = Yii::$app->db->createCommand()->update('sale_invoice_head',[

//      'net_total'        => $netTotal,
//      'paid_amount'      => $paid_amount,
//      'remaining_amount' => $remaining,
//      'status'           => $status,
//      'created_by'       => $id,
//     ],
//        ['customer_id' => $customerID,'sale_inv_head_id' => $invID ]

//     )->execute();
//      // transaction commit
//      $transaction->commit();
        
//      } // closing of try block 
//      catch (Exception $e) {
//       // transaction rollback
//          $transaction->rollback();
//      } // closing of catch block
//      // closing of transaction handling
// }

 ?>