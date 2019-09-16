<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SaleInvoiceHead */
?>
<div class="sale-invoice-head-view">
<?php 
    $created_by = $model->created_by;
    $customer_id = $model->customer_id;
    $updated_by = $model->updated_by;
    
         
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
    $customer_name = Yii::$app->db->createCommand("SELECT customer_name FROM customer WHERE customer_id = '$customer_id'")->queryAll();
      $customerName=$customer_name[0]['customer_name'];

    //  $branch_name = Yii::$app->db->createCommand("SELECT branch_name FROM branches WHERE $branch_id = '$branch_id'")->queryAll();
    //  $branchName=$branch_name[0]['branch_name'];
     
 ?>  
  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'sale_inv_head_id',
            [
             'attribute' => 'customer_id',
             'format'=>'raw',
             'value'=>  $customerName,
            ],
            'date',
            'total_amount',
            'discount',
            'net_total',
            'paid_amount',
            'remaining_amount',
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
