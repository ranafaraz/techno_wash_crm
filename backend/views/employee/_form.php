<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Salary;
use common\models\EmployeeTypes;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use johnitvn\ajaxcrud\CrudAsset; 


/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">Create New Employee</h2>
        </div>
</div>
<div class="employee-form" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'dynamic-form']]); ?>
    <div class="row" style="margin-bottom: 10px;">
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
               <?= $form->field($model, 'emp_status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ]) ?>
           </div>   
    </div>
    <!-- row 1 close -->
    <div class="row">
        <div class="col-md-4">
                <?= $form->field($model, 'emp_type_id')->dropDownList(
                ArrayHelper::map(EmployeeTypes::find()->all(),'emp_type_id','emp_type_name'),
                ['prompt'=>'Select Position...', 'id' => 'eti']
                )?>
       </div>
       <div class="col-md-4">                      
            <?= $form->field($model, 'emp_name')->textInput(['maxlength' => true, 'id' => 'ename']) ?> 
       </div>
       <div class="col-md-4">
            <?= $form->field($model, 'emp_father_name')->textInput(['maxlength' => true, 'id' => 'efname']) ?>
       </div>
    </div>
    <!-- row 2 close -->

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
            <?= $form->field($model, 'emp_contact')->widget(yii\widgets\MaskedInput::class, [ 'mask' => '+99-999-9999999', ]) ?>
        
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'emp_email')->textInput(['maxlength' => true , 'id' => 'email']) ?>
        </div>
    </div>
    <!-- row 3 close -->

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
    <!-- row 4 close -->
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
            <a href="./employee" class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i> Back</a>
	        <?= Html::submitButton($model->isNewRecord ? '<i class="    glyphicon glyphicon-floppy-save"></i> Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
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
         alert(barcodeTarget); 
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