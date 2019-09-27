<?php 

use yii\helpers\Html;
  $vendorID = $_GET['vendor_id'];
  $id=Yii::$app->user->identity->id;
  // getting customer name
  $vendorData = Yii::$app->db->createCommand("
    SELECT *
    FROM vendor
    WHERE vendor_id = $vendorID
    ")->queryAll();

   // getting stock type
  $stockType = Yii::$app->db->createCommand("
    SELECT *
    FROM stock_type
    ")->queryAll();
  $countStockType = count($stockType);

   // getting manufacturer
  $manufacture = Yii::$app->db->createCommand("
    SELECT *
    FROM manufacture
    ")->queryAll();
  $countManufacture = count($manufacture);

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
      <h2 style="color:#3C8DBC;">Purchase Invoice: <?php echo $vendorData[0]['name']; ?></h2>
    </div>
    <div class="col-md-4">

    </div>
  </div>
  <div class="row">
    <div class="col-md-9">
      <div class="box box-primary">
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
               
                  <div class="form-group">
                          <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                  </div> 
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Bilty No</label>
                        <input type="text"  class="form-control" id="bilty_no">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Purchase Date</label>
                        <input type="date"  class="form-control" id="purchase_date">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Dispatch Date</label>
                        <input type="date"  class="form-control" id="dispatch_date">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Receiving Date</label>
                        <input type="date"  class="form-control" id="receiving_date">
                      </div>
                    </div>
                  </div>
                </form>
                <div class="row">
                	<div class="col-md-12">
        				<div class="container-fluid" style="margin-bottom:;">
				            <div class="row">
				              <div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
				                Add Stock
				              </div>
				            </div>
						</div><br>
			            <div class="row">
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Stock Type</label>
				            		<select class="form-control" id="stock_type">
				            			<option value="">stock type...</option>
				            			<?php 
				            			for ($i=0; $i <$countStockType ; $i++) {
				            			?>
				            			<option value="<?php echo $stockType[$i]['stock_type_id']; ?>"><?php echo $stockType[$i]['name'];  ?></option>
				            			<?php } ?>
				            		</select>
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Manufacture</label>
				            		<select class="form-control" id="manufacture_type">
				            			<option value="">manufacturer...</option>
				            			<?php 
				            			for ($j=0; $j <$countManufacture ; $j++) {
				            			?>
				            			<option value="<?php echo $manufacture[$j]['manufacture_id']; ?>"><?php echo $manufacture[$j]['name'];  ?></option>
				            			<?php } ?>
				            		</select>
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Name</label>
				            		<input type="text" class="form-control" id="name">
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Expiry Date</label>
				            		<input type="date" class="form-control" id="expiry_date">
			            		</div>
			            	</div>
			            </div>
			            <div class="row">
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Original Price</label>
				            		<input type="number" class="form-control" id="original_price">
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Purchase Price</label>
				            		<input type="number" class="form-control" id="purchase_price">
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Selling Price</label>
				            		<input type="number" class="form-control" id="selling_price">
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Barcode</label>
				            		<input type="text" class="form-control" id="barcode">
			            		</div>
			            	</div>
			            	<input type="hidden" id="stockTypeName">
			            	<input type="hidden" id="manufactreName">
			            </div>		
                	</div>
                </div><hr>			
                <div class="row">
                    <div class="col-md-12" >
                        <div class="row" id="mydata" style="display:none;">
							<div class="col-md-12">
								<table class="table table-bordered" id="myTableData">
									<thead style="background-color:#3C8DBC;color:white;">
										<tr>
											<th>Sr #</th>
											<th>ST.</th>
											<th>Mnu.</th>
											<th>Name</th>
											<th>Exp.Date</th>
											<th>Org Price</th>
											<th>Purchase Price</th>
											<th>Sale Price</th>
										</tr>
									</thead>
									<tbody style="background-color:lightgray;color:black;">
										<tr>
											
										</tr>
									</tbody>
								</table>
							</div>
						</div>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="previous">
                      
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      </div>
    </div>
    <div class="col-md-3" id="bill_form" style="display: none;">
      <div class="box box-success">
        <div class="box-body">
        	<div class="container-fluid" style="margin-bottom:8px;">
            <div class="row">
              <div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
                Bill
              </div>
            </div>
          </div>
          <div class="row" >
            <div class="col-md-12">
                <div class="form-group">
                  <label>Total Amount</label>
                  <input type="text" name="total_amount" class="form-control" readonly="" id="tp" value="0">
                </div>
                <div class="form-group">
					<label>Discount</label>
					 <input type="radio" name="discountType" id="percentage"   checked > Percentage
	
					  <input type="radio" name="discountType" id="amount"> Amount
					<input type="number" name="discount" class="form-control" id="disc" value="0">
					<input type="hidden" id="name" >
					<input type="hidden" id="vehicle_name" >
				</div>
                <div class="form-group">
                  <label>Net Total</label>
                  <input type="text" name="net_total" class="form-control" id="nt"readonly="" onfocus="discountFun()">
                </div>
                <div class="form-group">
                  <label>Paid</label>
                  <input type="number" name="paid" class="form-control"  id="paid">
                </div>
                <div class="form-group">
                  <label>Remaining</label>
                  <input type="text" name="remain" class="form-control" readonly="" id="remaining"
                  onfocus="cal_remaining()"> 
                </div>
                <div class="form-group">
                  <label>status</label>
                  <input type="text" name="status" class="form-control" readonly="" id="status">
                </div>
                <button class="btn btn-success btn-block btn-flat" id="insert" >
                	<i class="glyphicon glyphicon-plus" ></i> Add Bill</button>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>
	
	let barcodeArray   		= new Array();
	let stockTypeArray 		= new Array();
	let manufacturerArray 	= new Array();
	let nameArray 			= new Array();
	let expiryDateArray   	= new Array();
	let originalPriceArray  = new Array();
	let purchasePriceArray  = new Array();
	let sellingPriceArray   = new Array();
	let vendorID 			= <?php echo $vendorID; ?>;

	let user_id= <?php echo $id; ?>;
	function discountFun(){
        // Getting the value from the original price
       originalPrice = parseInt(document.getElementById("tp").value);
       // alert(originalPrice);
      //discountType  = parseInt(document.getElementById("discountType").value);
        
          if(document.getElementById('percentage').checked)
              {
              	
            discount = parseInt(document.getElementById("disc").value);
            
            discountReceived = parseInt((originalPrice*discount)/100);
            
            purchasePrice = originalPrice-discountReceived;
            $('#nt').val(purchasePrice);
            //alert(purchasePrice);
              }
            else if(document.getElementById('amount').checked)
            {
            	
            discount = parseInt(document.getElementById("disc").value);
                  
            purchasePrice = originalPrice - discount;
            //alert(purchasePrice);
              //discountReceived = discount;
             $('#nt').val(purchasePrice);
              //alert(originalPrice);
            } 
      }
      function cal_remaining(){
      	var paid = $('#paid').val();
      	var nt = $('#nt').val();
      	var remaining =nt - paid;
      	$('#remaining').val(remaining); 
      	if (remaining ==0) {
      		$('#status').val('Paid');
      	}
      	else if (remaining < paid) {
      		$('#status').val('Partially');
      	}
      	else if (remaining = nt) {
      		$('#status').val('Unpaid');
      	}
      	$('#insert').show();
      }
</script>
<?php
$url = \yii\helpers\Url::to("vendor/fetch-vendor-info");


$script = <<< JS

	$("#item_type").change(function(){
		 var item_type = $('#item_type').val();
		 if(item_type == "Service")
		 {
		 	$('#servic').show();
		 	$('#stock').hide();
		 }
		 else if(item_type == "Stock")
		 {
		 	$('#stock').show();
		 	$('#servic').hide();
		 }
	});

	$("#disc").change(function(){
		 var totalAmount = $('#tp').val();

		 if($("#percentage").checked)
              {
              	
            discount = parseInt($("#disc").val());
            
            discountReceived = parseInt((totalAmount*discount)/100);
            
            purchasePrice = totalAmount-discountReceived;
            $('#nt').val(purchasePrice);
              }
            else if(document.getElementById("#amount").checked)
            {
            	
            discount = parseInt(document.getElementById("disc").value);
                  
            purchasePrice = originalPrice - discount;
              //discountReceived = discount;
             //$('#nt').val(purchasePrice);
              //alert(originalPrice);
            } 
	});

	$("#barcode").change(function(){

		var barcode 			= $("#barcode").val();
		var stock_type 			= $("#stock_type").val();
		var manufacture_type 	= $("#manufacture_type").val();
		var name 				= $("#name").val();
		var expiry_date 		= $("#expiry_date").val();
		var original_price 		= $("#original_price").val();
		var purchase_price 		= $("#purchase_price").val();
		var selling_price 		= $("#selling_price").val();

		var stockTypeName 		=  $('#stockTypeName').val();
		var manufactreName 		=  $('#manufactreName').val();

		var totalAmount = parseInt($('#tp').val());
		var tp = parseInt(totalAmount)+parseInt(purchase_price);
		$('#tp').val(tp);
		if(stock_type == "" || stock_type == null)
		{
			alert('Please Select the Stock Type');
		}
		else if(manufacture_type == "" || manufacture_type == null)
		{
			alert('Please Select the Manufacture Type');
		}
		else if(name == "" || name == null)
		{
			alert('Please Select the Name');
		}
		else if(expiry_date == "" || expiry_date == null)
		{
			alert('Please Select the Expiry Date');
		}
		else if(original_price == "" || original_price == null)
		{
			alert('Please fill the Original Price');
		}
		else if(purchase_price == "" || purchase_price == null)
		{
			alert('Please fill the Purchase Price');
		}
		else if(selling_price == "" || selling_price == null)
		{
			alert('Please fill the Selling Price');
		}

		else{
		barcodeArray.push(barcode);
		stockTypeArray.push(stock_type);
		manufacturerArray.push(manufacture_type);
		nameArray.push(name);
		expiryDateArray.push(expiry_date);
		originalPriceArray.push(original_price);
		purchasePriceArray.push(purchase_price);
		sellingPriceArray.push(selling_price);

		$("#mydata").show();
		$('#bill_form').show();
		//document.getElementById('insertdata').disabled=false;
		$('#insertdata').attr("disabled", false);

		let table = document.getElementById("myTableData");

		//count the table row
		let rowCount = table.rows.length;

		//insert the new row
		let row = table.insertRow(1);
		  
		//insert the coulmn against the row
		row.insertCell(0).innerHTML= rowCount;
		row.insertCell(1).innerHTML= stockTypeName;
		row.insertCell(2).innerHTML= manufactreName;
		row.insertCell(3).innerHTML= name;
		row.insertCell(4).innerHTML= expiry_date;
		row.insertCell(5).innerHTML= original_price;
		row.insertCell(6).innerHTML= purchase_price;
		row.insertCell(7).innerHTML= selling_price;

		$('#barcode').val("");
		$('#barcode').focus();
		}


	});


	$('#stock_type').change(function(){

		var stock_type = $("#stock_type").val();

		$.ajax({
	        type:'post',
	        data:{
	        	stock_type:stock_type
	        	},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	$('#stockTypeName').val(jsonResult[0]['name']);
        		      	
        	}      
    	}); 

	});

	$('#manufacture_type').change(function(){

		var manufacture_type = $("#manufacture_type").val();

		$.ajax({
	        type:'post',
	        data:{
	        	manufacture_type:manufacture_type
	        	},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	$('#manufactreName').val(jsonResult[0]['name']);
        		      	
        	}      
    	}); 

	});

	$('#insert').click(function(){

		user_id;
		vendorID;
		var bilty_no 		= $('#bilty_no').val();
		var purchase_date 	= $('#purchase_date').val();
		var dispatch_date 	= $('#dispatch_date').val();
		var receiving_date 	= $('#receiving_date').val();
		var total_amount 	= $('#tp').val();
		var net_total 		= $('#nt').val();
		var paid 			= $('#paid').val();
	    var remaining 		= $('#remaining').val();
		var status 			= $('#status').val();
	    barcodeArray;
	 	stockTypeArray;
	 	manufacturerArray;
	 	nameArray;
	 	expiryDateArray;
	 	originalPriceArray;
	 	purchasePriceArray;
	 	sellingPriceArray;

 		if(bilty_no == "" || bilty_no == null )
 		{
 			alert('Please fill Bilty no');
 		}
 		else if(purchase_date == "" || purchase_date == null )
 		{
 			alert('Please select purchase date');
 		}
 		else if(dispatch_date == "" || dispatch_date == null )
 		{
 			alert('Please select dispatch date');
 		}
 		else if(receiving_date == "" || receiving_date == null )
 		{
 			alert('Please select receiving date');
 		}
 		else
 		{
 			$.ajax({
		        type:'post',
		        data:{
		        	user_id:user_id,
		        	vendorID:vendorID,
					bilty_no:bilty_no, 		
					purchase_date:purchase_date,
					dispatch_date:dispatch_date, 	
					receiving_date:receiving_date, 	
					total_amount:total_amount, 	
					net_total:net_total, 		
					paid:paid, 			
				    remaining:remaining,
				    status:status, 		
				    barcodeArray:barcodeArray,
				 	stockTypeArray:stockTypeArray,
				 	manufacturerArray:manufacturerArray,
				 	nameArray:nameArray,
				 	expiryDateArray:expiryDateArray,
				 	originalPriceArray:originalPriceArray,
				 	purchasePriceArray:purchasePriceArray,
				 	sellingPriceArray:sellingPriceArray
		        	},
		        url: "$url",
		        success: function(result){ 
	        		if(result){
        			
        			window.location = './purchase-invoice-view?vendor_id=$vendorID';
        			}     	
	        	}      
    		}); 	
 		}
	});

JS;
$this->registerJs($script);
?>