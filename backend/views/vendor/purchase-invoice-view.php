<?php 
use common\models\Branches;
use yii\helpers\Html;

  $vendorID = $_GET['vendor_id'];
  $id=Yii::$app->user->identity->id;
  // getting customer name
  $vendorData = Yii::$app->db->createCommand("
    SELECT *
    FROM vendor
    WHERE vendor_id = $vendorID
    ")->queryAll();

  $branchId = $vendorData[0]['branch_id'];

    $branchData = Branches::find()->where(['branch_id' => $branchId])->one();

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
  $paid_invoice = Yii::$app->db->createCommand("
    SELECT *
    FROM purchase_invoice where vendor_id = '$vendorID' AND status = 'Paid'
    ")->queryAll();
  $count_piad_invoice = count($paid_invoice);

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<style type="text/css" media="screen">
#myTableData thead tr:hover{
      background-color: #ECF0F5;
      cursor: pointer;
    }
</style>
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
              <li><a href="#paid_invoices" data-toggle="tab">Paid Invoices</a></li>
              <li><a href="#profile" data-toggle="tab">Vendor Profile</a></li>
            </ul>
            <div class="tab-content" style="background-color: #efefef;">
              <div class="active tab-pane" id="invoice">
               
                  <div class="form-group">
                          <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                  </div> 
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Bilty No</label>
                        <input type="text"  class="form-control" id="bilty_no">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Bill No</label>
                        <input type="text"  class="form-control" id="bill_no">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Purchase Date</label>
                        <input type="date"  class="form-control" id="purchase_date">
                      </div>
                    </div>
                  </div>
                  <div class="row">         
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Dispatch Date</label>
                        <input type="date"  class="form-control" id="dispatch_date">
                      </div>
                    </div>
                    <div class="col-md-4">
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
				            		<label>Select Stock Type</label>
				            		<select class="form-control" id="stock_type">
				            			<option value="">Select Stock Type</option>
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
				            			<option value="">First Select StockType</option>
				            		</select>
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Product Name</label>
				            		<select class="form-control" id="product_name">
                          <option value="">First Select Manufacturer</option>
                        </select>
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
                        <input type="text"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="original_price" class="form-control">
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Purchase Price</label>
                        <input type="text"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="purchase_price" class="form-control" oninput="check_purchase_price()">
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="form-group">
				            		<label>Selling Price</label>
                        <input type="text"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13 || event.charCode == 65 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" id="selling_price" class="form-control" >
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
                    <input type="hidden" id="productName">
			            </div>		
                	</div>
                </div><hr>			
                <div class="row">
                    <div class="col-md-12" >
                        <div class="row" id="mydata" style="display:none;">
                          <div class="col-md-3">
                            
                          </div>
                          <div class="col-md-4">
                            <input type="hidden" class="form-control" id="remove_value1">
                            <input type="text" class="form-control" id="remove_value">
                          </div>
                          <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-flat" id="remove"> <i class="fa fa-times"></i> Remove</button>
                          </div>
                        
							<div class="col-md-12">
                <br>
								<table class="table table-bordered" id="myTableData">
									<thead>
										<tr>
											<th style="background-color: #3C8DBC;color:white;">Sr #</th>
											<th style="background-color: #3C8DBC;color:white;">ST.</th>
											<th style="background-color: #3C8DBC;color:white;">Mnu.</th>
											<th style="background-color: #3C8DBC;color:white;">Name</th>
											<th style="background-color: #3C8DBC;color:white;">Exp. Date</th>
											<th style="background-color: #3C8DBC;color:white;">Org. Price</th>
											<th style="background-color: #3C8DBC;color:white;">Purch Price</th>
											<th style="background-color: #3C8DBC;color:white;">Sale Price</th>
                      <th style="background-color: #3C8DBC;color:white;">Barcode</th>
										</tr>
									</thead>
									<tbody style="background-color:lightgray;color:black;">
										
									</tbody>
								</table>
							</div>
						</div>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="paid_invoices">
                <div class="row">
                  <div class="col-md-12">
                      <h3 class="text-info" style="vertical-align: middle; margin-bottom: 25px !important;">Paid Invoices Details</h3>
                    </div>    
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">                      
                        <table class="table table-bordered table-striped">
                            <thead style="background-color: #367FA9;color:white;">
                                <tr>
                                    <th class="t-cen" style="vertical-align:middle;">Sr #</th>
                                    <!-- <th class="t-cen" style="vertical-align:middle; width: 100px;">Invoice #</th> -->
                                    <th class="t-cen" style="vertical-align:middle;">Date</th>
                                    <th class="t-cen" style="vertical-align:middle;">Amount</th>
                                    <th class="t-cen" style="vertical-align:middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                                  
                                  
                                    for ($i=0; $i <$count_piad_invoice ; $i++) {

                                      ?>
                                      <tr>
                                        <td><?php echo $i+1; ?></td>
                                        <td><?php echo $paid_invoice[$i]['receiving_date'] ?></td>
                                        <td><?php echo $i+1; ?></td>
                                        <td><?php echo $i+1; ?></td>
                                      </tr>

                                    <?php
                                  }
                                 ?>
                              
                            </tbody>
                          </table>
                        </div>
                      
                    </div>
                  </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="profile">
            	<div class="row">
            		<div class="col-md-11">
            			<h3 class="text-info" style="vertical-align: middle; margin-bottom: 25px !important;">Vendor Details</h3>
            		</div>
            		<div class="col-md-1">
            			 <a href="./vendor-update?id=<?php echo $vendorID;?>" class="btn btn-info" style="float:right; margin-right: 3px; margin-bottom: 3px; margin-top: 15px;"> 
            				<i class="glyphicon glyphicon-edit"></i> Edit
            			</a>
            		</div>
            	</div>
            	<div class="row" style="margin-bottom:10px;">
            		<div class="col-md-12">
            			<table class="table table-bordered">
            				<thead style="background-color: #367FA9;color:white;">
            					<tr>
            						<th class="text-center">
    								<?php
			            				echo "Vendor Name: <b style='font-size:16px; font-family:georgia;'>".$vendorData[0]['name']."</b>";
    				 				?>
            						</th>
            					</tr>
            				</thead>
            			</table>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-12">
            			<table class="table table-bordered">
            				<thead>
            					<tr>
            						<th class="bg-color" style="padding: 12px;">Branch Name:</th>
            						<th class="t-cen" style="background-color: white;">
            							<?php echo $branchData->branch_name; ?>
            						</th>
            					</tr>
            					<tr>
            						<th class="bg-color" style="padding: 12px;">Vendor NTN:</th>
            						<th class="t-cen" style="background-color: white;">
            							<?php echo $vendorData[0]['ntn']; ?>
            						</th>
            					</tr>
            				</thead>
            			</table>
            		</div>
            	</div>  
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

                      <input type="radio" name="discountType" id="amount" checked onclick="abc()"> Amount
          					 <input type="radio" name="discountType" id="percentage"  onclick="abc()"> Percentage
          	
          					<input type="number" name="discount" class="form-control" id="disc" oninput="discountFun()">
          					<input type="hidden" id="name" >
          					<input type="hidden" id="vehicle_name" >
          				</div>
                <div class="form-group">
                  <label>Net Total</label>
                  <input type="text" name="net_total" class="form-control" id="nt"readonly="" >
                </div>
                <div class="form-group">
                  <label>Paid</label>
                  <input type="number" name="paid" class="form-control"  id="paid" oninput="cal_remaining()">
                </div>
                <div class="form-group">
                  <label>Remaining</label>
                  <input type="text" name="remain" class="form-control" readonly="" id="remaining"> 
                </div>
                <div class="form-group">
                  <label>status</label>
                  <input type="text" name="status" class="form-control" readonly="" id="status">
                </div>
                <div class="alert-danger glyphicon glyphicon-ban-circle" style="display: none; padding: 10px;" id="alert">
                </div>
                <button class="btn btn-success btn-block btn-flat" id="insert" style="display: none;">
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
  function abc(){
    $('#disc').val("");
    $('#disc').focus();
    var total = $('#tp').val();
    $('#nt').val(total);
    $('#remaining').val(total);
    $('#paid').val("");
     
  }
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
            if($('#paid').val()!="" || $('#paid').val()!=null){
              remaining = purchasePrice-$('#paid').val();
              $('#remaining').val(remaining);
            }
            //alert(purchasePrice);
              }
            else if(document.getElementById('amount').checked)
            {
            	
            discount = parseInt(document.getElementById("disc").value);
                  
            purchasePrice = originalPrice - discount;
            //alert(purchasePrice);
              //discountReceived = discount;
             $('#nt').val(purchasePrice);
             
              if($('#paid').val()!="" || $('#paid').val()!=null){
                remaining = purchasePrice-$('#paid').val();
                $('#remaining').val(remaining);
              }
            } 
            $('#insert').show();
            if (purchasePrice < 0) {
              $('#insert').hide();
              $('#alert').css("display","block");
              $('#alert').html("&ensp;Discount Cannot Be Greater Than Total Amount");
            }else{
              $('#alert').css("display","none");
            }
      }
      function check_purchase_price(){
        var input1 = Number(document.getElementById( "original_price" ).value);
        var input2 = Number(document.getElementById( "purchase_price" ).value);
        if (input1<input2) {
          alert("The Purchase Price can not be greater than the original price")
          $('#purchase_price').val("");
          $('#purchase_price').css("border", "1px solid red");
        }
      }
      function cal_remaining(){
      	var paid = $('#paid').val();
      	var nt = $('#nt').val();
      	var remaining =nt - paid;
      	$('#remaining').val(remaining); 
        
        	if (remaining == 0) {
        		$('#status').val('Paid');
            $('#insert').show();
        	}
        	else if (remaining == nt) {
        		$('#status').val('Unpaid');
            $('#insert').show();
        	}
          
          else if (paid > 0) {
          $('#status').val('Partially');
        }
        $('#insert').show();
        if (remaining < 0) {
          $('#insert').hide();
          $('#alert').css("display","block");
          $('#alert').html("&ensp;Paid Amount Cannot Be Greater Than Net Total");
        }else{
          $('#alert').css("display","none");
        }
      }
