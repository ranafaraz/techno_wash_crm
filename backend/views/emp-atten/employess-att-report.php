<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<form method="POST" action="employess-att-report">
			<input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">
			<div class="col-md-3">
				<div class="form-group">
					<label><i class="glyphicon glyphicon-calendar"></i> Select Month</label>
					<input type="month" name="att_month" class="form-control">
				</div>
			</div>
			<div class="col-md-3">
				<button type="submit" name="report" class="btn btn-success" style="margin-top:25px;"><i class="glyphicon glyphicon-eye-open"></i> View Report</button>
			</div>
		</form>
	</div>
    <?php   
    if(isset($_POST['report'])){ 
        $mon = $_POST['att_month'];
        $currentMonth = date("Y - F", strtotime($mon));
        $month  = date("m", strtotime($mon));
        $year  = date("Y", strtotime($mon));
        $days = cal_days_in_month(CAL_GREGORIAN, $month,$year);
        //fetching employees
        $branch_id = Yii::$app->user->identity->branch_id;
        $empInfo = Yii::$app->db->createCommand("SELECT * FROM emp_info WHERE emp_branch_id = '$branch_id'")->queryAll();
        $countEmp = count($empInfo);

    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header label-success">
                    <h3 class="box-title">Employee Attedance</h3>
                    <h3 class="box-title" style="float: right;"><?php echo "Attendance ( ".$currentMonth." )"; ?></h3>
                </div>
                <!-- /.box-header -->
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr style="background-color:#008D4C;color:white;">
                            <th>Sr.#</th>
                            <td style="padding:2px 0px 2px 0px;">Name</td>
                            <?php for ($i=1; $i<=$days; $i++) { 
                                   $var = $year."-".$month."-".$i;
                                    $day  = date('Y-m-d',strtotime($var));
                                   $result = date("D", strtotime($day)); ?>
                            <td style="padding:1px 1px;"><?php echo date("d", strtotime($day)); ?><br><?php echo $result; ?></td>
                            <?php } ?>
                            <td>P</td>
                            <td>A</td>
                            <td>L</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        for($i=0; $i <$countEmp ; $i++){
                            $empName = $empInfo[$i]['emp_name'];
                            $empID = $empInfo[$i]['emp_id'];
                            $presentCount = 0;
                            $absentCount = 0;
                            $leaveCount = 0;
                         ?>
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td style="padding:0px ;width: 5px;"><?php echo $empName; ?></td>
                            <?php for ($j=1; $j <=$days ; $j++) {
                                $var = $year."-".$month."-".$j;
                                $day  = date('Y-m-d',strtotime($var));
                                $result = date("D", strtotime($day));
                                // print_r($day);
                                // echo "<br>";
                                $empatt = Yii::$app->db->createCommand("SELECT * FROM emp_attendance WHERE branch_id = '$branch_id' AND emp_id = '$empID' AND att_date = '$day'")->queryAll();
                                
                                if ($result == 'Sun') {
                                     echo "<td class='danger' style='padding:1px 1px;'></td>";
                                 } 
                                else if (empty($empatt)) {
                                    echo "<td style='padding:1px 1px;'></td>";
                                }
                                else{
                                    echo "<td style='padding:1px 1px;'>".$empatt[0]['attendance']."</td>";
                                    if ($empatt[0]['attendance'] == 'P') {
                                        $presentCount++;

                                    }
                                    if ($empatt[0]['attendance'] == 'A') {
                                        $absentCount++;
                                    }
                                    if ($empatt[0]['attendance'] == 'L') {
                                        $leaveCount++;
                                    }
                                }
                                 ?>
                            <?php } ?>
                            <td class="success">
                                <?php echo $presentCount; ?> 
                            </td>
                            <td class="warning">
                                <?php echo $absentCount; ?>
                            </td>
                            <td class="info">
                                <?php echo $leaveCount; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
</body>
</html>