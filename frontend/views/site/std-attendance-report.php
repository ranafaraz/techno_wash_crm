<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- /.box-header -->
<div class="box-body">
<?php  
    $branches = Yii::$app->db->createCommand("SELECT branch_id, branch_name, branch_code FROM branches WHERE status = 'Active'")->queryAll();
    $branchCount = count($branches);
    if ($branchCount > 1) {
        $branchName1 = $branches[0]['branch_name'];
        $branchCode1 = $branches[0]['branch_code'];
        $branchName2 = $branches[1]['branch_name'];
        $branchCode2 = $branches[1]['branch_code'];            
    }
    else{
        $branchName1 = $branches[0]['branch_name'];
        $branchCode1 = $branches[0]['branch_code'];
    }
    // Main Branch Queries...
    $stdPresentsArray  = Array();
    $stdAbsentsArray  = Array();
    $stdLeavesArray   = Array();
    $expenseSub  = Array();
    for ($i=1; $i <=12; $i++) { 
        $month = date('Y-').$i;
        if ($month == "2019-10") {
            $month = date('Y-').$i;
        }else if ($month == "2019-11") {
            $month = date('Y-').$i;
        }else if ($month == "2019-12") {
            $month = date('Y-').$i;
        }
        else{
            $month = date('Y-').'0'.$i;
        }
        // getting std-attendance of present students...
        $stdPresents = Yii::$app->db->createCommand("SELECT COUNT(status) FROM std_attendance WHERE branch_id = 5 AND status = 'P' AND DATE_FORMAT(date ,'%Y-%m') = '$month'")->queryAll();
        $stdPresentArray[$i] = $stdPresents[0]['COUNT(status)'];
        // getting std-attendance of absent students...
        $stdAbsents = Yii::$app->db->createCommand("SELECT COUNT(status) FROM std_attendance WHERE branch_id = 5 AND status = 'A' AND DATE_FORMAT(date ,'%Y-%m') = '$month'")->queryAll();
        $stdAbsentsArray[$i] = $stdAbsents[0]['COUNT(status)'];
        // getting std-attendance of absent students...
        $stdLeaves = Yii::$app->db->createCommand("SELECT COUNT(status) FROM std_attendance WHERE branch_id = 5 AND status = 'L' AND DATE_FORMAT(date ,'%Y-%m') = '$month'")->queryAll();
        $stdLeavesArray[$i] = $stdLeaves[0]['COUNT(status)'];
        // $expense = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 5 AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
        // $expenseMain[$i] = $expense[0]['date'];
        // // income/expense sub branch...
        // $incomee = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 6 AND account_nature = 'Income' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
        // $incomeSub[$i] = $incomee[0]['date'];
        // //var_dump($income);
        // $expensee = Yii::$app->db->createCommand("SELECT SUM(total_amount) date FROM account_transactions WHERE branch_id = 6 AND account_nature = 'Expense' AND CAST(date AS DATE) >= '$month-01' AND CAST(date AS DATE) <= '$month-31'")->queryAll();
        // $expenseSub[$i] = $expensee[0]['date'];

    }
    print_r($stdPresents);

    die();

    // income main branch....
    $incomeLength = count($stdPresents);
    for ($i=1; $i <=$incomeLength; $i++) { 
        if ($stdPresentsArray[$i] == NULL) {
            $stdPresentsArray[$i] = 0;
        }
    }
    $stdTotalPresents = implode(',', $$stdPresentsArray);
    ;
    // expense main branch...
    $expenseLength = count($expenseMain);
    for ($i=1; $i <=$expenseLength; $i++) { 
        if ($expenseMain[$i] == NULL) {
            $expenseMain[$i] = 0;
        }
    }
    $netExpense = implode(',', $expenseMain);
    // income sub branch...
    $incomeLengthSub = count($incomeSub);
    for ($j=1; $j <=$incomeLengthSub; $j++) { 
        if ($incomeSub[$j] == NULL) {
            $incomeSub[$j] = 0;
        }
    }
    $netIncomeSub = implode(',', $incomeSub);
    // expense sub branch...
    $expenseLengthSub = count($expenseSub);
    for ($k=1; $k <=$expenseLengthSub; $k++) { 
        if ($expenseSub[$k] == NULL) {
            $expenseSub[$k] = 0;
        }
    }
    $netExpenseSub = implode(',', $expenseSub);
    // expense sub branch...
