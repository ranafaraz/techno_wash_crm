<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
$empName = $model->emp_name;
$empImage = $model->emp_image;
$branch_id = $model->branch_id;
?>
<div class="row">
    <div class="col-md-6">
        <h2 style="text-align:center;font-family:georgia;color:#367FA9;margin-top:10px;vertical-align:middle;">View Employee (<b><?php echo $empName; ?></b>)</h2>        
    </div>
    <div class="col-md-6">
        <img src="<?=$empImage?>" alt="Employee Image" class="img-circle" style="width:100px; height:80px;float: right;" />        
    </div>

</div>
<div class="employee-view" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

    <?php
    
    $created_by = $model->created_by; // get the created_by (id)
    $updated_by = $model->updated_by;  // get the updated_by (id)

    $branchName = Yii::$app->db->createCommand("SELECT branch_name FROM branches WHERE branch_id = '$branch_id'")->queryAll();

    // query to get the username by created_by (id) from table user
    $createdBy = Yii::$app->db->createCommand("SELECT username FROM user WHERE id = '$created_by'")->queryAll();
    if (!empty($createdBy)) {
        $createdBy = $createdBy[0]['username'];
        // $createdBy = $createdBy;
    }

    // query to get the username by updated_by (id) from table user
    $updatedBy = Yii::$app->db->createCommand("SELECT username FROM user WHERE id = '$updated_by'")->queryAll();
    if (!empty($updatedBy)) {
        $updatedBy = $updatedBy[0]['username'];
        //$updatedBy = "<span class='label label-default'>$updatedBy</span>";
    }
    else{
        $updatedBy = "<span class='label label-danger'>Not Updated</span>";
    }
    
 ?>
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'emp_id',          
            'empType.emp_type_name',
            //'branch.branch_name',
            [
             'attribute' => 'branch_id',
             'format'=>'raw',
             'value'=> $branchName,
            ],
            'salary_id',
            'emp_name',
            'emp_father_name',
            'emp_cnic',            
            'emp_contact',
            'emp_email:email',
            //'emp_image',
            'emp_gender',
            'emp_qualification',
            'emp_reference',
            'joining_date',
            'learning_date',
            'status',            
            'created_at',
            'updated_at',
            [
             'attribute' => 'created_by',
             'format'=>'raw',
             'value'=> $createdBy,
            ],  
            [
             'attribute' => 'updated_by',
             'format'=>'raw',
             'value'=>  $updatedBy,
            ],
        ],
    ]); ?>

</div>
