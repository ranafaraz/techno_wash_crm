<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!DOCTYPE html>
<html>
<head>
	<title>Balance Sheet</title>
</head>
<body>
<div class="container-fluid" style="margin-top: -30px;">  
  <div class="row">
    <div class="col-md-12">
      <h2 class="well well-sm" align="center" style="font-family: serif;"><b><i>Balance Sheet</i></b></h2>
    </div>
  </div>
  <div class="row">
    <form method="post" action="">
      <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                </div>    
            </div>    
        </div>
      <div class="col-md-3">
       <label>Start Date:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar" style="color: #3C8DBC"></i>
          </div>
          <input type="date" class="form-control" name="start_date" required="">
        </div>
      </div>
      <div class="col-md-3">
       <label>End Date:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar" style="color: #3C8DBC"></i>
          </div>
          <input type="date" class="form-control" name="end_date" required="">
        </div>
      </div>
      <div class="col-md-3">
        <label>Branch Name:</label>
          <select class="form-control" name="branch_id" id="classId" required="required">
            <option>Select Branch</option>
                <?php 
                    $branches = Yii::$app->db->createCommand("SELECT * FROM branches where delete_status=1")->queryAll();
                        foreach ($branches as $value) { ?>    
                        <option value="<?php echo $value['branch_id']; ?>">
                            <?php echo $value["branch_name"]; ?> 
                        </option>
                <?php } ?> 
          </select>          
      </div>
      <div class="col-md-3" style="margin-top: 25px">
        <button type="submit" name="submit" class="btn btn-success btn-flat btn-block">
          <i class="fa fa-bar-chart"></i><b> Get Statistics</b>
        </button>
      </div>
    </form>    
  </div>
  <?php  
  $totalIncome = $totalExpense = 0;
    if (isset($_POST['submit'])) {
      $start_date = $_POST['start_date'];
      $end_date   = $_POST['end_date'];
      $branch_id  = $_POST['branch_id'];     
      // getting user branch_id....
      //$branch_id = Yii::$app->user->identity->branch_id;
      // getting income...
      $dates = Yii::$app->db->createCommand("SELECT DISTINCT CAST(date AS DATE) FROM account_transactions WHERE branch_id = '$branch_id' AND CAST(date AS DATE) >= '$start_date' AND CAST(date AS DATE) <= '$end_date'")->queryAll();
      $countDate = count($dates);
      // getting branch name....
      $branches = Yii::$app->db->createCommand("SELECT branch_name,branch_code FROM branches WHERE branch_id = '$branch_id' AND delete_status = 1")->queryAll();
      $branchName = $branches[0]['branch_name'];
      $branchCode = $branches[0]['branch_code']; 
      // getting income of the selected branch....
      $income = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = '$branch_id' AND account_nature = 'Income' AND CAST(date AS DATE) >= '$start_date' OR CAST(date AS DATE) <= '$end_date'")->queryAll();
      $totalIncomeMain = $income[0]['date'];
      // getting expense of the selected branch....
      $expense = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = '$branch_id' AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$start_date' OR CAST(date AS DATE) <= '$end_date'")->queryAll();
      $totalExpenseMain = $expense[0]['date'];
      $remainingMain = $totalIncomeMain -$totalExpenseMain;
  ?>
  <!-- Income -->
  <div class="row">
    <div class="col-md-12">
      <h2 class="well-sm bg-navy" align="center" style="font-family: serif;">
        <b><i><?php echo "<span class='text-aqua'>from</span> ".date("d-M-Y", strtotime($start_date))." <span class='text-aqua'>to</span> ".date("d-M-Y", strtotime($end_date)); ?></i></b>
      </h2>
    </div>
    <!-- DONUT CHART -->
    <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title" style="color: green;"><i class="fa fa-pie-chart" aria-hidden="true"></i>
                  <?php echo $branchName." - ".$branchCode; ?> Income/Expense<small style="color: #04e27b;"> Session 2019</small>
              </h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" style="color: #04e27b;"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" style="color: #DD4B39;"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="col-md-12 col-sm-12" id="container1"></div>
          </div>
          <!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->
    
    <div class="col-md-4">
      <table class="table table-responsive table-bordered table-striped table-hover">
        <thead>
          <tr class="info">
            <th colspan="4" class="text-center">
              <b><i>Income Statment / Date</i></b>
            </th>
          </tr>
          <tr class="bg-navy">
            <th><i>Sr. #</i></th>
            <th><i>Date</i></th>
            <th class="text-center"><i>Amount</i></th>
          </tr>
        </thead>
        <tbody>
          <?php $totalIncome = $totalExpense = 0; ?>
          <?php 
            foreach($dates as $key => $value) {
              $date = $value['CAST(date AS DATE)'];
              //echo $date;
              $income = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = '$branch_id' AND account_nature = 'Income' AND CAST(date AS DATE) = '$date'")->queryAll();
              $income = $income[0]['date'];
              if (!empty($income)) {
          ?>
          <tr>
            <td width="55px" class="text-center">
              <b><i><?php echo $key+1; ?></i></b>
            </td>
            <td><i><?php echo date("d-M-Y", strtotime($value['CAST(date AS DATE)'])); ?></i></td>
            <td align="center"><i><?php echo number_format($income, 0); ?></i></td>
          </tr>
          <?php 
                $totalIncome += $income;
              }
              // ending of if...
            }
            // ending of foreach...
          ?>
          <tr class="success">
            <td colspan="2" align="center"><b><i>Total Income</b></i></td>
            <td align="center"><b><i><?php echo number_format($totalIncome, 0); ?></i></b></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Expense -->
    <div class="col-md-4">
      <table class="table table-responsive table-bordered table-striped table-hover">
        <thead>
          <tr class="info">
            <th colspan="4" class="text-center">
              <b><i>Expense Statment / Date</i></b>
            </th>
          </tr>
          <tr class="bg-navy">
            <th><i>Sr. #</i></th>
            <th><i>Date</i></th>
            <th class="text-center"><i>Amount</i></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            foreach($dates as $key => $value) {
              $date = $value['CAST(date AS DATE)'];
              //echo $date;
              $expense = Yii::$app->db->createCommand("SELECT SUM(total_amount) FROM account_transactions WHERE branch_id = '$branch_id' AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$date'")->queryAll();
              $expense = $expense[0]['SUM(total_amount)'];
              if (!empty($expense)) {
          ?>
          <tr>
            <td width="55px" class="text-center">
              <b><i><?php echo $key+1; ?></i></b>
            </td>
            <td><i><?php echo date("d-M-Y", strtotime($value['CAST(date AS DATE)'])); ?></i></td>
            <td align="center"><i><?php echo number_format($expense, 0); ?></i></td>
          </tr>
          <?php 
                $totalExpense += $expense;
              }
              // ending of if...
            }
            // ending of foreach...
          ?>
          <tr class="danger">
            <td colspan="2" align="center"><b><i>Total Expense</b></i></td>
            <td align="center"><b><i><?php echo number_format($totalExpense, 0); ?></i></b></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Expense Close -->
    <!-- Balance Start -->
    <div class="col-md-4">
      <table class="table table-responsive table-striped table-bordered table-hover">
        <tbody>
          <tr class="info">
            <th colspan="4" class="text-center">
              <b><i>Balance Statment</i></b>
            </th>
          </tr>

          <tr class="bg-navy">
            <th class="text-center"><i>Description</i></th>
            <th class="text-center"><i>Amount</i></th>
          </tr>
          <tr class="success">
            <td class="text-center"><i>Total Income</i></td>
            <th class="text-center"><i><?php echo number_format($totalIncome, 0); ?></i></th>
          </tr>
          <tr class="danger">
            <td class="text-center"><i>Total Expense</i></td>
            <th class="text-center"><i><?php echo number_format($totalExpense, 0); ?></i></th>
          </tr>
          <tr class="warning">
            <th class="text-center"><i>Remaining Balance</i></th>
            <th class="text-center"><i><?php echo number_format($totalIncome - $totalExpense, 0); ?></i></th>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Balance Close -->
  </div>
</div>
<?php 
  } 
  // ending of isset...
 ?>
  <!-- table close -->
</div>
</body>
</html>

<?php $month = date('Y-m'); ?>
<script>
// Current Month Income/Expense of Main Branch start....
Highcharts.chart('container1', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Current Month (<?php echo date("F", strtotime("$month")); ?>)'
    },
    // subtitle: {
    //     text: 'anything'
    // },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Amount',
        data: [
            <?php if ($totalIncome > $totalExpense) { $status = "Profit"; } else { $status = "Loss"; }; ?>
            ['<b>Income</b>', <?php echo $totalIncome; ?>],
            ['<b>Expence</b>', <?php echo $totalExpense; ?>],
            ['<b><?php echo $status ?></b>', <?php echo (abs($totalIncome - $totalExpense)); ?>],
        ]
    }]
});
</script>