?>  
  <!-- DONUT CHART -->
  <!-- BAR CHART -->
  <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title" style="color: #04e27b;"><i class="fa fa-pie-chart" aria-hidden="true"></i>
                Overall Income/Expense <small style="color: #04e27b;"> Session 2019</small>
            </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" style="color: #04e27b;"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" style="color: #DD4B39;"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
            <div id="container3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
        <!-- /.box-body -->
      </div>
  </div>
  <!-- /.box -->
  <div class="col-md-6">
      <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title" style="color: #DD4B39;"><i class="fa fa-pie-chart" aria-hidden="true"></i>
                <?php echo $branchName1." - ".$branchCode1; ?> Income/Expense<small style="color: #DD4B39;"> Session 2019</small>
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
  <!-- DONUT CHART -->
  <div class="col-md-6">
      <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title" style="color: #00C0EF;"><i class="fa fa-pie-chart" aria-hidden="true"></i>
               <?php echo $branchName2." - ".$branchCode2; ?> Income/Expense <small style="color: #00C0EF;"> Session 2019</small>
            </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" style="color: #04e27b;"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" style="color: #DD4B39;"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12 col-sm-12" id="container2"></div>
        </div>
        <!-- /.box-body -->
      </div>
  </div>
  <!-- /.box -->
</div>
<!-- /.box-body -->
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
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} PKR</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Amount',
        data: [
            <?php if ($totalIncomeMain > $totalExpenseMain) { $status = "Profit"; } else { $status = "Loss"; }; ?>
            ['<b>Income</b>', <?php echo $totalIncomeMain; ?>],
            ['<b>Expence</b>', <?php echo $totalExpenseMain; ?>],
            ['<b><?php echo $status ?></b>', <?php echo (abs($remainingMain)); ?>],
        ]
    }]
});
// Current Month Income/Expense of Main Branch close....
// -----------------------------------------------------
// Current Month Income/Expense of Sub Branch start....
Highcharts.chart('container2', {
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
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} PKR</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Amount',
        data: [
            <?php if ($totalIncomeSub > $totalExpenseSub) { $status = "Profit:"; } else { $status = "Loss:"; }; ?>
            ['<b>Income:</b>', <?php echo $totalIncomeSub; ?>],
            ['<b>Expence:</b>', <?php echo $totalExpenseSub; ?>],
            ['<b><?php echo $status ?></b>', <?php echo (abs($remainingSub)); ?>],
        ]
    }]
});
// Current Month Income/Expense of Sub Branch close....
// ----------------------------------------------------
// Bar Chart start...
// ----------------------------------------------------
</script>
<script>
Highcharts.chart('container3', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Month Wise Income/Expense'
    },
    // subtitle: {
    //     text: 'Source: WorldClimate.com'
    // },
    xAxis: {
        categories: [
            '<b>January</b>',
            '<b>Febuary</b>',
            '<b>March</b>',
            '<b>April</b>',
            '<b>May</b>',
            '<b>June</b>',
            '<b>July</b>',
            '<b>August</b>',
            '<b>September</b>',
            '<b>October</b>',
            '<b>November</b>',
            '<b>December</b>'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: '<b>Amount</b>'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} PKR</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Income Main Branch',
        data: [<?php echo $netIncome; ?>]

    }, {
        name: 'Expense Main Branch',
        data: [<?php echo $netExpense; ?>]

    },{
        name: 'Income Sub Branch',
        data: [<?php echo $netIncomeSub; ?>]

    }, {
        name: 'Expense Sub Branch',
        data: [<?php echo $netExpenseSub; ?>]

    }, 
    ]
});
</script>