<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CardType */
$cardName = $model->card_name;
?>
<div class="row">
    <div class="col-md-12">
        <h2 style="text-align: center;font-family:georgia;color:#FAB61C;margin-top:0px;">View Card (<b><?php echo $cardName; ?></b>)</h2>
    </div>
</div>
<div class="card-type-view" style="background-color:#ffe1a3;padding:20px;border-top:4px solid #FAB61C;">
<?php 
    
    $created_by = $model->created_by;
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
 ?>
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'card_type_id',
            'card_name',
            'card_description:ntext',
            'card_price',

            'card_services',
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
