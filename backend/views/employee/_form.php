<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Salary;
use common\models\EmployeeTypes;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use johnitvn\ajaxcrud\CrudAsset; 
use kartik\time\TimePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<html>
<head>
    <title></title>
    <style>  
      #config{
          overflow: auto;
          margin-bottom: 10px;
      }
      .config{
          float: left;
          width: 200px;
          height: 250px;
          border: 1px solid #000;
          margin-left: 10px;
      }
      .config .title{
          font-weight: bold;
          text-align: center;
      }
      .config .barcode2D,
      #miscCanvas{
        display: none;
      }
      #submit{
          clear: both;
      }
      #barcodeTarget {
        margin: 0px;
      }
      #canvasTarget{
        margin-top: 0px;
      }        
    </style>
</head>
<body>
  <div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Employee</h2>
    </div>
  </div>
  <div class="employee-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

   <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
      
      <div class="row">
        <div class="col-md-12">
            <h3 style="font-family:georgia;color:#367FA9;margin-top:0px;">Employee Personal Info</h3>
        </div>
      </div>
      <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-4">                      
            <?= $form->field($model, 'emp_name')->textInput(['maxlength' => true, 'id' => 'ename']) ?> 
         </div>
         <div class="col-md-4">
            <?= $form->field($model, 'emp_father_name')->textInput(['maxlength' => true, 'id' => 'efname']) ?>
         </div>
        <div class="col-md-4">
          <?= $form->field($model, 'emp_contact')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        
        </div>
      </div>
      <!-- row 1 close -->

      <div class="row">
        <div class="col-md-4">
          <?= $form->field($model, 'emp_cnic')->widget(yii\widgets\MaskedInput::class, ['options' => ['id' => 'empCnic', 'onchange' => 'generateBarcode();'], 'mask' => '99999-9999999-9']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'barcode')->hiddenInput(['id' => 'barcode_ID']) ?>
            <div id="barcodeTarget" class="barcodeTarget"></div>
            <canvas id="canvasTarget" width="210" height="90" style="border: none; margin: 0px;"></canvas>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_email')->widget(yii\widgets\MaskedInput::class, [
                'name' => 'input-36',
                'clientOptions' => [
                    'alias' =>  'email'
                ],
            ]) ?>
        </div>
      </div>
      <!-- row 2 close -->

      <div class="row">
        <div class="col-md-4">
          <?= $form->field($model, 'emp_image')->fileInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ]) ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'emp_permanent_address')->textInput(['maxlength' => true, 'id' => 'eper']) ?>
        </div>
      </div>
      <!-- row 3 close -->

      <div class="row">
        <div class="col-md-12">
            <h3 style="font-family:georgia;color:#367FA9;margin-top:0px;">Employee Job Info</h3>
        </div>
      </div>
      <div class="row">
          <div class="col-md-4">
            <label>Employee Joining Date</label>
                  <?= DatePicker::widget([
                  'model' => $model,
                  'attribute' => 'emp_joining_date',
                  'options' => ['placeholder' => 'Select Joining date...'],
                  'pluginOptions' => [
                      'format' => 'yyyy-mm-dd',
                      'todayHighlight' => true,
                      'autoclose' => true
                  ]
              ]);?>

          </div>
          <div class="col-md-4">
           <label>Employee Learning Date</label>
              <?= DatePicker::widget([
              'model' => $model,
              'attribute' => 'emp_learning_date',
              'options' => ['placeholder' => 'Select Learning date...'],
              'pluginOptions' => [
                  'format' => 'yyyy-mm-dd',
                  'todayHighlight' => true,
                  'autoclose' => true
              ]
            ]);?>
          </div> 
          <div class="col-md-4">
            <?= $form->field($model, 'emp_type_id')->dropDownList(
            ArrayHelper::map(EmployeeTypes::find()->all(),'emp_type_id','emp_type_name'),
            ['prompt'=>'Select Position...', 'id' => 'emp_type']
            )?>
          </div> 
          <div class="col-md-4">
            <?= $form->field($model, 'working_hours')->textInput(['maxlength' => true, 'id' => 'working_hours']) ?>
          </div> 
          <div class="col-md-4">
            <?= $form->field($model, 'duty_time_start')->textInput(['maxlength' => true, 'id' => 'duty_time_start']) ?>
          </div> 
          <div class="col-md-4">
            <?= $form->field($model, 'duty_time_end')->textInput(['maxlength' => true, 'id' => 'duty_time_end']) ?>
          </div> 
          <div class="col-md-4">
            <?= $form->field($model, 'monthly_salary')->textInput(['maxlength' => true, 'id' => 'monthly_salary']) ?>
          </div> 
          <div class="col-md-4">
            <?= $form->field($model, 'allowed_leaves')->textInput(['maxlength' => true, 'id' => 'allowed_leaves', 'value'=> 3]) ?>
          </div> 
          <div class="col-md-4">
            <?= $form->field($model, 'shift')->dropDownList([ 'Day Shift' => 'Day Shift', 'Night Shift' => 'Night Shift', ]) ?>
          </div>

      </div>
      <!-- row 4 close -->
    
  	<?php if (!Yii::$app->request->isAjax){ ?>
  	  	<div class="form-group">
              <a href="./employee" class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i> Back</a>
  	        <?= Html::submitButton($model->isNewRecord ? '<i class="    glyphicon glyphicon-floppy-save"></i> Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  	    </div>
  	<?php } ?>

      <?php ActiveForm::end(); ?>
      
  </div>
</body>
</html>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="jquery-barcode.js"></script>
<script type="text/javascript">

    function generateBarcode(){
        var value = $("#empCnic").val();
        var btype = 'codabar';
        var renderer = "canvas";

        var settings = {
          output:renderer,
          bgColor:'#FFFFFF',
          color:'#000000',
          barWidth:1,
          barHeight: 50,
          moduleSize:5 ,
          posX: 10,
          posY: 20,
          addQuietZone: 1,
          canvas:'canvas'
        };
        if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')){
          value = {code:value, rect: true};
        }
        if (renderer == 'canvas'){
          clearCanvas();
          $("#barcodeTarget").hide();
          $("#canvasTarget").show().barcode(value, btype, settings);
        } else {
          $("#canvasTarget").hide();
          $("#barcodeTarget").html("").show().barcode(value, btype, settings);
        }
      }
          
      function showConfig1D(){
        $('.config .barcode1D').show();
        $('.config .barcode2D').hide();
      }
      
      function showConfig2D(){
        $('.config .barcode1D').hide();
        $('.config .barcode2D').show();
      }
      
      function clearCanvas(){
        var canvas = $('#canvasTarget').get(0);
        var ctx = canvas.getContext('2d');
        ctx.lineWidth = 1;
        ctx.lineCap = 'butt';
        ctx.fillStyle = '#FFFFFF';
        ctx.strokeStyle  = '#000000';
        ctx.clearRect (0, 0, canvas.width, canvas.height);
        ctx.strokeRect (0, 0, canvas.width, canvas.height);
      }
      
      $(function(){
        $('input[name=btype]').click(function(){
          if ($(this).attr('id') == 'datamatrix') showConfig2D(); else showConfig1D();
        });
        $('input[name=renderer]').click(function(){
          if ($(this).attr('id') == 'canvas') $('#miscCanvas').show(); else $('#miscCanvas').hide();
        });
        generateBarcode();
      });

</script>

<?php
$script = <<< JS

$('form#{$model->formName()}').on('beforeSubmit',function(e){
    var canvas = document.getElementById("canvasTarget");
    var dataURL = canvas.toDataURL("image/png");
    var d = document.getElementById('barcode_ID').value = dataURL;   
    alert(d);
}); 

$('#emp_type').on('change',function(){
    var emp_type = $('#emp_type').val();

    $.get('./employee/fetch-data',{emp_type : emp_type},function(data){
      var data =  $.parseJSON(data);
         //console.log(data);

      $('#working_hours').val(data[0]['working_hours']);
      $('#duty_time_start').val(data[0]['duty_time_start']);
      $('#duty_time_end').val(data[0]['duty_time_end']);
      $('#monthly_salary').val(data[0]['monthly_salary']);
        
    });        
});

JS;
$this->registerJs($script);
?>
