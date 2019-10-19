<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Products */
?>
<div class="products-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_id',
            'manufacture_id',
            'product_name',
            'description:ntext',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
