<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
?>
<div class="employee-view">
<?php 
    $created_by = $model->created_by;
    $emp_type_id = $model->emp_type_id;
    $updated_by = $model->updated_by;
    $branch_id =$model->branch_id;
         
    $createdBy = Yii::$app->db->createCommand("SELECT username FROM user WHERE id = '$created_by'")->queryAll();
     
    if (!empty($createdBy)) {
        $createdBy = $createdBy[0]['username'];
        // $createdBy = $createdBy;
    }
    $updatedBy = Yii::$app->db->createCommand("SELECT username FROM user WHERE id = '$updated_by'")->queryAll();
    if (!empty($updatedBy)) {
        $updatedBy = $updatedBy[0]['username'];
        //$updatedBy = "<span class='label label-default'>$updatedBy</span>";
    }
    else{
        $updatedBy = "<span class='label label-danger'>Not Updated</span>";
    }
    $emp_type_na = Yii::$app->db->createCommand("SELECT emp_type_name FROM employee_types WHERE emp_type_id = '$emp_type_id'")->queryAll();
     $empTypName=$emp_type_na[0]['emp_type_name'];

     $branch_name = Yii::$app->db->createCommand("SELECT branch_name FROM branches WHERE $branch_id = '$branch_id'")->queryAll();
     $branchName=$branch_name[0]['branch_name'];
     
 ?>  
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'emp_id',
           [
             'attribute' => 'emp_type_id',
             'format'=>'raw',
             'value'=>  $empTypName,
            ],
           [
             'attribute' => 'branch_id',
             'format'=>'raw',
             'value'=>  $branchName,
            ],
            
            'salary_id',
            'emp_name',
            'emp_cnic',
            'emp_father_name',
            'emp_contact',
            'emp_email:email',
            'emp_image',
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
             'value'=>  $createdBy,
            ],
               
            [
             'attribute' => 'updated_by',
             'format'=>'raw',
             'value'=>  $updatedBy,
            ],
        ],
    ]) ?>

</div>
