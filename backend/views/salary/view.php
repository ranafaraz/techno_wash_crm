<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Salary */
?>
<div class="salary-view">
<?php 
    
    $created_by = $model->created_by;
    $updated_by = $model->updated_by;
    $emp_id = $model->emp_id;
    $wage_type_id=$model->wage_type_id;
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
    $emp_name = Yii::$app->db->createCommand("SELECT emp_name FROM employee WHERE emp_id = '$emp_id'")->queryAll();
    $empName=$emp_name[0]['emp_name'];
    
     $wage_name = Yii::$app->db->createCommand("SELECT wage_name FROM wage_type WHERE wage_type_id = '$wage_type_id'")->queryAll();
     $wageName = $wage_name[0]['wage_name'];
 ?> 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'salary_id',
             [
             'attribute' => 'emp_id',
             'format'=>'raw',
             'value'=> $empName,
            ],
            'emp_allowance_id',
            
             [
             'attribute' => 'wage_type_id',
             'format'=>'raw',
             'value'=> $wageName,
            ],
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
    ]) ?>

</div>
