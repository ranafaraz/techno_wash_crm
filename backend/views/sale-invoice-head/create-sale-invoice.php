<!DOCTYPE html>
<html>
<head>
	<title>Cerate Sale Invoice</title>
</head>
<body>
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-4">
				<label> BarCode</label>
				<input type="text" class="form-control" name="barcoede" id="barcode" autofocus="" >
			</div>
			<div class="col-md-4">
				<label> Product Name </label>
				<input type="text" class="form-control" name="product_name" id="product_name" readonly="">
			</div>
			<div class="col-md-4">
				<label>Net Price</label>
				<input type="text" class="form-control" name="product_name" id="price" readonly="">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				
				<p><label>Discount By:</label> <input type="radio" name="amount" id="percentage" checked="">Percentage <input type="radio" name="amount" id="amount">Amount</p>
				<input type="text" class="form-control" name="product_name" id="discount" value="0">
			</div>
			<div class="col-md-4">
				<label>Discounted Amount</label>
				<input type="text" class="form-control" name="product_name" id="discount_amount" readonly="" style="margin-top: 10px">
			</div>
			<div class="col-md-4">
				<label>Net Total</label>
				<input type="text" class="form-control" name="product_name" id="net_total" readonly="" style="margin-top: 10px" value="0">
			</div>
		</div>
		<div class="row">
			<br>
			<div class="col-md-4">
				<button type="button" onclick="" class="btn btn-success">Insert</button>
			<button  onclick="insert_data()" class="btn btn-success">Disply Used Stock</button>
			</div>
		</div>
		<div class="row" id="mydata">
				<div class="col-md-12">
					<table class="table table-hover table-striped table-bordered" id="myTableData">
				
						<thead>
							<tr>
								<th>Sr.#</th>
								<th>BarCode</th>
								<th>Product Name</th>
								<th>Price</th>
								<th>Discount Amount</th>
								
							</tr>
						</thead>
						<tbody>
					
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
	let barcodeArr = new Array();
      let productNameArr = new Array();
      let priceAr = new Array();
      let discountArr = new Array();

	function insert_data(){
		var barcode = $('#barcode').val();
		var product_name= $('#product_name').val();
		var price = $('#price').val();
		var discount = $('#discount_amount').val();
		barcodeArr.push(barcode);
		productNameArr.push(product_name);
		priceAr.push(price);
		discountArr.push(discount);

		 $("#mydata").show();

		 let table = document.getElementById("myTableData");

		 //count the table row
		let rowCount = table.rows.length;
          
          
          
          //insert the new row
          let row = table.insertRow(1);
          
          //insert the coulmn against the row
          row.insertCell(0).innerHTML= rowCount;
          row.insertCell(1).innerHTML= barcode;
          row.insertCell(2).innerHTML= product_name;
          row.insertCell(3).innerHTML= price;
          row.insertCell(4).innerHTML= discount;

          $('#barcode').val("");
			$('#product_name').val("");
			 $('#price').val("");
			$('#discount_amount').val("");
	}
</script>
<?php
$url = \yii\helpers\Url::to("sale-invoice-head/fetch-info");


$script = <<< JS
$("#discount_amount").focus(function(){

		var discount = $("#discount").val();
		var price = $("#price").val();
		var net_amount = $('#net_total').val();
		if($('#amount').prop('checked')){
			discountd_amount = price-discount;
			$('#discount_amount').val(discount);
			net_total=parseInt(discountd_amount)+parseInt(net_amount);
			$('#net_total').val(net_total);
		}
		else if($('#percentage').prop('checked')){
			
			discount_amount = (price*discount)/100;
			discounted=price-discount_amount;

			$('#discount_amount').val(discount_amount);
			procuct_discount = $('#discount_amount').val();

			var net_discount = price-procuct_discount;

			net_total=parseInt(net_discount)+parseInt(net_amount);
			$('#net_total').val(net_total);
		}
		
	});
	 $('#mydata').hide();
	$("#barcode").change(function(){
		var barcode = $("#barcode").val();
		$.ajax({
	        type:'post',
	        data:{barcode:barcode},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	
           $('#product_name').val(jsonResult[0]['name']);
           $('#price').val(jsonResult[0]['selling_price']);
           $('#discount').focus();
            
        	}     
    	}); 
	});
	


JS;
$this->registerJs($script);
?>
</script>
