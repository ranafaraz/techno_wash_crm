<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Membership */
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">View Membership</h2>
    </div>
</div>
<div class="membership-view" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

<?php
    $created_by = $model->created_by; // get the created_by (id)
    $updated_by = $model->updated_by;  // get the updated_by (id)

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
            //'membership_id',
            'cardType.card_name',
            'customer.customer_name',
            'customerVehicle.registration_no',
            'membership_start_date',
            'membership_end_date',
            'card_issued_by',
            'car_registration_no',
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