</script>
<?php
$url = \yii\helpers\Url::to("vendor/fetch-vendor-info");


$script = <<< JS

	$("#stock_type").change(function(){
		 var stockType = $('#stock_type').val();

		 $.ajax({
          type:'post',
          data:{
            stockType:stockType
            },
          url: "$url",
          success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            //console.log(jsonResult);

            $('#manufacture_type').empty();
            $('#manufacture_type').append("<option>"+"Select Manufacturer"+"</option>");
            var options = '';
                for(var i=0; i<jsonResult.length; i++) { 
                    options += '<option value="'+jsonResult[i]['manufacture_id']+'">'+jsonResult[i]['name']+'</option>';
                }
            // Append to the html
            $('#manufacture_type').append(options);
                    
          }      
      });
	});

  $("#manufacture_type").change(function(){
     var manufactureType = $('#manufacture_type').val();

     $.ajax({
          type:'post',
          data:{
            manufactureType:manufactureType
            },
          url: "$url",
          success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            console.log(jsonResult);

            $('#product_name').empty();
            $('#product_name').append("<option>"+"Select Product"+"</option>");
            var options = '';
                for(var i=0; i<jsonResult.length; i++) { 
                    options += '<option value="'+jsonResult[i]['product_id']+'">'+jsonResult[i]['product_name']+'</option>';
                }
            // Append to the html
            $('#product_name').append(options);
                    
          }      
      });
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
		var name 				= $("#product_name").val();
		var expiry_date 		= $("#expiry_date").val();
		var original_price 		= $("#original_price").val();
		var purchase_price 		= $("#purchase_price").val();
		var selling_price 		= $("#selling_price").val();

		var stockTypeName 		=  $('#stockTypeName').val();
		var manufactreName 		=  $('#manufactreName').val();
    var product_name    =  $('#productName').val();

		var totalAmount = parseInt($('#tp').val());
		var tp = parseInt(totalAmount)+parseInt(purchase_price);
		$('#tp').val(tp);
            $('#nt').val(tp);
            $('#remaining').val(tp);
            $('#status').val('Unpaid');
		if(stock_type == "" || stock_type == null)
		{
			alert('Please Select the Stock Type');
      $('#stock_type').css("border", "1px solid red");
      $('#stock_type').focus();
		}
		else if(manufacture_type == "" || manufacture_type == null)
		{
			alert('Please Select the Manufacture Type');
      $('#manufacture_type').css("border", "1px solid red");
      $('#manufacture_type').focus();
		}
		else if(name == "" || name == null)
		{
			alert('Please Select the Name');
      $('#product_name').css("border", "1px solid red");
      $('#product_name').focus();
		}
		else if(expiry_date == "" || expiry_date == null)
		{
			alert('Please Select the Expiry Date');
      $('#expiry_date').css("border", "1px solid red");
      $('#expiry_date').focus();
		}
		else if(original_price == "" || original_price == null)
		{
			alert('Please fill the Original Price');
      $('#original_price').css("border", "1px solid red");
      $('#original_price').focus();
		}
		else if(purchase_price == "" || purchase_price == null)
		{
			alert('Please fill the Purchase Price');
      $('#purchase_price').css("border", "1px solid red");
      $('#purchase_price').focus();
		}
		else if(selling_price == "" || selling_price == null)
		{
			alert('Please fill the Selling Price');
      $('#selling_price').css("border", "1px solid red");
      $('#selling_price').focus();
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
		row.insertCell(3).innerHTML= product_name;
		row.insertCell(4).innerHTML= expiry_date;
		row.insertCell(5).innerHTML= original_price;
		row.insertCell(6).innerHTML= purchase_price;
		row.insertCell(7).innerHTML= selling_price;
    row.insertCell(8).innerHTML= barcode;

		$('#barcode').val("");
		$('#barcode').focus();
		}
    table = document.getElementById("myTableData");
    for(var i = 1; i < table.rows.length; i++)
                      {
                          table.rows[i].onclick = function()
                          {
                            // get the seected row index
                            rIndex = this.rowIndex;
                            document.getElementById("remove_value1").value = rIndex;
                            document.getElementById("remove_value").value = this.cells[8].innerHTML;
                          };
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

  $('#product_name').change(function(){

    var product_name = $("#product_name").val();

    $.ajax({
          type:'post',
          data:{
            product_name:product_name
            },
          url: "$url",
          success: function(result){
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            $('#productName').val(jsonResult[0]['product_name']);
                    
          }      
      }); 

  });
  $('#remove').click(function(){
      var remove_value = $('#remove_value1').val();
        if(remove_value=="" || remove_value==null){
          alert("Please select the row");
        }
        else{
            document.getElementById("myTableData").deleteRow(remove_value);
          var a =barcodeArray.length- remove_value;
           // alert(sellingPriceArray[a]);
             //alert(sellingPriceArray);
            var nt=$('#tp').val();
            var nta = nt-purchasePriceArray[a];
            //alert(barcodeArray.length);
            barcodeArray.splice(a,1);
            stockTypeArray.splice(a,1);
            manufacturerArray.splice(a,1);
            nameArray.splice(a,1);
            expiryDateArray.splice(a,1);
            originalPriceArray.splice(a,1);
            purchasePriceArray.splice(a,1);
            sellingPriceArray.splice(a,1);
             //alert(barcodeArray.length);
             $('#tp').val(nta);
             $('#remaining').val(nta);
             $('#nt').val(nta);
             $('#remove_value1').val("");
             $('#remove_value').val("");
            // alert(sellingPriceArray);
             if(barcodeArray.length==0){
              $('#bill_form').hide();
              $('#mydata').hide();
             }


          }
      });
	$('#insert').click(function(){

		user_id;
		vendorID;
    var bilty_no    = $('#bilty_no').val();
		var bill_no 		= $('#bill_no').val();
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
      $('#bilty_no').css("border", "1px solid red");
      $('#bilty_no').focus();
 		}
    else if(bill_no == "" || bill_no == null )
    {
      alert('Please fill Bilty no');
      $('#bill_no').css("border", "1px solid red");
      $('#bill_no').focus();
    }
 		else if(purchase_date == "" || purchase_date == null )
 		{
 			alert('Please select purchase date');
      $('#purchase_date').css("border", "1px solid red");
      $('#purchase_date').focus();
 		}
 		else if(dispatch_date == "" || dispatch_date == null )
 		{
 			alert('Please select dispatch date');
      $('#dispatch_date').css("border", "1px solid red");
      $('#dispatch_date').focus();
 		}
 		else if(receiving_date == "" || receiving_date == null )
 		{
 			alert('Please select receiving date');
      $('#receiving_date').css("border", "1px solid red");
      $('#receiving_date').focus();
 		}
 		else
 		{
 			$.ajax({
		        type:'post',
		        data:{
		        	user_id:user_id,
		        	vendorID:vendorID,
              bilty_no:bilty_no,    
    					bill_no:bill_no, 		
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