<?php 
use common\models\Customer; 
use common\models\Branches;
use yii\helpers\Html;

  $customerID = $_GET['customer_id'];
  $id=Yii::$app->user->identity->id;
  // getting customer name
  $customerName = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = $customerID
    ")->queryAll();

  // getting vehicle
  $customerVehicles = Yii::$app->db->createCommand("
    SELECT *
    FROM customer_vehicles
    WHERE customer_id = '$customerID'
    ")->queryAll();
    $countcustomerVehicles = count($customerVehicles);

 // getting services
  $services = Yii::$app->db->createCommand("
    SELECT *
    FROM services
    ")->queryAll();
    $countServices = count($services);

 // getting customer name
  $customerName = Yii::$app->db->createCommand("
    SELECT *
    FROM customer
    WHERE customer_id = $customerID
    ")->queryAll();
$id =  Yii::$app->user->identity->id;
$paidinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE customer_id = '$customerID' AND (status = 'paid' OR status = 'Paid')
    ORDER BY sale_inv_head_id DESC
    ")->queryAll();
    $countpaidinvoiceData = count($paidinvoiceData);

    $creditinvoiceData = Yii::$app->db->createCommand("
    SELECT *
    FROM sale_invoice_head
    WHERE customer_id = '$customerID' AND (status = 'Partially' OR status = 'Unpaid')
    ")->queryAll();
    $countcreditinvoiceData = count($creditinvoiceData);
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style type="text/css" media="screen">
  	#remove_index,#types{
  		display: none;
  	}
  	tr:hover{
  		background-color:gray;
  		cursor: pointer;
  	}
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <h2 style="color:#3C8DBC;">Sale Invoice: <?php echo $customerName[0]['customer_name']; ?></h2>
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
             
              <li><a href="#paid" data-toggle="tab">Paid Invoices <span class="badge"><?=$countpaidinvoiceData?></span></a></li>
              <li><a href="#credit" data-toggle="tab">Credit <span class="badge"><?=$countcreditinvoiceData?></span></a></li>
              <li><a href="#customer" data-toggle="tab">Customer Profile</a></li>
              <li><a href="#customer_vehicles" data-toggle="tab">Customer Vehicles</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="invoice">
               
                  <div class="form-group">
                          <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                  </div> 
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date"  class="form-control" id="invoice_date">
                      </div>
                    </div>
                    <div class="col-md-8">
	                    <div class="row" style="margin-top: 25px" id="remove_index">
	                    	<div class="col-md-6">
	                    		<input type="hidden" id="remove_value">
	                    		<input type="text" placeholder="" class="form-control" id="removed_value" readonly="">
	                    		
	                    	</div>
	                    	<div class="col-md-2">
	                    		<button type="button" class="btn btn-warning btn-flat" id="remove"><i class="fa fa-times"></i> Remove</button>
	                    	</div>
	                    </div>
                    </div>
                  </div>
                </form>				
                <div class="row">
                    <div class="col-md-4" id=>
                      <div class="box box-info">
						<div class="box-body">
				          <div class="container-fluid" style="margin-bottom:8px;">
				            <div class="row">
				              <div class="col-md-12" style="padding:10px;text-align: center;font-weight: bolder;font-size:20px;background-color: lightgray;">
				                Add Items
				              </div>
				            </div>
				          </div>
				          <div class="row">
				            <div class="col-md-12">
				                <div class="form-group">
				                  <label>Select Vehicle</label>
				                  <select name="customer_vehicle" class="form-control" id="vehicle">
				                    <option value="">Select Vehicle</option>
				                    <?php 
				                    for ($i=0; $i <$countcustomerVehicles ; $i++) { 
				                    $customerVehicleType = $customerVehicles[$i]['vehicle_typ_sub_id'];
				                    $VehicleReg = $customerVehicles[$i]['registration_no'];

				                    // getting vehicle type name
				                    $VehiclesName = Yii::$app->db->createCommand("
				                      SELECT *
				                      FROM vehicle_type_sub_category
				                      WHERE vehicle_typ_sub_id = '$customerVehicleType'
				                      ")->queryAll();
				                     ?>
				                    <option value="<?php echo $customerVehicles[$i]['customer_vehicle_id']; ?>"><?php echo $VehiclesName[0]['name']." - ".$VehicleReg; ?> </option>
				                    <?php } ?>
				                  </select>
				                </div>
				                <div class="form-group" id="types">
				                	<label>Select Type</label>
				                	<select id="item_type" class="form-control">
				                		<option value="">Select Type</option>
				                		<option value="Service">Service</option>
				                		<option value="Stock">Stock</option>
				                	</select>
				                </div>
				                <div id="servic" style="display: none;">
					                <div class="form-group">
					                  <label>Select Service</label>
					                  <select name="services" class="form-control" id="services">
					                    <option value="">Select Service</option>
					                    <?php 

					                    for ($j=0; $j <$countServices ; $j++) { 
					                    ?>
					                    <option value="<?php echo $services[$j]['services_id']; ?>"><?php echo $services[$j]['name'];?></option>
					                    <?php } ?>
					                  </select>
					                </div>
					                <div class="form-group">
					                  <label>Amount</label>
					                  <input type="text" name="amount" class="form-control" id="price" readonly="" >
					                </div>
				                </div>
				                <!-- services div -->
				                <div id="stock" style="display: none;">
					                <div class="form-group">
					                  <label>Barcode </label>
					                  <input type="text" id="barcode" class="form-control">
					                </div>
					                <div class="form-group">
					                  <label>Amount</label>
					                  <input type="text" class="form-control" id="selling_price" readonly="" >
					                </div>
				                </div>
				                <!-- stock div -->
				                <input type="hidden" id="service_name" >
				                <input type="hidden" id="stock_name">
								<input type="hidden" id="vehicle_name" >
				            </div>
				          </div>
						</div>
					</div>
                    </div>
                    <div class="col-md-8" >

                      <div class="row" id="mydata" style="display: none;">
							<div class="col-md-12">
								<table class="table table-bordered" id="myTableData">
									<thead>
                    <th style="background-color: skyblue">Sr #</th>
											<th style="background-color: skyblue">Vehicle </th>
											<th style="background-color: skyblue">Item</th>
											<th style="background-color: skyblue">Type</th>
											<th style="background-color: skyblue">Amount</th>
										
									</thead>
									<tbody>
										
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
					<input type="text" name="discount" class="form-control" id="disc" value="0">
					<input type="hidden" id="name" >
					<input type="hidden" id="vehicle_name" >
				</div>
                <div class="form-group">
                  <label>Net Total</label>
                  <input type="text" name="net_total" class="form-control" id="nt"readonly="" onfocus="discountFun()">
                </div>
                <div class="form-group">
                  <label>Paid</label>
                  <input type="text" name="paid" class="form-control"  id="paid">
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
	
	let vehicleArray 				= new Array();
	let serviceArray 				= new Array();
	let amountArray 				= new Array();
	let ItemTypeArray       = new Array();
	let user_id = <?php echo $id; ?>;
	let customer_id        = <?php echo $customerID; ?>;
	let rIndex;
	let table;
	let index = 1;
	//var invoice_id 					= <?php //echo $saleInvoiceID; ?>;
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
      function deleteRow(tableID) 
      {
            try {
            var table = document.getElementById('myTableData');
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox&& true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }
      function cal_remaining(){
      	var paid = $('#paid').val();
      	var nt = $('#nt').val();
      	var remaining =nt - paid;
      	$('#remaining').val(remaining); 
      	if (remaining ==0) {
      		$('#status').val('paid');
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
$url = \yii\helpers\Url::to("customer/fetch-info");


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
		 else{
		 	$('#stock').hide();
		 	$('#servic').hide();
		 }
	});


	$("#services").change(function(){
		var serviceID = $("#services").val();
		//alert(serviceID);
		$.ajax({
	        type:'post',
	        data:{serviceID:serviceID},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	
           $('#price').val(jsonResult[0]['price']);
           $('#service_name').val(jsonResult[0]['name']);

            var totalAmount = parseInt($('#tp').val());
				    var tprice = jsonResult[0]['price'];
				    var tp = parseInt(totalAmount)+parseInt(tprice);
				    $('#tp').val(tp);

				    var vehicle 						= $('#vehicle').val();
						var services 						= $('#services').val();
						var price 							= $('#price').val();
						var servicesName				=$('#service_name').val();
						var reg_name 						= $('#vehicle_name').val();
						var type                =$('#item_type').val();
						
						if (vehicle=="" || vehicle==null)
						{
									alert("Select the Vehicle name ");
						}
						else if (services=="" || services==null) {
									alert("Select the Services ");
						}
						else
						{
						vehicleArray.push(vehicle);
						serviceArray.push(services);
						amountArray.push(price);
						ItemTypeArray.push(type);

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
            row.insertCell(0).innerHTML=rowCount;
						row.insertCell(1).innerHTML=reg_name;
						row.insertCell(2).innerHTML= servicesName;
						row.insertCell(3).innerHTML= type;
						row.insertCell(4).innerHTML= price;
						
						

					  // $('#vehicle').val("");
						$('#services').val("");
						$('#remove_index').show();
						for(var i = 1; i < table.rows.length; i++)
			                {
			                    table.rows[i].onclick = function()
			                    {
			                      // get the seected row index
			                      rIndex = this.rowIndex;
			                      document.getElementById("remove_value").value = rIndex;
			                     document.getElementById("removed_value").value = this.cells[1].innerHTML;
			                    };
			                }
				
	}
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

	$("#vehicle").change(function(){
		var vehicle = $("#vehicle").val();
		if(vehicle == null || vehicle ==""){
			$('#types').hide();
		}
		else{
			$('#types').show();
		}
		//alert(vehicle);
		$.ajax({
	        type:'post',
	        data:{vehicle:vehicle},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	 $('#vehicle_name').val(jsonResult[0]['registration_no']);
        	}      
    	}); 
	});

	$("#barcode").change(function(){
		var barcode = $("#barcode").val();
		$.ajax({
	        type:'post',
	        data:{barcode:barcode},
	        url: "$url",
	        success: function(result){
	        	var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	 $('#selling_price').val(jsonResult[0]['selling_price']);
	        	 $('#stock_name').val(jsonResult[0]['name']);

	        	var totalAmount = parseInt($('#tp').val());
				    var tprice = jsonResult[0]['selling_price'];
				    var tp = parseInt(totalAmount)+parseInt(tprice);
				    $('#tp').val(tp);

				    var vehicle 						= $('#vehicle').val();
						var barcode             = jsonResult[0]['stock_id'];
						var stock_price 				= $('#selling_price').val();
						var servicesName				=$('#stock_name').val();
						var reg_name 						= $('#vehicle_name').val();
						var type                =$('#item_type').val();
						
						if (vehicle=="" || vehicle==null)
						{
									alert("Select the Vehicle name ");
						}
						else if (services=="" || services==null) {
									alert("Select the Services ");
						}
						else
						{
						vehicleArray.push(vehicle);
						serviceArray.push(barcode);
						amountArray.push(stock_price);
						ItemTypeArray.push(type);

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
						row.insertCell(0).innerHTML=rowCount;
						row.insertCell(1).innerHTML= reg_name;
						row.insertCell(2).innerHTML= servicesName;
						row.insertCell(3).innerHTML= type;
						row.insertCell(4).innerHTML= stock_price;


					  // $('#vehicle').val("");
						$('#barcode').val("");
						//$('#selling_price').val("");
						$('#barcode').focus();
						$('#remove_index').show();

                
                for(var i = 1; i < table.rows.length; i++)
			                {
			                    table.rows[i].onclick = function()
			                    {
			                      // get the seected row index
			                      rIndex = this.rowIndex;
			                      document.getElementById("remove_value").value = rIndex;
			                       document.getElementById("removed_value").value = this.cells[2].innerHTML;
			                     
			                    };
			                }
				}
        	}      
    	}); 
	});
	$('#remove').click(function(){

		var remove_value1= $('#remove_value').val();
		//alert();
			if(remove_value1 =="" || remove_value1==null){
				alert("Please Select the services to remove");
			}
			else{
			document.getElementById("myTableData").deleteRow(remove_value1);
			var a =amountArray.length - remove_value1;
			//alert(amountArray);
			var nt=$('#tp').val();
			var nta = nt-amountArray[a];
			amountArray.splice(a,1);
			vehicleArray.splice(a,1);
			serviceArray.splice(a,1); 
			
 			ItemTypeArray.splice(a,1);
			$('#remove_value').val("");
			$('#removed_value').val("");
			//alert(amountArray);
			$('#tp').val(nta);
			if(amountArray.length==0){
			$('#mydata').hide();
			$('#remove_index').hide();
			$('#bill_form').hide();
			$('#price').val("");
			$('#vehicle').val("");
			$('#item_type').val("");
			$('#types').hide();
			$('#stock').hide();
			$('#servic').hide();
				
			}
			}
		});



	$('#insert').click(function(){
			var invoice_date = $('#invoice_date').val();
			customer_id;
			vehicleArray;
			serviceArray; 
			amountArray;
 			ItemTypeArray;
 			var total_amount = $('#tp').val();
 			var net_total = $('#nt').val();
 			var paid = $('#paid').val();
		    var remaining = $('#remaining').val();
		    var status = $('#status').val();
			if(invoice_date=="" || invoice_date==null){
				alert('Please Select the date ');
				$('#invoice_date').css("border", "1px solid red");
				$('#invoice_date').focus();
			}
			else if(net_total=="" || net_total==null){
				alert('Please Select the date ');
				$('#nt').css("border", "1px solid red");
				$('#invoice_date').css("border", "1px solid ");
				$('#nt').focus();
			}
					else{
						$.ajax({
			        type:'post',
			        data:{
			        	user_id:user_id,
						vehicleArray:vehicleArray,
	        			invoice_date:invoice_date,
						customer_id:customer_id,
						paid:paid,
						remaining:remaining,
						status:status,
						serviceArray:serviceArray,
						amountArray:amountArray,
						ItemTypeArray:ItemTypeArray,
						total_amount:total_amount,
						net_total:net_total
						
	        	},
	        url: "$url",
	        success: function(result){
	        	//var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
	        	console.log(result);
	        	}      
    	});
					}
				

		});
		
		

JS;
$this->registerJs($script);
?>
<?php 

 if(isset($_POST['insert_collect']))
 {
   $customerID  = $_POST['custID'];
   $invID       = $_POST['invID'];
   $netTotal    = $_POST['net_total'];
   $paid_amount = $_POST['paid_amount'];
   $remaining   = $_POST['remaining'];
   $collect     = $_POST['collect'];
   $status      = $_POST['status'];
   $netTotal    = $_POST['net_total'];

   $id   =Yii::$app->user->identity->id;

     // starting of transaction handling
     $transaction = \Yii::$app->db->beginTransaction();
     try {
      $insert_invoice_head = Yii::$app->db->createCommand()->update('sale_invoice_head',[

     'net_total'        => $netTotal,
     'paid_amount'      => $paid_amount,
     'remaining_amount' => $remaining,
     'status'           => $status,
     'created_by'       => $id,
    ],
       ['customer_id' => $customerID,'sale_inv_head_id' => $invID ]

    )->execute();
     // transaction commit
     $transaction->commit();
        
     } // closing of try block 
     catch (Exception $e) {
      // transaction rollback
         $transaction->rollback();
     } // closing of catch block
     // closing of transaction handling
}

 ?>