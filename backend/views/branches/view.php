<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Branches */
$branchName = $model->branch_name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#367FA9;margin-top:0px;">View Branch (<b><?php echo $branchName; ?></b>)</h2>
    </div>
</div>
<div class="branches-view" style="background-color:#efefef;padding:20px;border-top:3px solid #367FA9;">
<?php 

    $created_by = $model->created_by;
    $updated_by = $model->updated_by;
    $org_id=$model->org_id;
    $org_name = Yii::$app->db->createCommand("SELECT org_name FROM organization WHERE org_id = '$org_id'")->queryAll();    
    $org_namee =$org_name[0]['org_name'];

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
    
 ?>
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'branch_id',
            [
             'attribute' => 'org_id',
             'format'=>'raw',
             'value'=>  $org_namee,
            ],
            'branch_code',
            'branch_name',
            'branch_type',
            'branch_location',
            'branch_contact_no',
            'branch_email:email',
            'status',
            'branch_head_name',
            'branch_head_contact_no',
            'branch_head_email:email',
            'created_at',
            'updated_at',
            //'delete_status',
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
