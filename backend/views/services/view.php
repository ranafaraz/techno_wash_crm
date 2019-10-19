<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Services */
?>
<div class="services-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'service_id',
            'service_name',
            'description',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
