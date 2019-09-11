<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Manufacture */
?>
<div class="manufacture-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'manufacture_id',
            'name',
            'description:ntext',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
