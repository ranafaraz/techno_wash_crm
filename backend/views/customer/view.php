<?php
 
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
$customerName = $model->customer_name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">View Customer (<b><?php echo $customerName; ?></b>)</h2>
    </div>
</div>
<div class="customer-view" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">

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
            //'customer_id',
            'branch.branch_name',
            'customer_name',
            'customer_gender',
            'customer_cnic',
            'customer_address',
            'customer_contact_no',
            'customer_registration_date',
            'customer_age',
            'customer_email:email',
            'customer_image',
            'customer_occupation',
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
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
