<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Units */
?>
<div class="units-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'unit_id',
            'unit_name',
            'unit_description',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
