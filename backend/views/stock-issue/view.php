<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StockIssue */
?>
<div class="stock-issue-view">
<?php 
    $created_by = $model->created_by;
    $emp_id = $model->emp_id;
    $updated_by = $model->updated_by;
    $stock_id =$model->stock_id;
         
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

     $stock_name = Yii::$app->db->createCommand("SELECT name FROM stock WHERE stock_id = '$stock_id'")->queryAll();
     $stockName=$stock_name[0]['name'];
     
 ?>  
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'stock_issue_id',
             [
             'attribute' => 'emp_id',
             'format'=>'raw',
             'value'=>  $empName,
            ],
            
            [
             'attribute' => 'stock_id',
             'format'=>'raw',
             'value'=>  $stockName,
            ],
            'stock_issue_date',
            'description',
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
